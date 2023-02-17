<?php
namespace app\controller;

use app\BaseController;
use Firebase\JWT\JWT;

class Check extends BaseController
{
    public $extime = 7200;
    public function SetCheck()
    {
        $key = 'mago';
        $nowtime = time();
        $token['iss'] = '';
        $token['aud'] = '';
        $token['iat'] = $nowtime;
        $token['nbf'] = $nowtime+30;
        $token['exp'] = $nowtime + $this->extime;
        $jwt = JWT::encode($token,$key,'HS256');
        return json($jwt);
    }
}
