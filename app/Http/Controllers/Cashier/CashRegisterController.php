<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\CashRegisterSession;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class CashRegisterController extends Controller
{
    private function currentUser(): ?User
    {
        return User::where('email', session('auth_user'))->first();
    }

    public function openForm()
    {
        $authUser = $this->currentUser();

        if (!$authUser) {
            return redirect()->route('login')->with('error', 'Session expirée. Reconnectez-vous.');
        }

        if (CashRegisterSession::openFor($authUser->email)) {
            return redirect()->route('cashier.payment')
                ->with('error', 'Vous avez déjà une session de caisse ouverte.');
        }

        $recentSessions = CashRegisterSession::where('cashier_email', $authUser->email)
            ->orderByDesc('opened_at')
            ->take(5)
            ->get();

        return view('cashier.register.open', compact('authUser', 'recentSessions'));
    }

    public function store(Request $request)
    {
        $authUser = $this->currentUser();

        if (!$authUser) {
            return redirect()->route('login')->with('error', 'Session expirée. Reconnectez-vous.');
        }

        if (CashRegisterSession::openFor($authUser->email)) {
            return redirect()->route('cashier.payment')
                ->with('error', 'Vous avez déjà une session de caisse ouverte.');
        }

        $request->validate([
            'opening_amount' => 'required|numeric|min:0',
        ]);

        CashRegisterSession::create([
            'cashier_email' => $authUser->email,
            'cashier_name' => $authUser->name,
            'opening_amount' => $request->opening_amount,
            'opened_at' => now(),
            'status' => 'open',
        ]);

        ActivityLog::record('system', 'Register Opened', 'Fond de caisse : ' . number_format($request->opening_amount, 0) . ' XAF');

        return redirect()->route('cashier.payment')->with('success', 'Caisse ouverte. Bonne vente !');
    }

    public function closeForm()
    {
        $authUser = $this->currentUser();

        if (!$authUser) {
            return redirect()->route('login')->with('error', 'Session expirée. Reconnectez-vous.');
        }

        $session = CashRegisterSession::openFor($authUser->email);

        if (!$session) {
            return redirect()->route('cashier.register.open')
                ->with('error', 'Aucune caisse ouverte à fermer.');
        }

        $sales = Sale::where('register_session_id', $session->id)
            ->where('status', 'completed')
            ->get();

        $expectedCash = $session->opening_amount + $sales->where('payment_method', 'cash')->sum('total');
        $expectedMobile = $sales->where('payment_method', 'mobile_money')->sum('total');
        $expectedCard = $sales->where('payment_method', 'card')->sum('total');

        return view('cashier.register.close', [
            'session' => $session,
            'salesCount' => $sales->count(),
            'expectedCash' => $expectedCash,
            'expectedMobile' => $expectedMobile,
            'expectedCard' => $expectedCard,
        ]);
    }

    public function closeStore(Request $request)
    {
        $authUser = $this->currentUser();

        if (!$authUser) {
            return redirect()->route('login')->with('error', 'Session expirée. Reconnectez-vous.');
        }

        $session = CashRegisterSession::openFor($authUser->email);

        if (!$session) {
            return redirect()->route('cashier.register.open')
                ->with('error', 'Aucune caisse ouverte à fermer.');
        }

        $request->validate([
            'counted_cash' => 'required|numeric|min:0',
            'counted_mobile_money' => 'required|numeric|min:0',
            'counted_card' => 'required|numeric|min:0',
            'closing_notes' => 'nullable|string|max:500',
        ]);

        $sales = Sale::where('register_session_id', $session->id)
            ->where('status', 'completed')
            ->get();

        $expectedCash = $session->opening_amount + $sales->where('payment_method', 'cash')->sum('total');
        $expectedMobile = $sales->where('payment_method', 'mobile_money')->sum('total');
        $expectedCard = $sales->where('payment_method', 'card')->sum('total');

        $expectedTotal = $expectedCash + $expectedMobile + $expectedCard;
        $countedTotal = $request->counted_cash + $request->counted_mobile_money + $request->counted_card;
        $variance = $countedTotal - $expectedTotal;

        $session->update([
            'expected_cash' => $expectedCash,
            'expected_mobile_money' => $expectedMobile,
            'expected_card' => $expectedCard,
            'counted_cash' => $request->counted_cash,
            'counted_mobile_money' => $request->counted_mobile_money,
            'counted_card' => $request->counted_card,
            'variance' => $variance,
            'closing_notes' => $request->closing_notes,
            'closed_at' => now(),
            'status' => 'closed',
        ]);

        ActivityLog::record('system', 'Register Closed', 'Écart : ' . number_format($variance, 0) . ' XAF');

        return redirect()->route('cashier.register.open')
            ->with('success', 'Caisse clôturée avec succès.');
    }
}