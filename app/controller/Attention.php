<?php


namespace app\controller;


use think\facade\Cache;

class Attention
{
    //关注
    public function Add()
    {
        $id = input('param.id');
        $uid = 33;
        Cache::store('redis')->sadd('dz:'.$id,$uid);
        return json([
            'code'=>200,
            'msg' => '你已关注id为'.$id.'的头条信息'
        ]);
    }
    //取消关注
    public function Del()
    {
        $id = input('param.id');
        $uid = 33;
        Cache::store('redis')->srem('dz:'.$id,$uid);
        return json([
            'code'=>200,
            'msg' => '你已取消关注id为'.$id.'的头条信息'
        ]);
    }
}