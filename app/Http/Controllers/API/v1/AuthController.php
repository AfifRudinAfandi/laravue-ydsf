<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

  protected const ALLOWED_USER = ['admin', 'user'];

  private function validateAuth($request, $auth = 'login')
  {
    if ($auth === 'login') {
      $rule = [
        'email' => 'required|email',
        'password' => 'required'
      ];
    } else if ($auth === 'register') {
      $rule = [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required'
      ];
    }

    try {
      $validator = Validator::make($request, $rule);

      if ($validator->fails())
        throw new \Exception($validator->errors());
    } catch (\Exception $err) {
      throw $err;
    }
  }

  public function loginByEmail(Request $request)
  {
    $this->validateAuth($request->all());

    try {
      $user = Admin::where('email', '=', $request->email)->with(['regional'])->first();
      if (!$user)
        return response()->json(['message' => 'Admin tidak ditemukan'], 404);

      $validatePassword = Hash::check($request->password, $user->password);
      if (!$validatePassword)
        return response()->json(['message' => 'Password salah'], 404);

      return response()->json(
        ['message' => 'Berhail login', 'user' => $user]
      );
    } catch (\Exception $err) {
      throw $err;
    }
  }

  public function register(Request $request, $auth)
  {
    $this->validateAuth($request->all(), 'register');

    try {
      $isSendMail = $auth === 'user' ? true : false;

      $user = $auth === 'admin' ? new Admin() : new User();

      $user->name = $request->name;
      $user->email = $request->email;
      $user->password = Hash::make($request->password);

      if (!$user->save())
        throw new \Exception('Error saving data', 500);

      if ($isSendMail) {
        Mail::send([], [], function ($message) use ($user) {
          $message->to($user->email)
            ->setBody('Hi, welcome user!');
        });
      }

      return $user;
    } catch (\Exception $err) {
      throw $err;
    }
  }
}
