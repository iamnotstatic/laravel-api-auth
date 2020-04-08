<?php 

namespace Iamnotstatic\LaravelAPIAuth\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller 
{
    
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @return [string] access_token
     * @return [string] token_type
     */
    
    public function login (Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user(); 
            $success['token'] =  $user->createToken(config('apiauth::token_key_name'))-> accessToken;  
            return response()->json(['success' => $success], 200);  
        } else {
            return response()->json(['error' => 'Invalid Credentails'], 401);
        }
    }

    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function getUser() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], 200); 
    } 


    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
} 