<?php

namespace app\validate;

use nickbai\tp6curd\extend\ExtendValidate;

class HandlineValidate extends ExtendValidate
{
    protected $rule = [
//    'id' => 'require',
    'title' => 'require',
    'context' => 'require',
    'img' => 'require',
//    'created_at' => 'require',
//    'updated_at' => 'require',
//    'deleted_at' => 'require',
];

    protected $attributes = [
    'id' => '',
    'title' => '',
    'context' => '',
    'img' => '',
    'created_at' => '',
    'updated_at' => '',
    'deleted_at' => '',
];
}