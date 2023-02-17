<?php

namespace app\controller;

use app\model\Comment as CommentModel;
use app\validate\CommentValidate;
use think\exception\ValidateException;

class Comment extends Base
{
    /**
    * 获取列表
    */
    public function getList()
    {
        if (request()->isPost()) {

            $limit  = input('post.limit');
            $where = [];

            $CommentModel = new CommentModel();
            $list = $CommentModel->getCommentList($where, $limit);

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

            // 检验完整性
            try {
                validate(CommentValidate::class)->check($param);
            } catch (ValidateException $e) {
                return jsonReturn(-1, $e->getError());
            }

            $CommentModel = new CommentModel();
            $res = $CommentModel->addComment($param);

            return json($res);
        }
    }

    /**
    * 查询信息
    */
    public function read()
    {
        $id = input('param.sid');

        $CommentModel = new CommentModel();
        $info = $CommentModel->getCommentById($id);

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
                validate(CommentValidate::class)->check($param);
            } catch (ValidateException $e) {
                return jsonReturn(-1, $e->getError());
            }

            $CommentModel = new CommentModel();
            $res = $CommentModel->editComment($param);

            return json($res);
         }
    }

    /**
    * 删除
    */
    public function del()
    {
        $id = input('param.sid');

        $CommentModel = new CommentModel();
        $info = $CommentModel->delCommentById($id);

        return json($info);
   }
}
