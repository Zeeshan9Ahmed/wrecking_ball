<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Admin;
use DB;
use Carbon\Carbon;
use App\Models\Template;
use App\Models\Booking;
use App\Models\Exercise;

// use App\Models\Detail_Description;

Class AuthController extends Controller
{

	public function login(){
       return view('admin.login');
    }

    public function login_process(Request $request)
    {
       $controls=$request->all();
        $rules=array(
            'email'=>"required|exists:users,email",
            "password"=>"required");
        $validator=Validator::make($controls,$rules);
        if ($validator->fails()) {
            // dd($validator);
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $admin = User::where('email', $request->email)->first();

        if (Hash::check($request->password, $admin->password)) {
            Auth::login($admin);

            return redirect()->route('dashboard');
        }

        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Incorrect email address or password']);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/login');
    }

    public function dashboard()
    {
        
        $exercises = Exercise::get();
        $exercises_name =  $exercises->pluck('name');
        $exercises_counts =  $exercises->pluck('view_count');
        // return $exercises_counts;
        $exercises_count = $exercises->count();
        $total_views_count = $exercises->sum('view_count');
        return view('admin.dashboard', compact('exercises_count','exercises_name','exercises_counts', 'total_views_count'));
  
    }

}