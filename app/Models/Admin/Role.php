<?php

namespace App\Models\Admin;

use App\Common\Help\VerifyAction;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //表名
    protected $table = 'role';
    //主键
    protected $primaryKey = 'role_id';

    public  $timestamps = false;

    /**
     * 获取角色列表
     * @param $page
     * @param $pageSize
     * @return mixed
     */
    public function getList($page, $pageSize)
    {
        $result = $this->where('role_is_delete', 0)
            ->skip(($page-1) * $pageSize)
            ->take($pageSize)
            ->orderBy('role_add_time', 'desc')
            ->get()
            ->toArray();
        return $result? $result: [];
    }

    /**
     * 添加  或 修改角色
     * @param $post
     * @param $isEdit   false:add    true:edit
     * @return mixed
     */
    public function addOrEditRole($post, $isEdit)
    {
        if (!isset($post['name']) ||empty(trim($post['name']))) {
            return ['msg' => '请填写角色名称', 'code' => 0];
        }
        if ($isEdit) {
            if (!isset($post['role_id']) || !VerifyAction::isId($post['role_id'])) {
                return ['msg' => '非法操作', 'code' => 0];
            }
        }
        $data = [
            'role_name' => trim($post['name']),
            'role_description' => isset($post['description'])? trim($post['description']): '',
        ];
        if (!$isEdit) {
            $result = $this->insertGetId($data);
            return $result === false ? ['msg' => '添加失败', 'code' => 0]: ['msg' => trim($post['name']).'  添加成功', 'code' => 1];
        } else {
            $result = $this->where('role_id', trim($post['role_id']))->update($data);
            return $result === false ? ['msg' => '修改失败', 'code' => 0]: ['msg' => trim($post['name']).'  修改成功', 'code' => 1];
        }
    }

}
