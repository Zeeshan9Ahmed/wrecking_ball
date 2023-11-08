<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Models\CommonPage;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AuthController extends Controller
{
    use ApiResponser;

    /** Register user */
    public function signup(Request $request)
    {
        $customMessages = [
            'email.email' => 'Invalid email address',
            'required' => ':attribute can not be empty',
            'password.regex' => 'Password must be of 8 characters long and contain atleast 1 uppercase, 1 lowercase, 1 digit and 1 special character',
            'password.min' => 'Password must be of 8 characters long and contain atleast 1 uppercase, 1 lowercase, 1 digit and 1 special character',
            'password.max' => 'Password must be of 8 characters long and contain atleast 1 uppercase, 1 lowercase, 1 digit and 1 special character',
        ];

        $validator = Validator::make($request->all(), [
            'fullname' => 'nullable|max:255',
            'email' => 'required|unique:users|email|max:255',
            // 'phone_number' => 'required|numeric',
            'password' => 'required|min:8|max:255|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            "password_confirmation"=> "required|min:8",
            // 'address' => 'required',
            'profile_image' => 'nullable',
        ],$customMessages); 

        
        
        if ($validator->fails()) {
            return $this->error($validator->errors()->all()[0], 400);
        }

        $code = 123456;//random_int(100000, 999999);
    
        $user = new User;
        $user->fullname = $request->fullname;
        // $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->otp = $code;        
        
        if($request->hasFile('profile_image')){
            $imageName = time().'.'.$request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('/uploadedimages'), $imageName);
            $file_path = asset('public/uploadedimages')."/".$imageName;
            
            $user->profile_image = $file_path;

        }

        if($user->save()){
        
            $details = [
                'subject' => 'Verify your email',
                'email' => $request->email,
                'code' => $code,
                'view' => 'emails.verify-email'
            ];
            
            // Mail::to($details['email'])->send(new \App\Mail\SendEmail($details));
            
            $data = [
                'email' => $request->email, 
                'password' => $request->password
            ];
            
            auth()->attempt($data);

            // $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 1,
                'message' => 'OTP successfully sent to given email address',
                // 'token' => $token,
                'data' => [
                    'user_id' => $user->id,
                ]
               
            ], 200);
        }
        else{
            return $this->error('Sign Up Not Processed', 400);
        } 
    }

    /** OTP verify */
    public function verification(Request $request)
    {
        $controls=$request->all();
        $rules=array(
            "code"=>"required|min:6|numeric",
            "user_id"=>"required|exists:users,id"
        );
        $customMessages = [
            'required' => 'The :attribute  is required.',
            'numeric' => 'The :attribute  Must be Numeric',
            'exists' => 'The :attribute is Not Exists',
        ];
        $validator=Validator::make($controls,$rules,$customMessages);
        if ($validator->fails()) {
            return response()->json(['status'=>0,'message'=>$validator->errors()->all()[0]],400);
        }
        $user=User::where([['id','=',$request->user_id],['otp','=',$request->code]])->first();
        if($user){
            Auth::loginUsingId($user->id, true);
            $token = $user->createToken('authToken')->plainTextToken;
            $user->email_verified_at = Carbon::now();
            $user->account_verified = 1;
            $user->save();
            $user["user_id"] = $user->id;
            
            return response()->json([
                'status'=>1,
                'message'=>'OTP Verified Successfully.',
                'token'=>$token,
                'data'=>$user,
                
            ],200);
        }
        else{
            return response()->json([
                'status'=>0,
                'message'=>'Invalid OTP'
            ],400);
        }
    }

    /** Resend code */
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id'
        ]);  
        if ($validator->fails()) {
            return $this->error($validator->errors()->all()[0], 400);
        }

        $user = User::where(['id' => $request->user_id])->first();

        if(!empty($user)){
            $code = 123456;//random_int(100000, 999999);

            User::whereId($user->id)->update(['otp' => $code]);

            $details = [
                'subject' => 'Verify your email',
                'email' => $request->email,
                'code' => $code,
                'view' => 'emails.verify-email'
            ];
            
            // Mail::to($details['email'])->send(new \App\Mail\SendEmail($details));

            return $this->success('Resend Code successfully.');
        }
        else{
            return $this->error('User not found.', 404);
        }
    }

    /** Login */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email|max:255',
            'password' => 'required|min:8|max:255',
            'device_type' => 'required',
            'device_token' => 'required'

        ]);  
        if ($validator->fails()) {
            return $this->error($validator->errors()->all()[0], 400);
        }

        $data = [
            'email' => $request->email, 
            'password' => $request->password
        ];

        $user = User::where('email', $request->email)->first();

        if(!empty($user)){

            if(Hash::check($request->password, $user->password)){
                if (auth()->attempt($data)) {
        
                    if(auth()->user()->account_verified == 0){
        
                        $code = 123456;//random_int(100000, 999999);
                        
                        User::whereId($user->id)->update(['otp' => $code]);
        
                        $details = [
                            'subject' => 'Verify your email',
                            'email' => $request->email,
                            'code' => $code,
                            'view' => 'emails.verify-email'
                        ];
                        
                        // Mail::to($details['email'])->send(new \App\Mail\SendEmail($details));
///// 
                        return response()->json([
                            'status' => 0,
                            'message' => 'Please verify your account, OTP successfully sent to your email address',
                            'data' => auth()->user(),
                        ], 400);
                    }
                    else{

                        User::whereId(auth()->user()->id)->update(['device_type' => $request->device_type, 'device_token' => $request->device_token]);
                        $user->tokens()->delete();
                        $token = $user->createToken('LaravelAuthToken')->plainTextToken;
                        $user->device_type=$request->device_type;
                        $user->device_token=$request->device_token;
                        $user->api_token = $token;
                        $user->save();
                        $user["user_id"] = $user->id;
                        
                        return response()->json([
                            'status' => 1,
                            'message' => 'User successfully logged in',
                            'token' => $token,
                            // 'data' => auth()->user(),
                            'data' => $user
                        ], 200);
                    }
                } 
                else {
                    return $this->error('Unauthorised', 401);
                }
            }
            else{
                return $this->error('Password is incorrect', 400);
            }
        }
        else{
            return $this->error('Email is incorrect', 400);
        }
    }

    /** Common Page */
    public function page($slug)
    {
        // if($slug == 'return')
        // {
            $page = CommonPage::where('type', $slug)->get();
        // }
        // else
        // {
        //     $page = CommonPage::where('slug', $slug)->first(['title', 'content']);
        // }
        
        // dd($page);

        if(!empty($page)){
            // return $this->success($page->title .' page found', $page);
            return $this->success(' page found', $page);
        }
        else{
            return $this->error('Page not found.', 404);
        }
    }

    /** Forget password */
    public function forgotPassword(Request $request)
    {
        
        $controls=$request->all();
        $rules=array(
            'email'=>'required|email|exists:users,email'
        );
        $customMessages = [
            'required' => 'The :attribute  is required.',
            'exists' => 'The :attribute is Not Exists',
        ];
        $validator=Validator::make($controls,$rules,$customMessages);
        if ($validator->fails()){
            return response()->json(['status'=>0,'message'=>$validator->errors()->all()[0]],400);
        }
        else{
            $user = User::where('email',$request->email)->first();
            if(!empty($user)){
                // $token = rand(100000,999999);
                DB::table('password_resets')->where(['email'=>$request->email])->delete();
                $token = 123456;
                DB::table('password_resets')->insert([
                    'email'=>$user->email,
                    'token'=> $token,
                    'created_at'=>Carbon::now()
                ]);
                // $user->notify(new PasswordResetNotification($token));
                return response()->json([
                    'status'=>1,
                    'message'=>'Password reset otp has been sent to your email address'
                ],200);
            }
            else{
                return response()->json([
                    'status'=>0,
                    // 'message'=>'Your Account Is Not Verified Please Verify Your Account...!'
                    'message'=>'User Not Found'
                ],400);
            }
        }
    }

    public function forgotPasswordOtpVerify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'code' => 'required|min:6|max:6'
        ]);  
        if ($validator->fails()) {
            return $this->error($validator->errors()->all()[0], 400);
        }

       
        $check_otp = DB::table("password_resets")
               ->where(["token" => $request->code, "email" => $request->email])
               ->first();
            
           if ($check_otp) {
               $totalDuration = Carbon::parse($check_otp->created_at)->diffInHours(
                   Carbon::now()
               );
               if ($totalDuration > 1) {
                   return response()->json([
                       "status" => 0,
                       "message" => "OTP Expired",
                   ]);
               }
               User::where('email',$request->email)->update(['otp' => null]);
               return response()->json([
                   "status" => 1,
                   "message" => "OTP Verified Successfully",
               ]);
           }
           return response()->json(["status" => 0, "message" => "Invalid OTP"]);
    }

     public function forgotPasswordResendOtp(Request $request){
         $controls=$request->all();
         $rules=array(
            "email"=>"required|exists:users,email"
        );
        $customMessages = [
        'required' => 'The :attribute  is required.',
        'exists' => 'The :attribute is Not Exists',
        ];
        $validator=Validator::make($controls,$rules,$customMessages);
         if ($validator->fails()) {
            return response()->json(['status'=>0,'message'=>$validator->errors()->all()[0]],400);
        }

        $user = User::where('email',$request->email)->first();
            if($user->email_verified_at || $user->account_verified == 1){
            // $token = rand(100000,999999);
                $token = 123456;
            DB::table('password_resets')->insert([
                'email'=>$user->email,
                'token'=> $token,
                'created_at'=>Carbon::now()
            ]);
        // $user->notify(new PasswordResetNotification($token));

        return response()->json(['status'=>1,'message'=>'We have sent Forgot Password OTP verification code at your email address'],200);
        }else{
        return response()->json(['status'=>0,'message'=>'Not Verified'],400);
        }
    }

    /** Update Password */
    public function resetPassword(Request $request)
    {
        $customMessages = [
            'email.email' => 'Invalid email address',
            'required' => ':attribute can not be empty',
            'password.regex' => 'Password must be of 8 characters long and contain atleast 1 uppercase, 1 lowercase, 1 digit and 1 special character',
            'password.min' => 'Password must be of 8 characters long and contain atleast 1 uppercase, 1 lowercase, 1 digit and 1 special character',
            'password.max' => 'Password must be of 8 characters long and contain atleast 1 uppercase, 1 lowercase, 1 digit and 1 special character',
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:8|max:255|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/'
        ], $customMessages);  
        if ($validator->fails()) {
            return $this->error($validator->errors()->all()[0], 400);
        }


        $check_otp = DB::table('password_resets')->where(['email'=>$request->email])->first();
        if($check_otp){    
            $user = User::where('email',$check_otp->email)->first();
            $user->password = bcrypt($request->password);
            $user->save(); 
            DB::table('password_resets')->where(['email'=>$request->email])->delete();
            return response()->json(['status'=>1,'message'=>"Password updated successfully"],200);
        }
        else{
            return response()->json(['status'=>0,'message'=>"User Not Found"],400); 
        }
    }

    /** Change password */
    public function changePassword(Request $request)
    {
        $customMessages = [
            'email.email' => 'Invalid email address',
            'required' => ':attribute can not be empty',
            'new_password.regex' => 'Password must be of 8 characters long and contain atleast 1 uppercase, 1 lowercase, 1 digit and 1 special character',
            'new_password.min' => 'Password must be of 8 characters long and contain atleast 1 uppercase, 1 lowercase, 1 digit and 1 special character',
            'new_password.max' => 'Password must be of 8 characters long and contain atleast 1 uppercase, 1 lowercase, 1 digit and 1 special character',
            'confirm_password.regex' => 'Password must be of 8 characters long and contain atleast 1 uppercase, 1 lowercase, 1 digit and 1 special character',
            'confirm_password.min' => 'Password must be of 8 characters long and contain atleast 1 uppercase, 1 lowercase, 1 digit and 1 special character',
            'confirm_password.max' => 'Password must be of 8 characters long and contain atleast 1 uppercase, 1 lowercase, 1 digit and 1 special character',
            'confirm_password.required' => ':attribute field is required',

        ];

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8|max:255|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'confirm_password' => 'required|same:new_password'
        ],$customMessages);  
        if ($validator->fails()) {
            return $this->error($validator->errors()->all()[0], 400);
        }

        if($request->old_password == $request->new_password)
        {
            return $this->error("Old password and New password can't be same", 400);
        }

        if(Hash::check($request->old_password, auth()->user()->password)){
            $update_password = $request->user()->update(['password' => Hash::make($request->new_password)]);
            if($update_password){
                return $this->success('Password updated successfully.');
            }
            else{
                return $this->error('Something went wrong.', 400);
            }
        }
        else{
            return $this->error('Old Password Is Incorrect.', 400);
        }
    }

    /** Complete/Update Profile */
    public function updateProfile(Request $request)
    {
        $userId = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'profile_image' => 'nullable',
            // 'city' => 'nullable',
            // 'state' => 'nullable',
            // 'latitude' => 'nullable',
            // 'longitude'=> 'nullable'
        ]);  
        if ($validator->fails()) {
            return $this->error($validator->errors()->all()[0], 400);
        }

        if($request->hasFile('profile_image')){
            $imageName = time().'.'.$request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('/uploadedimages'), $imageName);
            $file_path = asset('public/uploadedimages')."/".$imageName;
            //$user->profile_image=$imageName;

            $submition_data = $request->all();
            $submition_data['profile_image'] = $file_path;
            $submition_data['is_profile_complete'] = '1';
        }

        // if(!empty($request->file('profile_image'))){
        //     $user_file_check = User::find($userId);
        //     if(!empty($user_file_check->profile_image)){
        //         $value = unlink(public_path($user_file_check->profile_image));
        //     }

        //     $path = $request->file('profile_image')->store('public/user');
        //     $file_path = Storage::url($path);
        //     $submition_data = $request->all();
        //     $submition_data['profile_image'] = $file_path;
        //     $submition_data['is_profile_complete'] = '1';
        // }
        else{
            $submition_data = $request->all();
            $submition_data['is_profile_complete'] = '1';
        }

        $update_user = User::whereId($userId)->update($submition_data);

        if($update_user){
            return $this->success('Profile complete successfully.', User::find($userId));
        }else{
            $this->error('Sorry there is some problem while updating profile data.', 400);
        }
    }  
    

    /** Logout */
    public function logout(Request $request)
    {
        $user_id = auth()->user()->id;
        $user_obj = User::whereId($user_id)->count();

        if($user_obj > 0){
            // $sentum_delete = $request->user()->currentAccessToken()->delete();
            $sentum_delete = $request->user()->tokens()->delete();
            if($sentum_delete){
                $update_user = User::whereId($user_id)->update(['device_type' => null, 'device_token' => null]);
                if($update_user){
                    return $this->success('User logout successfully.');
                }else{
                    $this->error('Sorry there is some problem while updating user data.', 400);
                }
            }else{
                $this->error('Sorry there is some problem while deleting old token.', 400);
            }  
        }
        else{
            return $this->error('User not found', 404);
        }
    }


    //Social Login
    public function socialAuth(Request $request)
    {      
        $controls=$request->all();
        $rules=array(
            'access_token'=>'required',
            'provider'=>'required|in:facebook,google,apple,phone',
            'device_type' => 'required',
            'device_token' => 'required',
            'email' => 'nullable',
            'name' => 'nullable',
        );
           $customMessages = [
        'required' => 'The :attribute field is required.',
        'unique' => 'The :attribute is Already Exists',
        'exists' => 'The :attribute is Not Exists',
        ];
        $validator=Validator::make($controls,$rules,$customMessages);
        if ($validator->fails()){
            return response()->json(['status'=>0,'message'=>$validator->errors()->all()[0]],400);
        }

     // $auth = app('firebase.auth');
        // Retrieve the Firebase credential's token
        $user_social_token = $request->access_token;

        // try {
        //     $verifiedIdToken = $auth->verifyIdToken($idTokenString);
            
        //     $user_social_token = $verifiedIdToken->claims()->get('sub');
        //     $get_user = $auth->getUser($user_social_token);
            
             //dd($get_user);
            
            $user = User::where('user_social_token',$user_social_token)->where('user_social_type',$request->provider)->first();
            if(!$user){
                

                // $check = User::where('email',$request->email)->first();
                // if($check)
                // {
                //    // if($check->user_social_type == null)
                //    // {
                //        return response()->json([
                //            'status'=>0,
                //            'message'=>"This Email Already Exists"
                //        ],400); 
                //    // } 
                // }
                
                
                $user = new User();

                // if($get_user->email == null){
                //     foreach($get_user->providerData as $dat){
                //         $user->email = $dat->email;
                //     }
                // }
                // else{
                //     $user->email = $get_user->email;
                // }
                // $user->otp = null;
                $user->fullname = ($request->name)?$request->name:null;
                $user->email = ($request->email)?$request->email:null;
                $user->email_verified_at = Carbon::now();

                $user->device_type = $request->device_type;
                $user->device_token= $request->device_token;
                $user->account_verified = 1;
                
                $user->is_social = 'yes';
                $user->user_social_token = $user_social_token;
                $user->user_social_type = $request->provider;
                // $user->profile_image = null;
                // $user->is_profile_complete = 0;
                // $user->api_token = null;
                
                // $user->is_card = 1;
                
                
            
                $user->save();
            }

                $user->tokens()->delete();
            $token =$user->createToken('authToken')->plainTextToken;
           return response()->json([
                        'status'=>1,
                        'message'=>'Login Successfully',
                        'data'=>User::find($user->id),
                        'token'=>$token
                        
                    ],200);
        

        // } catch (\InvalidArgumentException $e) { // If the token has the wrong format
        //     return response()->json(['status'=>0,
        //         'message' => 'Unauthorized - Can\'t parse the token: ' . $e->getMessage()
        //     ],401);

        // } catch (InvalidToken $e) { // If the token is invalid (expired ...)
        //     return response()->json([
        //         'status'=>0,
        //         'message' => 'Unauthorized - Token is invalid: ' . $e->getMessage()
        //     ],401);
        // }
    }


}
