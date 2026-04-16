<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiSetting;
use Illuminate\Http\Request;

class ApiSettingController extends Controller
{
    public function index()
    {
        $settings = ApiSetting::pluck('value', 'key')->toArray();
        return view('admin.api-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $keys = [
            'midtrans_enabled', 'midtrans_server_key', 'midtrans_client_key', 'midtrans_production',
            'rajaongkir_enabled', 'rajaongkir_api_key', 'rajaongkir_origin_city',
            'shippo_enabled', 'shippo_api_key', 'shippo_origin_zip', 'shippo_origin_country',
        ];

        foreach ($keys as $key) {
            ApiSetting::set($key, $request->input($key, '0'));
        }

        return back()->with('success', 'API settings berhasil disimpan.');
    }
}
