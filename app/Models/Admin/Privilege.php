<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    //表名
    protected $table = 'privilege';
    //主键
    protected $primaryKey = 'p_id';

    public  $timestamps = false;
}
