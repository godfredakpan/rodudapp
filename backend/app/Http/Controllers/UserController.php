<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\UserRepository;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{

    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->repository->allUsers();

        return view('pages.management.users.all_users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.management.users.create_user');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $content = $this->repository->createUser($request);

        if ($content) {

            session()->flash('success', "User Created successfully !");

            return redirect()->route('create.user');
        } else {

            session()->flash('error', "An Error occurred please try again !");

            return redirect()->route('create.user');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $user = $this->repository->userDetails($id);

        if ($user != null) {

            return view('pages.management.users.view_user', compact('user'));
        } else {
            session()->flash('error', "user not found !");

            return redirect()->back();
        }
    }

    public function confirmPassword(Request $request){

       $user = Auth::user();
       if (Hash::check($request->password, $user->password)) {
            $data = array(
                'status' => 'success',
                'code' => $user->transfer_code,
            );
           return $data;

       } else {
            $data = array(
                'status' => 'failed',
                'code' => null,
            );
           return $data;
       }
     }

    public function profile()
    {
        $user = $this->repository->userDetails(Auth::user()->id);

        $referals = [];

        if ($user != null) {

            return view('pages.management.users.profile', compact('user', 'referals'));
        } else {
            session()->flash('error', "Profile not found !");

            return redirect()->back();
        }
    }



    public function update(Request $request)
    {

        $update = $this->repository->updateUser($request->id, $request);

        if ($update != null) {

            session()->flash('success', "User updated successfully !");

            return redirect()->back();
        } else {

            session()->flash('error', "Could not edit post'");

            return redirect()->back();
        }
    }

    public function delete($id)
    {

        $delete = $this->repository->deleteUser($id);

        if ($delete) {

            $users = $this->repository->allUsers();

            session()->flash('success', "User deleted successfully !");

            return redirect()->route('all.users')->with('users');
        } else {

            session()->flash('error', "Could not delete user'");

            return redirect()->back();
        }
    }


    public function requestDeletionLink(Request $request)
    {
        $user = $request->user();

        $token = Str::random(64);

        DB::table('deletion_requests')->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addHours(24),
        ]);

        $deletionLink = URL::temporarySignedRoute(
            'deleteAccount', 
            now()->addHours(24), 
            ['token' => $token]
        );

        $notificationController = new EmailController();
        $notificationController->sendAccountDeletionEmail($user->id, $deletionLink);

        return response()->json([
            'message' => 'Deletion link generated. Check your email to confirm deletion.',
            'deletion_link' => $deletionLink
        ]);
    }

    public function deleteAccount($token)
    {

        $deletionRequest = DB::table('deletion_requests')->where('token', $token)->first();

        if (!$deletionRequest || Carbon::now()->greaterThan($deletionRequest->expires_at)) {
            return response()->json(['message' => 'This deletion link has expired or is invalid.'], 400);
        }

        $user = User::find($deletionRequest->user_id);

        if ($user) {
            $user->delete();

            DB::table('deletion_requests')->where('token', $token)->delete();

            return response()->json(['message' => 'Your account and data have been successfully deleted.']);
        }

        return response()->json(['message' => 'User not found.'], 404);
    }
}
