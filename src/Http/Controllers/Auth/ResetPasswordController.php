<?php

namespace Iamnotstatic\LaravelAPIAuth\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Iamnotstatic\LaravelAPIAuth\Models\PasswordReset;
use Iamnotstatic\LaravelAPIAuth\Notifications\PasswordResetSuccess;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();
        
        if (!$passwordReset)
            return response()->json([ 'error' => 'This password reset token is invalid.'], 404);
           
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return response()->json([ 'error' => 'This password reset token is invalid.'], 404);
        }

        return response()->json($passwordReset);

    }


    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string'
        ]);
        
        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 400);
        }

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if (!$passwordReset)
            return response()->json([ "error" => "This password reset token is invalid."], 404);
        
        $user = User::where('email', $passwordReset->email)->first();

        if (!$user)
            return response()->json(["error" => "We can't find a user with that e-mail address."], 404);
           
        $user->password = bcrypt($request->password);
        $user->save();
        $passwordReset->delete();
        
        try {
            $user->notify(new PasswordResetSuccess($passwordReset));
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        return response()->json(['success' => 'Password was reset successfully you can now login']);
    }


}
