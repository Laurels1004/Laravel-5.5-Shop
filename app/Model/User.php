<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //1.关联数据表
    public $table = 'user';
    //2.主键
    public $primaryKey = 'user_id';
    //3.不允许操作的字段
    public $guarded = [];
    //4.不维护ctreated_at和updated_at字段
    public $timestamps = false;
}
