<?php

namespace App\Http\Repositories;

use DB;
use Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserRepository
{

    public function updateUser($id, $request)
    {
        try {

            $user = User::where('id', $id)->first();

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

                    return null;

              }


        } catch (\Exception $e) {
           return $e->getMessage();
        }


    }

    public function uploadFile($file)
    {

        if ($file) {

            $date_time =  date('Y-m-d H:i:s');

            $dateTime_str =  str_replace(" ", "", str_replace(":", "", $date_time));

            $fileName = preg_replace('/\s+/', '', $file->getClientOriginalName());

            $url = '/profiles' . '/' . $dateTime_str . $fileName;

            $file_name = $url;

            $name = $dateTime_str . $fileName;

            $file->move("profiles/" . "/", $file_name);

            $document_link  = '/profiles/' . $name;

            return $document_link;
        }

        return null;
    }

    public function allUsers()
    {
        return User::orderBy('id', 'desc')->get();
    }

    public function userDetails($id)
    {
       $user = User::where('id', $id)->first();

       if($user){

            return $user;

       }

       else{

            return null;

       }
    }



    public function deleteUser($id)
    {
        try {

            return User::where('id', $id)->delete();

        } catch (\Throwable $th) {

            throw $th;
        }

    }


}

?>
