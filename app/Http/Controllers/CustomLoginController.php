<?php

namespace App\Http\Controllers;

use App\Models\MtStaff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
class CustomLoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('custom.guest');
    }

    protected $redirectTo = '/custom/home';
    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('custom.login');
    }

    public function login(Request $request)
    {
        $user = MtStaff::where(['staff_no'=>$request->staff_no,'password'=>$request->password])->first();
        if($user)
        {
            Auth::guard('custom')->login($user);
            return $this->sendLoginResponse($request);
        }
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        if ($response = $this->authenticated($request, $this->guard('custom')->user())) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($this->redirectPath());
    }
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
    protected function guard()
    {
        return Auth::guard('custom');
    }
}
