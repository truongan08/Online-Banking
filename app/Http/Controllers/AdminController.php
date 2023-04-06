<?php

namespace App\Http\Controllers;

use App\Setting;
use Auth;
use App\User;
use App\Admin;
use App\Deposit;
use App\General;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    public function charges()
    {
        return view('admin.settings.charge');
    }
    public function chargesUpdate(Request $request)
    {
        $charge = Setting::first();
        $charge->bal_trans_fixed_charge = $request->bal_trans_fixed_charge;
        $charge->bal_trans_per_charge = $request->bal_trans_per_charge;
        $charge->update();
        return back()->with('success', 'Cập nhật phí thành công');
    }
}
