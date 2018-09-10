<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    //表名
    protected $table = 'admin_role';
    //主键
    protected $primaryKey = 'ar_aid';

    public  $timestamps = false;
}
