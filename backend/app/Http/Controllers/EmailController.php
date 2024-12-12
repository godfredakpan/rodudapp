<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMail;
use App\Mail\OrderRaveNotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

use App\Models\PushMessages;


use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmailController extends Controller
{
    // Send Signup Email
    public function sendSignupEmail($userId)
    {
        $user = User::where('id', $userId)->first();
        if($user == null) return response()->json(['message' => 'User not found!'], 404);
        $subject = 'Welcome to Rodud 🎉!';
        $messageBody = 'Thank you for signing up! Click the button below to confirm your email address.';
        $actionUrl = route('verification.verify', ['token' => $user->email_verification_token]);
        $actionText = 'Confirm Email';

        Mail::to($user->email)->send(new NotificationMail($subject, $messageBody, $actionUrl, $actionText, $user));

        return response()->json(['message' => 'Signup email sent successfully!']);
    }

    // Send Sign-in Email
    public function sendSigninEmail($userId)
    {
        $user = User::where('id', $userId)->first();
        if($user == null) return response()->json(['message' => 'User not found!'], 404);
        $subject = 'New Sign-in Alert';
        $messageBody = 'A new sign-in to your account was detected. If this was not you, please secure your account.';
        $actionUrl = route('account.security', ['user' => $user->id]);
        $actionText = 'Review Account';

        Mail::to($user->email)->send(new NotificationMail($subject, $messageBody, $actionUrl, $actionText, $user));

        return response()->json(['message' => 'Sign-in email sent successfully!']);
    }

    // Send Order Notification
    public function sendOrderEmail(Request $request, $userId)
    {
        $user = User::where('id', $userId)->first();
        if($user == null) return response()->json(['message' => 'User not found!'], 404);
        $subject = 'Order Notification';
        $messageBody = 'Your recent order has been sent successfully!';
        $actionUrl = null;
        $actionText = 'View Transaction on your app';

        $transactionDetails = [
            'id' => $request->id,
            'name' => $request->name,
            'pickup' => $request->pickup_location,
            'delivery' => $request->delivery_location,
            'weight' => $request->weight,
            'truck_size' => $request->truck_size,
        ];

        Mail::to($user->email)->send(new NotificationMail($subject, $messageBody, $actionUrl, $actionText, $user, $transactionDetails));

        return response()->json(['message' => 'Order email sent successfully!']);
    }


    public function sendOrderEmailUpdate($order, $status)
    {
        $user = User::where('id', $order->user_id)->first();
        if($user == null) return response()->json(['message' => 'User not found!'], 404);
        $subject = 'Order Notification';
        $messageBody = 'Your recent order status has been updated to '.$status.'!';
        $actionUrl = null;
        $actionText = 'View Transaction on your app';

        $transactionDetails = [
            'id' => $order->id,
            'name' => $order->name,
            'pickup' => $order->pickup_location,
            'delivery' => $order->delivery_location,
            'weight' => $order->weight,
            'truck_size' => $order->truck_size,
        ];

        Mail::to($user->email)->send(new NotificationMail($subject, $messageBody, $actionUrl, $actionText, $user, $transactionDetails));

        return response()->json(['message' => 'Order email sent successfully!']);
        
    }

    // Send Email Verification Email
    public function sendVerificationEmail($userId)
    {
        $user = User::where('id', $userId)->first();
        if($user == null) return response()->json(['message' => 'User not found!'], 404);
        $token = Str::random(60);
        $user->email_verification_token = $token;
        $user->save();

        
        $subject = 'Email Verification';
        $messageBody = 'Please verify your email address by clicking the button below.';
        $actionUrl = route('verification.verify', ['token' => $user->email_verification_token]);
        $actionText = 'Verify Email';

        Mail::to($user->email)->send(new NotificationMail($subject, $messageBody, $actionUrl, $actionText, $user));

        return response()->json(['message' => 'Verification email sent successfully!']);
    }


    public function sendPasswordResetEmail($email)
    {
        $user = User::where('email', $email)->first();
        if($user == null) return response()->json(['message' => 'User not found!'], 404);
        $token = Str::random(60);
        $user->password_reset_token = $token;
        $user->save();

        
        $subject = 'Password Reset';
        $messageBody = 'Please reset your password by clicking the button below.';
        $actionUrl = route('password.reset', ['token' => $user->password_reset_token]); 
        $actionText = 'Reset Password';

        Mail::to($user->email)->send(new NotificationMail($subject, $messageBody, $actionUrl, $actionText, $user));

        return response()->json(['message' => 'Password reset email sent successfully!']);
    }

    public function sendCustomEmail(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $user = User::findOrFail($request->user_id);

        try {
            Mail::to($user->email)->send(new NotificationMail($request->subject,$request->body,null,'View Transaction on your app',$user,null));

            return response()->json(['success' => true, 'message' => 'Email sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send email', 'error' => $e->getMessage()], 500);
        }
    }

    

}
