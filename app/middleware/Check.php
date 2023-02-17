<?php
declare (strict_types = 1);

namespace app\middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use think\facade\Request;

class Check
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $key = 'mago';
        $info = Request::header();
        $jwt = $info['authorization'];
        JWT::$leeway = 60;
        try {
            JWT::decode($jwt,new Key($key,'HS256'));
        } catch (\Exception $e) {
            return json(['code'=>2002,'msg'=>$e->getMessage()]);
        }
        return $next($request);
    }
}
