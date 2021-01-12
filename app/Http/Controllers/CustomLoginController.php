<?php

namespace App\Http\Controllers;

use App\Models\MtStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
class CustomLoginController extends Controller
{

    use AuthenticatesUsers;
    public function loginForm()
    {
        return view('custom.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('staff_no', 'password');
        $user = MtStaff::where(['staff_no'=>$request->staff_no,'password'=>$request->password])->first();
        // if(Auth::guard('customLogin')->attempt($credentials, $request->remember))
        if($user)
        {

            Auth::guard('customLogin')->login($user);


            return redirect()->route('custom.home');
        }
        else{
            return redirect()->route('custom.login');
        }
    }

    public function home()
    {

        return view('custom.home');
    }
}
