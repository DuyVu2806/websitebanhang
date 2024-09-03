<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login()
    {
        return view('admin.auth.login');
    }

    function post_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        $login =  Auth::guard('admin')->attempt($request->only('email', 'password'), $request->has('remember'));
        if ($login) {
            return redirect()->route('admin.dashboard')->with('success', 'Login successfully');
        }
        return redirect()->back()->with('error', 'Login Fail');
    }
    function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logout Successfully');
    }
    function create_staff() {
        return view('admin.auth.create_staff');
    }
    function post__staff(Request $request) {
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email|unique:admin',
            'password' => 'required|min:8',
        ]);
        $request->merge(['password' => bcrypt($request->password)]);

        $reg = Admin::create([
            'code' => Helper::generate_unique_code('admin', 'code', 5),
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($reg) {
            return redirect()->back()->with('success', 'Register successfully');
        }

        return redirect()->back()->with('error', 'Register successfully');
    }
}
