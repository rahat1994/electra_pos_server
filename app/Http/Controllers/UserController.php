<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Str;
class UserController extends Controller

{

  public function __construct()

   {

     //  $this->middleware('auth:api');

   }

   /**

    * Display a listing of the resource.

    *

    * @return \Illuminate\Http\Response

    */

   public function authenticate(Request $request)

   {

       $this->validate($request, [

            'email' => 'required',

            'password' => 'required'

        ]);

      $user = User::where('email', $request->input('email'))->first();

     if(Hash::check($request->input('password'), $user->password)){

          $apikey = base64_encode(Str::random(40));

          User::where('email', $request->input('email'))->update(['api_key' => "$apikey"]);;

          return response()->json([
              'status' => 'success',
              'api_key' => $apikey
            ]);

      }else{

          return response()->json(['status' => 'fail'],401);

      }

   }

   public function register(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'username' => 'required',
        ]);

        $data = $request->input();

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'userName' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
   }

}

?>
