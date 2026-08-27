<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AuditLogController;
class SaleActionController extends Controller
{
    private function defaultSales(): array
    {
        return [
            [
                'id' => 1,
                'receipt_no' => 'RCPT-0048025',
                'date_time' => '30-07-2026 12:00PM',
                'cashier' => 'Ange Cashier',
                'amount' => 11250,
                'payment_method' => 'Card',
                'items' => 4,
                'status' => 'Completed',
            ],
            [
                'id' => 2,
                'receipt_no' => 'RCPT-0048024',
                'date_time' => '30-07-2026 12:02PM',
                'cashier' => 'Ange Cashier',
                'amount' => 15000,
                'payment_method' => 'Cash',
                'items' => 6,
                'status' => 'Completed',
            ],
            [
                'id' => 3,
                'receipt_no' => 'RCPT-0048023',
                'date_time' => '30-07-2026 12:05PM',
                'cashier' => 'Jean Caisse',
                'amount' => 3255,
                'payment_method' => 'Cash',
                'items' => 2,
                'status' => 'Completed',
            ],
            [
                'id' => 4,
                'receipt_no' => 'RCPT-0048022',
                'date_time' => '30-07-2026 12:10PM',
                'cashier' => 'Ange Cashier',
                'amount' => 5200,
                'payment_method' => 'Mobile Money',
                'items' => 3,
                'status' => 'Completed',
            ],
            [
                'id' => 5,
                'receipt_no' => 'RCPT-0048021',
                'date_time' => '30-07-2026 12:15PM',
                'cashier' => 'Jean Caisse',
                'amount' => 715,
                'payment_method' => 'Cash',
                'items' => 1,
                'status' => 'Completed',
            ],
        ];
    }
    private function getSales(): array
    {
        if (!session()->has('admin_sales')) {
            session(['admin_sales' => $this->defaultSales()]);
        }
        return session('admin_sales');
    }
    private function saveSales(array $sales): void
    {
        session(['admin_sales' => array_values($sales)]);
    }
    public function index(Request $request)
    {
        $sales = collect($this->getSales());
        if ($request->filled('q')) {
            $q = strtolower($request->q);
            $sales = $sales->filter(function ($s) use ($q) {
                return str_contains(strtolower($s['receipt_no']), $q)
                    || str_contains(strtolower($s['cashier']), $q)
                    || str_contains(strtolower($s['payment_method']), $q);
            })->values();
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $sales = $sales->where('status', $request->status)->values();
        }
        if ($request->filled('payment') && $request->payment !== 'all') {
            $sales = $sales->filter(function ($s) use ($request) {
                return strtolower($s['payment_method']) === strtolower($request->payment);
            })->values();
        }
        $all = collect($this->getSales());
        return view('admin.sale-actions.index', [
            'sales' => $sales,
            'stats' => (object) [
                'total' => $all->count(),
                'completed' => $all->where('status', 'Completed')->count(),
                'cancelled' => $all->where('status', 'Cancelled')->count(),
                'revenue' => $all->where('status', 'Completed')->sum('amount'),
            ],
        ]);
    }
    public function cancel($id)
    {
        $sales = $this->getSales();
        $found = false;
        foreach ($sales as $i => $s) {
            if ((int) $s['id'] === (int) $id) {
                if ($s['status'] === 'Cancelled') {
                    return back()->with('error', 'Cette vente est déjà annulée.');
                }
                $sales[$i]['status'] = 'Cancelled';
                $found = true;
                break;
            }
        }
        if (!$found) {
            return back()->with('error', 'Vente introuvable.');
        }
        $this->saveSales($sales);
        AuditLogController::log('SALE_CANCEL', 'Sale ID '.$id.' cancelled');
        return back()->with('success', 'Vente annulée par l\'administrateur.');
    }
    public function restore($id)
    {
        $sales = $this->getSales();
        $found = false;
        foreach ($sales as $i => $s) {
            if ((int) $s['id'] === (int) $id) {
                $sales[$i]['status'] = 'Completed';
                $found = true;
                break;
            }
        }
        if (!$found) {
            return back()->with('error', 'Vente introuvable.');
        }
        $this->saveSales($sales);
        AuditLogController::log('SALE_RESTORE', 'Sale ID '.$id.' restored');
        return back()->with('success', 'Vente restaurée (Completed).');
    }
}