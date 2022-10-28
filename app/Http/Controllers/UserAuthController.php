<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Status;
use App\Models\contactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;

use Illuminate\Validation\Rules\Password as RulesPassword;




class UserAuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'

        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        //$status = Status::create([
        //    'email' => $fields['email'],
        //    'status'=> "off"
        //]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'

        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    
    public function change_password(Request $request){
        $fields = $request->validate([
            
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed'

        ]);

        $user=$request->user();
        if(Hash::check($fields['old_password'],$user->password)){
            $user->update([
                'password'=>Hash::make($fields['password'])
            ]);
            return response()->json([
                'message'=>'Password successfully updated',
            ],200);
        }else{
            return response()->json([
                'message'=>'Old password does not matched',
            ],400);
        }
    }

    public function forget_password(Request $request){
        $request->validate(['email' => 'required|string']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

       // return response()->json(['message'=>'fuck you'],200);
       if ($status == Password::RESET_LINK_SENT) {
        return [
            'status' => __($status)
            ];
        }


    } 

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message'=> 'Password reset successfully'
            ]);
        }

        return response([
            'message'=> __($status)
        ], 500);

    }

    public function show()
    {
        $user =  auth('sanctum')->user()->email;  
        //return $user;
        $content = DB::select('select status from statuses WHERE email = ?',[$user]);
        //$content = DB::select('select status from users where email =?',[$email]);
                //->get();  

        //return response()->json(["status" => 200, "data" => $content]);
        //dd($content);

        return $content;
    }

    public function Contact(Request $request){

        $fields = $request->validate([
            'name' => 'required|string',
            'dateofbirth' => 'required|string',
            'email' => 'required|string',
            'SSN' => 'required|string'

        ]);

        $user = contactForm::create([
            'name' => $fields['name'],
            'dateofbirth' => $fields['dateofbirth'],
            'email' =>bcrypt($fields['email']),
            'SSN' => $fields['SSN']
        ]);
    }

    public function statusON(Request $request)
    {
        $fields = $request->validate([
            'status' => 'required|string',
        ]);


        $user = auth('sanctum')->user()->email;
        
        $content = DB::update('update statuses set status = ? where email = ?', [$fields['status'],$user]);

        //$status = Status::all()->pluck('email');
        //return $status;

        //$status->status = $request->status;
        //$status->update();

        return response()->json([
            'message'=>'Status is updated' ,
        ],200);
    }

    public function statusOFF()
    {
        //$request->validate([
        //    'status' => 'required|string',
        //]);


        $user = auth('sanctum')->user()->email;
        
        $content = DB::update('update statuses set status = "OFF" where email = ?', [$user]);

        //$status = Status::all()->pluck('email');
        //return $status;

        //$status->status = $request->status;
        //$status->update();
    }

}
