<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\ShippingFee;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __invoke()
    {
        $shippingFee = ShippingFee::first()?->fee ?? 0;
        return view('pages.admin.settings.index', compact('shippingFee'));
    }
}
