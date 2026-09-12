<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function features()
    {
        return view('landing.features');
    }

    public function advantages()
    {
        return view('landing.advantages');
    }
        public function pricing()
    {
        return view('landing.pricing');
    }
    public function contactPage()
    {
        return view('landing.contact');
    }

    public function contact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'market_name' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:2000',
        ]);

        Lead::create($data);

        return redirect()
            ->route('landing.contact.show')
            ->with('success', 'Merci ! Votre demande a bien été reçue, nous vous recontacterons rapidement.');
    }
}