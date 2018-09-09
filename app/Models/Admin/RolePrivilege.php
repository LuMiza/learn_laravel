<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class RolePrivilege extends Model
{
    //表名
    protected $table = 'role_privilege';
    //主键
    protected $primaryKey = '';

    public  $timestamps = false;
}
