<?php
/**
 * Created by PhpStorm.
 * User: LDH
 * Date: 2019-10-30
 * Time: 17:49
 */

namespace app\api\validate;


class IDMustIntInt
{
    protected $rule = [
        'id' => 'require|isInteger',
        ];

    protected function isInteger($value, $rule='', $data='', $field=''){
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return $field . '必须是正整数';
    }
}