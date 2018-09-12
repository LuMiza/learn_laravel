<?php

namespace App\Models\Admin;

use App\Common\Help\VerifyAction;
use Illuminate\Database\Eloquent\Model;

class RolePrivilege extends Model
{
    //表名
    protected $table = 'role_privilege';
    //主键
    protected $primaryKey = '';

    public  $timestamps = false;

    /**
     * 角色分配权限
     * @param $post
     * @return array
     */
    public function allotPrivilege($post)
    {
        if (!isset($post['role_id']) || !VerifyAction::isId($post['role_id'])) {
            return ['msg'=>'非法操作', 'code'=>0];
        }
        $data = [];
        if (isset($post['priv_ids']) && is_array($post['priv_ids']) && VerifyAction::isArrNum($post['priv_ids'])) {
            foreach ($post['priv_ids'] as $val) {
                array_push($data, ['rp_pid'=>trim($val), 'rp_role_id'=>$post['role_id']]);
            }
        }
        \DB::beginTransaction();
        $delResult = $this->where('rp_role_id', $post['role_id'])->delete();
        if (!$data) {
            if ($delResult === false) {
                \DB::rollBack();
                return ['msg'=>'权限分配失败', 'code'=>0];
            }
            \DB::commit();
            return ['msg'=>'权限分配成功', 'code'=>1];
        }
        $priv_result = $this->insert($data);
        if ($priv_result === false) {
            \DB::rollBack();
            return ['msg'=>'权限分配失败', 'code'=>0];
        }
        \DB::commit();
        return ['msg'=>'权限分配成功', 'code'=>1];
    }
}
