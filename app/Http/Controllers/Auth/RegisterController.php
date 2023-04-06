<?php

namespace App\Http\Controllers\Auth;

use App\Setting;
use  App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    */

    use RegistersUsers;

    /**
     * Where to redirect user after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {

        $setting = Setting::first();
        $registration = $setting->registration;
        if ($registration == 1 )
            return view('frontend.register');
        else
            return redirect()->route('homePage')->withErrors(['Đăng ký tạm thời tắt']);


    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {


        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:199'],
            'last_name' => ['required', 'string', 'max:199'],
            'phone' => ['required', 'numeric'],
            'username' => ['required', 'string','alpha_num', 'max:199', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:199', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $settings = Setting::first();
        $email_verify = 1;
        $sms_verify = 1;
        $email_code = substr(uniqid(),0,6 );
        $sms_code = substr(uniqid(),3,6 );
        $email_time =Carbon::parse()->addMinute(3);
        $sms_time =Carbon::parse()->addMinute(3);


        $account_number = $this->generateAccNo();


        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'account_number' => $account_number,
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'email_verified' => $email_verify,
            'sms_verified' => $sms_verify,
            'email_code' => $email_code,
            'sms_code' => strtoupper($sms_code),
            'email_time' => $email_time,
            'sms_time' => $sms_time,
        ]);


    }

    //random so tai khoan
    public function generateAccNo(){
        $rend = rand(10000000, 99999999). rand(10000000, 99999999);
         $check = User::where('account_number', $rend)->first();

        if($check == true){
            $rend = $this->generateAccNo();
        }
        return $rend;
    }
}
