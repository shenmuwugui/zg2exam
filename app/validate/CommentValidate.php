<?php

namespace app\validate;

use nickbai\tp6curd\extend\ExtendValidate;

class CommentValidate extends ExtendValidate
{
    protected $rule = [
//    'sid' => 'require',
    'pid' => 'require',
    'content' => 'require',
//    'created_at' => 'require',
//    'updated_at' => 'require',
//    'deleted_at' => 'require',
];

    protected $attributes = [
    'sid' => '',
    'pid' => '',
    'content' => '',
    'created_at' => '',
    'updated_at' => '',
    'deleted_at' => '',
];
}