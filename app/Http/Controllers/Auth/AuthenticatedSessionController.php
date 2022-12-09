<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        $redirectTo = request()->redirectTo;
        
        $getUser = User::where('email', $request->email)->first();
        if($getUser){
            Session::put('user_id', $getUser->id);
            Session::put('full_name', $getUser->first_name.' '.$getUser->last_name);
    
            return redirect('admin/dashboard');
            
            // if ($redirectTo) {
            //     return redirect($redirectTo);
            // }
        }
        
        
        
        
        // if ($redirectTo) {
        //     return redirect($redirectTo);
        // } else {
        //     return redirect(RouteServiceProvider::HOME);
        // }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
