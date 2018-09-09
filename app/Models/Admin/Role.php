<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //表名
    protected $table = 'role';
    //主键
    protected $primaryKey = 'role_id';

    public  $timestamps = false;

}
