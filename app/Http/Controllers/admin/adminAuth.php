<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\controller;
use Illuminate\Http\Request;
use Auth;
use App\Mail\adminResetPassword;
use App\admin;
use DB;
use Carbon\Carbon;
use Mail;
class adminAuth extends Controller
{
    public function login(){
        return view('admin.login'); 
    }
    public function doLogin(){
        $rememberme= request('rememberme') == 1 ? true : false;
        if (admin()->attempt(['email'=>request('email'),'password'=>request('password')],$rememberme)) {
        return view('admin/home');
        }else{
            session()->flash('error','admin.inccorrect_information');
            return redirect('admin/login');
        }
    }
    
    public function logout(){
        auth::guard('admin')->logout();
        return redirect('admin/login');
    }
    public function forgot_password(){
        return view('admin.forgot_password');
    }
    public function forgot_password_post(admin $admin, request $request){
        $request->validate([
            'email' => 'required|exists:admins,email'
        ]);
        $admin = admin::where('email',$request->email)->first();
        if (!empty($admin)) {
            // broker تمكنك من استعمال الكريت ميثود لخلق توكين جديد
            $token = app('auth.password.broker')->createToken($admin);
            $data= DB::table('password_resets')->insert([
                'email'=>$admin->email,
                'token'=>$token,
                'created_at'=>Carbon::now()
            ]);

            mail::to($admin->email)->send( new  adminResetPassword(['data'=>$admin,'token'=>$token]));
            // dd(mail());
            session()->flash('success','reset link has been sent');
            return redirect()->back();
            
        }
        return redirect()->back();
    }

    public function reset_password($token, request $request){
        $check_token = DB::table('password_resets')->where('token',$token)->where('created_at','>',Carbon::now()->subHours(2))->first();
        // return dd($check_token); 
        if (!empty($check_token)) {
            return view('admin.reset_password',['data'=>$check_token]);
        }else {
            session()->flash('error','Invalid Token');
            return redirect('admin/login');
        }
    }
    public function reset_password_post($token,request $request){
        // return request();
            $request->validate([
                'email' => 'required|exists:admins,email',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
            ]);
        $check_token = DB::table('password_resets')->where('token',$token)->where('created_at','>',Carbon::now()->subHours(2))->first();
        // return dd($check_token); 
        if (!empty($check_token)) {
           $admin = admin::where('email',$check_token->email)->update(['email'=>$check_token->email,'password'=>bcrypt($request->password)]); 
           $check_token = DB::table('password_resets')->where('email',$request->email)->delete();
           admin()->attempt(['email'=>request('email'),'password'=>request('password')],true);
           return redirect(aurl());
        }else {
            session()->flash('error','Invalid Token');
            return redirect('admin/login');
        }
    }
}
