<?php

namespace app\controller;

use app\model\Handline as HandlineModel;
use app\Request;
use app\validate\HandlineValidate;
use OSS\Core\OssException;
use OSS\OssClient;
use think\exception\ValidateException;
use think\facade\Cache;
use think\facade\Log;

class Handline extends Base
{
    /**
    * 获取列表
    */
    public function getList()
    {
        if (request()->isPost()) {

            $limit  = input('post.limit');
            $where = [];

            $HandlineModel = new HandlineModel();
            $list = $HandlineModel->getHandlineList($where, $limit);

            return json(pageReturn($list));
        }
    }

    /**
    * 添加
    */
    public function add()
    {
        if (request()->isPost()) {

            $param = input('post.');

            $file = $_FILES['file'];
            $name = $file['name'];
            $files = strrchr($name,'.');
            // 阿里云账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM用户进行API访问或日常运维，请登录RAM控制台创建RAM用户。
            $accessKeyId = "LTAI5tB9RKZuMvnzUxLjVyN7";
            $accessKeySecret = "UacPJ3PNDHyA9mfLXvElbaY2LqijnR";
// yourEndpoint填写Bucket所在地域对应的Endpoint。以华东1（杭州）为例，Endpoint填写为https://oss-cn-hangzhou.aliyuncs.com。
            $endpoint = "oss-cn-hangzhou.aliyuncs.com";
// 填写Bucket名称，例如examplebucket。
            $bucket= "qw265317";
// 填写Object完整路径，例如exampledir/exampleobject.txt。Object完整路径中不能包含Bucket名称。
            $object = "img/".time().$files;
// <yourLocalFile>由本地文件路径加文件名包括后缀组成，例如/users/local/myfile.txt。
// 填写本地文件的完整路径，例如D:\\localpath\\examplefile.txt。如果未指定本地路径，则默认从示例程序所属项目对应本地路径中上传文件。
            $filePath = $file['tmp_name'];

            try{
                $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);

                $rest1 = $ossClient->uploadFile($bucket, $object, $filePath);
            } catch(OssException $e) {
                printf(__FUNCTION__ . ": FAILED\n");
                printf($e->getMessage() . "\n");
                return;
            }
            $param['img'] = $rest1['info']['url'];

            // 检验完整性
            try {
                validate(HandlineValidate::class)->check($param);
            } catch (ValidateException $e) {
                return jsonReturn(-1, $e->getError());
            }

            $HandlineModel = new HandlineModel();
            $res = $HandlineModel->addHandline($param);

            return json($res);
        }
    }

    /**
    * 查询信息
    */
    public function read(Request $request)
    {
        $id = input('param.id');

        $userid = 33;
        $key = 'lock:'.$request->uid.':'.$id;
        $lock = Cache::get($key);
        if ($lock){
            $res = [
                'code' => 2001,
                'msg' => '请勿在3秒内重复操作',
            ];
            return json($res);
        }
        Cache::set($key,1,3);
        $num = Cache::inc("attention:".$id);

        $HandlineModel = new HandlineModel();
        $info = $HandlineModel->getHandlineById($id);
        $info['private']['hits']=$num;

        Log::info(json_encode([
            'uid'=>$userid,
            'model'=>'handline',
            'pageid'=>$id
        ]));
        return json($info);
    }

    /**
    * 编辑
    */
    public function edit()
    {
         if (request()->isPost()) {

            $param = input('post.');

            // 检验完整性
            try {
                validate(HandlineValidate::class)->check($param);
            } catch (ValidateException $e) {
                return jsonReturn(-1, $e->getError());
            }

            $HandlineModel = new HandlineModel();
            $res = $HandlineModel->editHandline($param);

            return json($res);
         }
    }

    /**
    * 删除
    */
    public function del()
    {
        $id = input('param.id');

        $HandlineModel = new HandlineModel();
        $info = $HandlineModel->delHandlineById($id);

        return json($info);
   }
}
