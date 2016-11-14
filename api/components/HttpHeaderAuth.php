<?php

namespace api\components;

use yii\filters\auth\AuthMethod;

class HttpHeaderAuth extends AuthMethod
{

    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('X-Key');
        // var_dump($authHeader);die;
        if ($authHeader) {
            $identity = $user->loginByAccessToken($authHeader, get_class($this));           
            if ($identity === null) {
                $this->handleFailure($response);
            }
            return $identity;
        }

        return null;
    }
}
