<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    private function defaults(): array
    {
        return [
            'store_name' => 'MarketSmart MARKET',
            'store_address' => 'Douala, Cameroun',
            'store_phone' => '+237 6XX XXX XXX',
            'currency' => 'XAF',
            'tax_rate' => 0,
            'receipt_footer' => 'Merci de votre achat — MarketSmart',
            'low_stock_threshold' => 20,
            'expiry_alert_days' => 7,
        ];
    }

    private function getSettings(): Setting
    {
        return Setting::firstOrCreate(['id' => 1], $this->defaults());
    }

    public function index()
    {
        return view('admin.settings.index', [
            'settings' => $this->getSettings(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:120',
            'store_address' => 'nullable|string|max:200',
            'store_phone' => 'nullable|string|max:40',
            'currency' => 'required|string|max:10',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'receipt_footer' => 'nullable|string|max:255',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'expiry_alert_days' => 'nullable|integer|min:1|max:90',
        ]);

        $settings = $this->getSettings();

        $settings->update([
            'store_name' => $request->store_name,
            'store_address' => $request->store_address ?? '',
            'store_phone' => $request->store_phone ?? '',
            'currency' => strtoupper($request->currency),
            'tax_rate' => (float) ($request->tax_rate ?? 0),
            'receipt_footer' => $request->receipt_footer ?? '',
            'low_stock_threshold' => (int) ($request->low_stock_threshold ?? 20),
            'expiry_alert_days' => (int) ($request->expiry_alert_days ?? 7),
        ]);

        AuditLogController::log('SETTINGS_UPDATE', 'Store settings updated by admin');

        return back()->with('success', 'Paramètres enregistrés.');
    }

    public function reset()
    {
        $settings = $this->getSettings();
        $settings->update($this->defaults());

        AuditLogController::log('SETTINGS_RESET', 'Store settings reset to defaults');

        return back()->with('success', 'Paramètres réinitialisés.');
    }
}