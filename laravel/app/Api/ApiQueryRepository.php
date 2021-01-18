<?php

namespace App\Api;

class ApiQueryRepository {

    public function getUserTokenByToken($token)
    {
        return UserToken::where('token', $token)->first();
    }
    public function getUserTokenByTokenNoExpAt($token)
    {
        $query  = UserToken::with(['org_user'])
            ->where('token', $token)
            ->where('expired_at', '>=', date('Y-m-d'));
        return $query->first();
    }

    public function getUserTokenByTokenNoExpAtUserId($token, $userId)
    {
        $query  = UserToken::with(['org_user'])
            ->where('token', $token)
            ->where('user_id', $userId)
            ->where('expired_at', '>=', date('Y-m-d'));
        return $query->first();
    }
}
