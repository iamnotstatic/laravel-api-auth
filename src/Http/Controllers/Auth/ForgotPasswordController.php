<?php

namespace Iamnotstatic\LaravelAPIAuth\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Iamnotstatic\LaravelAPIAuth\Models\PasswordReset;
use Iamnotstatic\LaravelAPIAuth\Notifications\PasswordResetRequest;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */

    public function forgotten(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'We can\'t find a user with that e-mail address.'], 400);
        }

        $passwordReset = PasswordReset::updateOrCreate(
            [
                'email' => $user->email
            ],
            [
                'email' => $user->email,
                'token' => Str::random(60)
            ]
        );

        if ($user && $passwordReset)
            try {
                $user->notify(
                    new PasswordResetRequest($passwordReset->token)
                );
            } catch (\Throwable $th) {
                throw $th;
            }

        return response()->json(['success' => 'We have e-mailed your password reset link!']);

    }

    

}
