<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //表名
    protected $table = 'admin';
    //主键
    protected $primaryKey = 'a_id';

    public  $timestamps = false;

    public function adminRole()
    {
//        return $this->belongsTo('App\Models\Admin\AdminRole','a_id','ar_aid');
//        return $this->hasOne('App\Models\Admin\AdminRole','ar_aid','a_id');
        return $this->hasMany('App\Models\Admin\AdminRole','ar_aid','a_id');
    }

    /**
     * 获取管理员列表
     * @param $page 页码
     * @param $pageSize 每页显示多少
     * @return array|static[]
     */
    public function getList($page, $pageSize)
    {
        $result =  \DB::connection()
            ->table('admin')
            ->select(
                'a_id',
                'a_username',
                'a_password',
                'a_is_disabled',
                'a_add_time',
                'ar_role_id',
                'role_name',
                'role_is_delete'
            )
            ->join('admin_role','admin_role.ar_aid','=','admin.a_id')
            ->join('role','admin_role.ar_role_id','=','role.role_id')
            ->skip(($page - 1) * $pageSize)
            ->take($pageSize)
            ->orderBy('admin.a_add_time','desc')
            ->get();
        return $result? $result: [];
    }

    /**
     * 添加管理员
     * @param $post
     * @return array
     */
    public function addAdmin($post)
    {
        if (!isset($post['username']) || empty($post['username'])) {
            return ['msg' => '请填写用户名', 'code' => 0];
        }
        if (!isset($post['password']) || !preg_match('/^\d{6}$/',$post['password'])) {
            return ['msg' => '密码应为六位数字', 'code' => 0];
        }
        if (!isset($post['re_password']) || !preg_match('/^\d{6}$/',$post['re_password'])) {
            return ['msg' => '确认密码应为六位数字', 'code' => 0];
        }
        if ($post['re_password'] != $post['password']) {
            return ['msg' => '两次密码输入不一致', 'code' => 0];
        }
        if (!isset($post['is_disabled']) || !in_array($post['is_disabled'], [0,1])) {
            return ['msg' => '请选择是否禁用', 'code' => 0];
        }
        if (!isset($post['role_id']) || !preg_match('/^[1-9]{1}\d*$/',$post['role_id'])) {
            return ['msg' => '请选择角色', 'code' => 0];
        }
        $data = [
            'a_username' => $post['username'],
            'a_password' => $post['password'],
            'a_is_disabled' => $post['is_disabled'],
        ];
        \DB::beginTransaction();
        $result = $this->insertGetId($data);
        if ($result === false) {
            \DB::rollBack();
            return ['msg' => '添加失败', 'code' => 0];
        }
        $role_result = \DB::table('admin_role')->insertGetId(['ar_role_id'=>$post['role_id'], 'ar_aid'=>$result]);
        if ($role_result === false) {
            \DB::rollBack();
            return ['msg' => '添加失败', 'code' => 0];
        }
        \DB::commit();
        return ['msg' => '添加成功', 'code' => 1];
    }

}
