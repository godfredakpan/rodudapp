<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use DB;
class FrontendController extends Controller
{
    private $post;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $reviews = [];

        return view('frontend.index', compact('reviews'));
    }

    // privacy policy
    public function privacy()
    {
        return view('frontend.privacy');
    }


    public function terms()
    {
        return view('frontend.terms');
    }


    public function showDeletionForm()
    {
        return view('frontend.delete_account');
    }

    public function requestAccountDeletion(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email', 
        ]);

        $user = User::where('email', $request->email)->first();


        $this->sendAccountDeletionEmail($user->id);

        return response()->json(['message' => 'We are sad to let you go! A confirmation email has been sent.']);
    }


}
