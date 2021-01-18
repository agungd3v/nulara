<?php

namespace App\Api;
use DB;
use Carbon;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use App\Api\UserToken;
use Illuminate\Support\Facades\Auth;
use App\Api\RegisterRepository;

class AuthRepository extends ApiQueryRepository {
    public function getToken($bodyParams, $isLogin = false)
    {
        $userToken          = new UserToken();
        $userToken->token   =  bin2hex(openssl_random_pseudo_bytes(16));
        $userToken->expired_at  = date("Y-m-d H:i:s", strtotime("+1 months"));

        if($isLogin){
            $userToken->user_id = Auth::user()->id;
        }
        $userToken->save();

        // app version
        return [
            'token' => $userToken
        ];
    }
    public function login($token)
    {
        if($token === null){
            return $userToken = $this->getToken(['device' => 'web-nuxt', 'device_id' => 'web_nuxt_id'], true);
        }
        $userToken = $this->getUserTokenByToken($token);
        if(!$userToken){
            return false;
        }

        $userToken->user_id = Auth::user()->id;
        $userToken->save();

        return $userToken;
    }
    public function checkCredentialLogin($request) {
        try {
            $checkUser = User::where('email', $request->get('email'))->first();
            if(!$checkUser)  return [
                'status'    => false,
                'data'  => 'Invalid email',
                'code'  => 500,
            ];
            if (Hash::check($request->get('password'), $checkUser->password)) {
                $exp = Carbon\Carbon::now()->addDays(1)->timestamp;
                $token = JWTAuth::fromUser($checkUser);
                if (!$token) return [
                        'status'    => false,
                        'data'  => 'Unauthorized',
                        'code'  => 401,
                    ];
                return [
                    'status'    => true,
                    'data'  => $token,
                    'code'  => 200,
                    'user' => $checkUser
                ];
            }
            return [
                'status' => false,
                'data' => 'Invalid User',
                'code'  => 500,
            ];
        } catch (JWTException $e) {
            return [
                'status' => false,
                'data' => 'could_not_create_token',
                'code'  => 500,
            ];
        }
    }
    public function checkRequestLogin($request) {
        $validator =  Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()){
            return [
                'status' => false,
                'data' => $validator->errors()->all(),
            ];
        }
        return [
            'status' => true,
            'data' => "",
        ];
    }
    public function createOrgUsers($request)
    {
        $return     = [
            'success'   => false,
            'message'   => ''
        ];

        try {
            $newOrgUser = new User();
            $newOrgUser->name   = $request->get('name');
            $newOrgUser->email  = $request->get('email');
            $newOrgUser->password   = Hash::make($request->get('password_hash'));
            $newOrgUser->save();

            $return['success']  = true;
            $return['message']  = $newOrgUser;
            return $return;
        } catch (\Exception $e) {
            $return['message']  = $e->getMessage();
            return $return;
        }
    }
}