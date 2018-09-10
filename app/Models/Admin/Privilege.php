<?php

namespace App\Models\Admin;

use App\Common\Help\VerifyAction;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    //表名
    protected $table = 'privilege';
    //主键
    protected $primaryKey = 'p_id';

    public  $timestamps = false;

    public function getList($page,$pageSize)
    {
        $result = $this->select(\DB::raw('concat(p_paths,",",p_id) as level_paths'),'privilege.*')
            ->skip(($page-1) * $pageSize)
            ->take($pageSize)
            ->orderBy('level_paths')
            ->get()
            ->toArray();
        return $result;
    }

    /**
     * 添加  或 修改权限
     * @param $post
     * @param bool $isEdit  false:add true:edit
     */
    public function addOrEditRule($post, $isEdit=false)
    {
       //权限名称
       if (!isset($post['name']) || empty(trim($post['name']))) {
            return ['msg' => '请填写权限名称', 'code' => 0];
       }
       //父级权限
        if (!isset($post['parent_id']) || !VerifyAction::isInt($post['parent_id'])) {
            return ['msg' => '请选择父级权限', 'code' => 0];
        }
        //模块名称
        if (!isset($post['module_name']) || !in_array($post['module_name'], ['admin'])) {
            return ['msg' => '目前统一填写admin', 'code' => 0];
        }
        //路由别名
        if (!isset($post['route_name'])) {
            return ['msg' => '请填写路由别名', 'code' => 0];
        }
        //控制器动作
        if (!isset($post['action_name'])) {
            return ['msg' => '请填写控制器动作', 'code' => 0];
        }
        $data = [];
        $data['p_name'] = trim($post['name']);
        $data['p_pid'] = trim($post['parent_id']);
        $data['style_name'] = isset($post['style_name'])? trim($post['style_name']): '';
        $data['module_name'] = trim($post['module_name']);
        $data['route_name'] = trim($post['route_name']);
        $data['action_name'] = trim($post['action_name'])? ('App\Http\Controllers\\' . trim($post['action_name'])): '';
        $data['p_paths'] = '0';
        if (trim($post['parent_id'])) {
            $list = $this->find($post['parent_id'])->toArray();
            if (!$list) {
                return ['msg' => '服务器繁忙', 'code' => 0];
            }
            $data['p_paths'] = $list['p_paths'] .','. $list['p_id'];
        }
        $result = $this->insertGetId($data);
        return $result ? ['msg' => '添加权限成功', 'code' => 1]: ['msg' => '添加权限失败', 'code' => 0];
    }
}
