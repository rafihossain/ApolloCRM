<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Admin_login;
use App\Team;
use Session;

class LoginController extends Controller
{
	public function index()
    {
    	return view('admin.login');
    }
    public function login(Request $request)
    {
    	$validateData = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $email = $request->email;
        $password = $request->password;
        $check_username = Admin_login::where('email',$email)->where('password',$password)->first();
        if($check_username!=null){
        	Session::put('user_id',md5(rand()));
            return Redirect::to('home');
        }   
        else{
            return Redirect::to('/backend')->with('error_message','Email or Password is incorrect!');
        }
    }
	
	public function logout()
    {
        session()->forget('user_id');
        return Redirect::to('/backend');
    }

    public function leader()
    {
        return view('admin.leader-login');
    }
    public function leader_login(Request $request)
    {
        $validateData = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        $email = $request->email;
        $password = $request->password;
        $check_username = Team::where('leader_email',$email)->where('leader_password',$password)->first();
        if($check_username!=null){
            Session::put('leader_id',md5(rand()));
            Session::put('team_id',$check_username->id);
            return Redirect::to('leader-home');
        }
        else{
            return Redirect::to('/leader')->with('error_message','Email or Password is incorrect!');
        }
    }
    public function leader_logout()
    {
        session()->forget('leader_id');
        session()->forget('team_id');
        return Redirect::to('/leader');
    }

}
