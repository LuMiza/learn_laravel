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

    /**
     * 处理查询条件
     * @param $post
     */
    public function searchWhere($post)
    {
        $_this = \DB::table($this->table);
        $this->search_flag = true;
        if (isset($post['is_delete']) && in_array($post['is_delete'], [0,1])) {
            $_this->where('p_is_delete', $post['is_delete']);
        } else {
            $_this->where('p_is_delete', 0);
        }
        if (isset($post['parent_id']) && VerifyAction::isId($post['parent_id'])) {
            $_this->where('p_pid', $post['parent_id']);
        }
        if (isset($post['name']) && !empty(trim($post['name']))) {
            $_this->where('p_name', 'like', '%'.trim($post['name']).'%');
        }
        return $_this;
    }

    /**
     * 统计符合的数据
     * @return int
     */
    public function getTotal($obj)
    {
        return $obj->count();
    }
    /**
     * 获取权限列表
     * @param $page  页码
     * @param $pageSize  每页展示数据
     * @return mixed
     */
    public function getList($page, $pageSize, $obj)
    {
        $result = $obj->select(\DB::raw('concat(p_paths,",",p_id) as level_paths'),'privilege.*')
            ->skip(($page-1) * $pageSize)
            ->take($pageSize)
            ->orderBy('level_paths', 'asc')
            ->get();
        return $result;
    }

    /**
     * 添加  或 修改权限
     * @param $post
     * @param bool $isEdit  false:add true:edit
     * @return array
     */
    public function addOrEditRule($post, $isEdit=false)
    {
        if ($isEdit) {
            if (!isset($post['privilege_id']) || !VerifyAction::isId($post['privilege_id'])) {
                return ['msg' => '非法操作', 'code' => 0];
            }
        }
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

        if (strpos(trim($post['action_name']), 'App\Http\Controllers\\') !==false) {
            $data['action_name'] = trim($post['action_name']);
        } else {
            $data['action_name'] = trim($post['action_name'])? ('App\Http\Controllers\\' . trim($post['action_name'])): '';
        }

        $data['p_paths'] = '0';
        if (trim($post['parent_id'])) {
            $list = $this->find($post['parent_id'])->toArray();
            if (!$list) {
                return ['msg' => '服务器繁忙', 'code' => 0];
            }
            $data['p_paths'] = $list['p_paths'] .','. $list['p_id'];
        }
        if (!$isEdit) {
            $result = $this->insertGetId($data);
            return $result ? ['msg' => '添加权限成功', 'code' => 1]: ['msg' => '添加权限失败', 'code' => 0];
        } else {
            $result = $this->where('p_id', $post['privilege_id'])->update($data);
            return $result !==false ? ['msg' => '修改权限成功', 'code' => 1]: ['msg' => '修改权限失败', 'code' => 0];
        }
    }
}
