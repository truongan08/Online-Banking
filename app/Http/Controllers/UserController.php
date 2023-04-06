<?php

namespace App\Http\Controllers;

use App\Accept;
use App\Advertisement;
use App\Bank;
use App\Branch;
use App\Feature;
use App\Hyip;
use App\HyipAccept;
use App\HyipPackage;
use App\Setting;
use App\Transaction;
use Auth;
use phpDocumentor\Reflection\Types\Null_;
use PhpParser\Node\Stmt\Else_;
use Session;
use App\Deposit;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function branch()
    {
        $branches = Branch::all();
        return view('user.branch', compact('branches'));
    }

    public function loginPage()
    {
        if (Auth::user()) {
            return redirect()->route('user.dashboard');
        }
        return redirect()->route('login');
    }

    public function dashboard()

    {

        $totalDep = Deposit::where('user_id', Auth::id())->where('status', 1)->sum('amount');
        $userToUser = Transaction::where('user_id', Auth::id())->where('type', 6)->count('user_id');
        $userToBank = Transaction::where('user_id', Auth::id())->where('type', 7)->where('status', 1)->count('user_id');
        $totaltf = $userToUser + $userToBank;
        $totalOtBankTrn = Transaction::where('user_id', Auth::id())->where('type', 7)->where('status', 0)->sum('amount');

        return view('user.dashboard', compact('totalDep', 'totaltf', 'totalOtBankTrn'));
    }

    public function profileIndex()
    {
        return view('user.profile');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|numeric',
        ]);
        $user = Auth::user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->save();
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    public function avatarUpdate(Request $request)
    {
    }

    public function changePass()
    {
        return view('user.changePass');
    }

    public function passwordChange(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $oldpassword = $request->old_password;
        $newpassword = $request->password;
        if (Hash::check($oldpassword, Auth::user()->password)) {
            $request->user()->fill(['password' => Hash::make($newpassword)])->save();
            return redirect()->back()->with('success', 'Đổi mật khẩu thành công');
        }
        return back()->withErrors(['mật khẩu không hợp lệ']);
    }

    public function profileImage(Request $request)
    {
        $request->validate([
            'avatar' => 'required|mimes:jpg,jpeg,png',
        ]);
        $user = Auth::user();



        if ($request->hasFile('avatar')) {
            @unlink('assets/image/avatar/' . $user->avatar);
            $image = $request->file('avatar');
            $filename = $image->hashName();
            $location = 'assets/image/avatar/' . $filename;
            Image::make($image)->fit(512, 512)->save($location);
            $user->avatar = $filename;
        }
        $user->save();
        return redirect()->back()->with('success', 'Cập nhật thành công');
    }

    public function accStatement()
    {
        $ownBankStatements = Transaction::where('user_id', Auth::user()->id)->where('type', 6)->latest()->get();
        $otherBankStatements = Transaction::where('user_id', Auth::user()->id)->where('type', 7)->latest()->get();

        return view('user.accStatement', compact('otherBankStatements', 'ownBankStatements'));
    }

    public function transferToOwnBank()
    {
        return view('user.transferOwnBank');
    }

    public function transferOwnBank(Request $request)
    {


        $this->validate($request, [

            'account_number' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        $gnl = Setting::first();

        $charge = $gnl->bal_trans_fixed_charge + ($request->amount * $gnl->bal_trans_per_charge / 100);
        $amount = $request->amount + $charge;
        if ($amount > Auth::user()->balance || $request->amount <= 0) {
            return back()->withErrors(['Số tiền không hợp lệ']);
        } else {
            $user = User::where('account_number', $request->account_number)->first();
            if ($user == NULL) {
                return back()->withErrors(['Số tài khoản không hợp lệ']);
            } else {

                $data['amount'] = $request->amount;
                $data['account_number'] = $request->account_number;
                $data['charge'] = $charge;
                $data['total'] = $amount;
                $data['type'] = 0;

                Session::put('data', $data);
                return redirect()->route('user.transfer.preview');
            }
        }
    }

    public function transferPreview(Request $request)
    {

        $tnfp = Session::get('data');
        return view('user.tfPreview', compact('tnfp'));
    }

    public function transferOwnBankConfirm(Request $request)
    {

        $this->validate($request, [
            'account_number' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);

        $gnl = Setting::first();

        $charge = $gnl->bal_trans_fixed_charge + ($request->amount * $gnl->bal_trans_per_charge / 100);
        $amount = $request->amount + $charge;
        if ($amount > Auth::user()->balance || $request->amount <= 0) {
            return back()->withErrors(['Số tiền không hợp lệ']);
        } else {
            $user = User::where('account_number', $request->account_number)->first();
            if ($user == NULL) {
                return back()->withErrors(['Số tài khoản không hợp lệ']);
            } else {
                //nguoi gui
                $sender = User::find(Auth::user()->id);
                $sender->balance = $sender->balance - $amount;
                $sender->update();

                $senderTlog = new Transaction();
                $senderTlog['user_id'] = $sender->id;
                $senderTlog['amount'] = $request->amount;
                $senderTlog['balance'] = $sender->balance;
                $senderTlog['fee'] = $charge;
                $senderTlog['type'] = 6;
                $senderTlog['status'] = 1;
                $senderTlog['details'] = 'Chuyen khoan den tai khoan ' . $user->name;
                $senderTlog['trxid'] = 'tns:' . str_random(16);
                $senderTlog->save();

                //nguoi nhan
                $receiver = User::where('account_number', $request->account_number)->first();
                $receiver->balance = $receiver->balance + $request->amount;
                $receiver->update();

                $receiverTlog = new Transaction();
                $receiverTlog['user_id'] = $receiver->id;
                $receiverTlog['amount'] = $request->amount;
                $receiverTlog['balance'] = $receiver->balance;
                $receiverTlog['type'] = 6;
                $receiverTlog['status'] = 1;
                $receiverTlog['details'] = 'Nhan tien tu tai khoan ' . $sender->name;
                $receiverTlog['trxid'] = $senderTlog->trxid;
                $receiverTlog->save();

                return redirect()->route('user.dashboard')->with('success', 'Chuyển khoản thành công cho ' . $receiver->name . '. Số tiền là ' . $request->amount . " " . $gnl->cur . '. Phí giao dịch là ' . " " . $charge . " " . $gnl->cur . ' Số dư hiện tại là ' . $sender->balance);
            }
        }
    }

    public function transferToOtherBank()
    {
        $banks = Bank::where('status', 1)->get();
        return view('user.transferOtherBank', compact('banks'));
    }


    public function transferOtherBank(Request $request)
    {


        $this->validate($request, [
            'bank_name' => 'required',
            'details' => 'required',
            'branch_name' => 'required',
            'account_number' => 'required',
            'amount' => 'required|numeric',
        ]);

        $bank = Bank::find($request->bank_name);
        if ($bank != NULL) {
            $charge = $bank->fixed_charge + ($request->amount * $bank->percent_charge / 100);
            $amount = $request->amount + $charge;
            if ($amount > Auth::user()->balance || $request->amount <= 0) {
                return back()->withErrors('Invalid Amount');
            } else {

                if ($bank->min_amount <= $request->amount ||  $request->amount >= $bank->max_amount) {
                    $data['bank'] = $bank->name;
                    $data['bank_id'] = $bank->id;
                    $data['amount'] = $request->amount;
                    $data['charge'] = $charge;
                    $data['total'] = $amount;
                    $data['branch_name'] = $request->branch_name;
                    $data['account_number'] = $request->account_number;
                    $data['p_time'] = $bank->p_time;
                    $data['details'] = $request->details;
                    Session::put('data', $data);

                    return redirect()->route('user.ot.transfer.preview');
                } else {
                    return back()->withErrors(['Không thỏa mãn giới hạn tiền giao dịch ']);
                }
            }
        } else {
            return redirect()->back()->withErrors(['Tên ngân hàng không hợp lệ']);
        }
    }

    public function transferOtBankPreview(Request $request)
    {

        $tnfp = Session::get('data');
        return view('user.otTfPreview', compact('tnfp'));
    }

    public function transferOtherBankConfirm(Request $request)
    {

        $this->validate($request, [
            'bank_name' => 'required',
            'details' => 'required',
            'branch_name' => 'required',
            'account_number' => 'required',
            'amount' => 'required|numeric',
        ]);

        $bank = Bank::find($request->bank_name);
        if ($bank != NULL) {
            $charge = $bank->fixed_charge + ($request->amount * $bank->percent_charge / 100);
            $amount = $request->amount + $charge;
            if ($amount > Auth::user()->balance || $request->amount <= 0) {
                return back()->withErrors(['Số tiền không hợp lệ']);
            } else {

                $gnl = Setting::first();
                $sender = User::find(Auth::user()->id);
                $sender['balance'] = $sender->balance - $amount;
                $sender->update();

                $senderTlog = new Transaction();
                $senderTlog['user_id'] = $sender->id;
                $senderTlog['amount'] = $request->amount;
                $senderTlog['balance'] = $sender->balance;
                $senderTlog['fee'] = $charge;
                $senderTlog['type'] = 7;
                $senderTlog['p_time'] = $bank->p_time;
                $senderTlog['details'] = 'Ten ngan hang: ' . $bank->name . ' . Ten chi nhanh ' . $request->branch_name . '. So tai khoan : ' . $request->account_number . '. Chi tiet tai khoan : ' . $request->details;
                $senderTlog['trxid'] = 'tns:' . str_random(16);
                $senderTlog->save();

                return redirect()->route('user.dashboard')->with('success', 'Yêu cầu chuyển khoản được gửi thành công cho ' . $bank->name . '. Số tiền là ' . $request->amount . $gnl->cur . '. Phí là ' . $charge . $gnl->cur . '. Thời gian xử lí ' . $bank->p_time . '. Số dư hiện tại là ' . $sender->balance . $gnl->cur);
            }
        } else {
            return redirect()->back()->withErrors('Invalid Bank name');
        }
    }

    //call scrpit otBank, ownBank
    public function bankData(Request $request)
    {
        $dada = Bank::where('id', $request->id)->first();
        return response()->json([
            'fixed_charge' => $dada->fixed_charge,
            'percent_charge' => $dada->percent_charge,
            'p_time' => $dada->p_time,
            'min_amount' => $dada->min_amount,
            'max_amount' => $dada->max_amount,
        ]);
    }
}
