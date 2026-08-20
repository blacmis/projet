<?php
namespace App\Http\Controllers\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ExpiredController extends Controller
{
    public function index(Request $request)
    {
        $allExpired = [
            [
                'id' => 1,
                'product' => 'Yogurt 500ml',
                'batch_no' => 'YOG2305',
                'expiry_date' => '01/05/2026',
                'quantity' => 8,
            ],
            [
                'id' => 2,
                'product' => 'Milk 1L',
                'batch_no' => 'MILK2305',
                'expiry_date' => '02/05/2026',
                'quantity' => 6,
            ],
            [
                'id' => 3,
                'product' => 'Bread Loaf',
                'batch_no' => 'BRD2305',
                'expiry_date' => '03/05/2026',
                'quantity' => 12,
            ],
            [
                'id' => 4,
                'product' => 'Sausage Pack',
                'batch_no' => 'SAU2305',
                'expiry_date' => '04/05/2026',
                'quantity' => 5,
            ],
            [
                'id' => 5,
                'product' => 'Cheese 200g',
                'batch_no' => 'CHZ2305',
                'expiry_date' => '05/05/2026',
                'quantity' => 4,
            ],
        ];
        $search = $request->input('search');
        if ($search) {
            $expired = array_filter($allExpired, function ($item) use ($search) {
                return str_contains(strtolower($item['product']), strtolower($search)) ||
                       str_contains(strtolower($item['batch_no']), strtolower($search));
            });
        } else {
            $expired = $allExpired;
        }
        return view('manager.expired.index', compact('expired', 'search'));
    }
    public function expiringSoon(Request $request)
    {
        $allExpiring = [
            [
                'id' => 1,
                'product' => 'Milk 1L',
                'batch_no' => 'MILK2405',
                'expiry_date' => '25/05/2026',
                'days_left' => 7,
                'quantity' => 30,
            ],
            [
                'id' => 2,
                'product' => 'Yogurt 500ml',
                'batch_no' => 'YOG2405',
                'expiry_date' => '28/05/2026',
                'days_left' => 10,
                'quantity' => 40,
            ],
            [
                'id' => 3,
                'product' => 'Cheese 200g',
                'batch_no' => 'CHZ2405',
                'expiry_date' => '02/06/2026',
                'days_left' => 15,
                'quantity' => 25,
            ],
            [
                'id' => 4,
                'product' => 'Butter 250g',
                'batch_no' => 'BUT2405',
                'expiry_date' => '05/06/2026',
                'days_left' => 18,
                'quantity' => 20,
            ],
            [
                'id' => 5,
                'product' => 'Juice 1L',
                'batch_no' => 'JUC2405',
                'expiry_date' => '07/06/2026',
                'days_left' => 20,
                'quantity' => 60,
            ],
        ];
        $search = $request->input('search');
        if ($search) {
            $expiring = array_filter($allExpiring, function ($item) use ($search) {
                return str_contains(strtolower($item['product']), strtolower($search)) ||
                       str_contains(strtolower($item['batch_no']), strtolower($search));
            });
        } else {
            $expiring = $allExpiring;
        }
        return view('manager.expired.expiring-soon', compact('expiring', 'search'));
    }
}