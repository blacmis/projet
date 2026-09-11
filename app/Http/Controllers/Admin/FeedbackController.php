<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $items = Feedback::orderByDesc('created_at')->get();

        return view('admin.feedback.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:complaint,suggestion',
            'message' => 'required|string|max:2000',
        ]);

        $senderId = User::where('email', session('auth_user'))->value('id');

        Feedback::create([
            'sent_by' => $senderId,
            'type' => $data['type'],
            'message' => $data['message'],
            'status' => 'new',
        ]);

        return redirect()
            ->route('admin.feedback.index')
            ->with('success', 'Votre message a bien été envoyé à MarketSmart.');
    }
}