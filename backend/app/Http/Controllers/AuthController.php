<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    
    public function register(Request $request)
    {
        try {
            if (User::where('email', $request->email)->exists()) {
                // return response()->json(['message' => 'Email already exists'], 409); // proper return message
                return false;
            }

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);
            
            $token = Str::random(60);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if (!$user) {
                return response()->json(['message' => 'User could not be created'], 500);
            }

            $user->email_verification_token = $token;
            $user->save();


            $token = $user->createToken('auth_token')->plainTextToken;

            $notificationController = new EmailController();

            $notificationController->sendSignupEmail($user->id);

            return response()->json(['access_token' => $token, 'token_type' => 'Bearer', 'user' => $user]);

        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            dd($e);
            return response()->json(['message' => 'An error occurred while creating the user'], 500);
        }
    }

    public function login(Request $request)
    {

        try {
            if ($request->user()) {
                return response()->json(['message' => 'User already logged in'], 409);
            }

            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Invalid credentials'], 200);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            $notificationController = new EmailController();
            $notificationController->sendSigninEmail($user->id); 

            return response()->json(['access_token' => $token, 'token_type' => 'Bearer', 'user' => $user]);

        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
            return response()->json(['message' => 'An error occurred while logging in'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully']);

        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while logging out'], 500);
        }
    }

    public function updateUser(Request $request)
    {

        try {

            $user = User::where('id', $request->id)->first();

            if($user){

                DB::beginTransaction();

                $user->name = $request->name ?? $user->name;

                $user->is_admin = $request->is_admin ?? $user->is_admin;

                $user->save();

                if($user){

                    DB::commit();

                    return $user;
                }else{
                    DB::rollback();

                    return null;

                }
            }
            else{

                    return response()->json(['message' => 'User not found'], 404);

              }


        } catch (\Exception $e) {
           return $e->getMessage();
        }



    }


    public function verifyEmail(Request $request, $token)
    {
        $user = User::where('email_verification_token', $token)->first();

        if (!$user) {

            return view('account.verification-error');
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->verified = 1;
        $user->save();

        return view('account.verification-success');
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)
                    ->where('password_reset_token', $request->token)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid token or email.'], 400);
        }

        $user->password = Hash::make($request->password);
        $user->password_reset_token = null; 
        $user->save();

        $subject = 'Password Changed Successfully !';
        $messageBody = 'Your password has been changed successfully! If you did not make this change, please contact our support team.';
        $actionUrl = null; 
        $actionText = null;

        Mail::to($user->email)->send(new NotificationMail($subject, $messageBody, $actionUrl, $actionText, $user));

        return redirect('/password/success');
    }

}

