<?php
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord du Manager
     */
    public function index()
    {
        // Pour l'instant on retourne juste la vue.
        // Plus tard on enverra ici les vraies données (nombre de produits, stock bas, etc.)
        return view('manager.dashboard');
    }
}