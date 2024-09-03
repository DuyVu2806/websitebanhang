<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    function login()
    {
        return view('customer.auth.login');
    }
    function post_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::guard('cus')->attempt($credentials, $request->has('remember'))) {
            $user = Auth::guard('cus')->user();
            return redirect()->route('cus.home')->with('success', 'Login successfully');
        }
        $login =  Auth::guard('cus')->attempt($request->only('email', 'password'), $request->has('remember'));
        if ($login) {
            return redirect()->route('cus.home')->with('success', 'Login successfully');
        }
        return redirect()->back()->with('error', 'Login Fail');
    }
    function logout()
    {
        Auth::guard('cus')->logout();
        return redirect()->back()->with('success', 'Logout Successfully');
    }
    function register()
    {
        return view('customer.auth.register');
    }
    function post_register(Request $request)
    {
        $request->validate([

            'fullname' => 'required',
            'email' => 'required|email|unique:customer',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'phone' => 'required|numeric|digits:10',
            'gender' => 'required',
        ],[
            'fullname.required' => 'Họ và tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu ít nhất 8 kí tự',
            'password.confirmed' => 'Không trùng khớp',
            'password_confirmation.required' => 'Mật khẩu không được để trống',
            'password_confirmation.min' => 'Mật khẩu ít nhất 8 kí tự',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.numeric' => 'Số điện thoại phải là số',
            'phone.digits'=> 'Số điện thoại gồm 10 số',
            'gender.required'=> 'Giới tính không được để trống',
        ]);
        $request->merge(['password' => bcrypt($request->password)]);

        $reg =  Customer::create([
            'code' => Helper::generate_unique_code('customer', 'code', 10),
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'gender' => $request->gender,
        ]);
        if ($reg) {
            Auth::guard('cus')->login($reg);
            return redirect()->route('cus.home')->with('success', 'Đăng ký tài khoản thành công');
        } else {
            return redirect()->back()->with('error', 'Đăng ký tài khoản không thành công');
        }
    }
    function forgot_password(){
        return view('customer.auth.forgot-password');
    }
    function post_forgot_password(Customer $customer, $token){
        
    }
    function get_password(){

    }

    function post_get_password(){

    }


    function test_mail()
    {
        $name = 'name';
        Mail::send('email.test', compact('name'), function ($email) use ($name) {
            $email->to('nguyenhuyduyvu@gmail.com', $name);
        });
    }
}
