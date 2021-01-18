<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Api\AuthRepository;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(AuthRepository $auth)
    {
        $this->auth = $auth;
    }
    public function login(Request $request)
    {
        // dd($request);
        // return response()->json($request->all());
        // START checking Request Input Login
        $validator = $this->auth->checkRequestLogin($request);
        // return $validator['status'];
        if (!$validator['status']){
            return response()->json($validator);
        }
        // END checking Request Input Login

        // START checking credential
        $credentialsChecking    = $this->auth->checkCredentialLogin($request);
        // return $credentialsChecking;
        if (!$credentialsChecking['status']) {
            return response()->json($credentialsChecking, $credentialsChecking['code']);
        }
        // END checking credential

        // START login process
        // $token = $request->header('token') ? $request->header('token') : null;
        // $this->auth->login($token, $tokenCredential);
        // END login process

        // Set token on user cookies
        // Auth::user()->token = $tokenCredential;
        $user = $credentialsChecking['user'];
        return response()->json([
            'status' => true,
            'data' => [
                'token' => $credentialsChecking['data'],
                'user' =>  $user
            ]
        ], 200);
    }
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::parseToken());
            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    }
    public function register(Request $request)
    {
        $register = $this->auth->createOrgUsers($request);
        if (!$register) {
            return response()->json(['success' => false, 'message' => 'error']);
        }
        return response()->json(['status' => true, 'message' => 'register complete']);
    }
    public function getUser()
    {
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    }
}
