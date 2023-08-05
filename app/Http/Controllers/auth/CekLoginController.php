<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\CekLoginRequests;
use Illuminate\Http\Request;

class CekLoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CekLoginRequests $request)
    {
        $login = auth()->attempt([
            "username" => $request->username,
            "password" => $request->password,
        ]);

        if (!$login) {
            return back()->withErrors([
                "login_status" => "Email atau password salah."
            ]);
        }

        $wali_murid = auth()->user()->role_id == 5;
        if ($wali_murid) {
            return redirect()->route("interface.wali-murid.index");
        }

        if (auth()->user()->role_id != 4) {
            return redirect()->route("dashboard.index");
        }

        return back()->withErrors([
            "login_status" => "Email atau password salah."
        ]);
    }
}
