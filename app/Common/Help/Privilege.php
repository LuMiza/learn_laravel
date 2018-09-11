<?php
/**
 * 权限处理类
 * User: Administrator
 * Date: 2018/9/11
 * Time: 15:56
 */

namespace App\Common\Help;


class Privilege
{
    /**
     * 后台菜单处理 【该方法灵活，可以进行无限极处理  目前是定死  如果将if条件中的level修改 即为无限极】
     * @param $menus
     * @return string
     */
    public static function menuTree($menus)
    {
        /*
        $str = <<<EOF
<li class="layui-nav-item">
                            <a class="javascript:;" href="javascript:void(0);">
                                <i class="fa    fa-lg" aria-hidden="true"></i>
                                <cite></cite>
                            </a>
                            <dl class="layui-nav-child">
                                <dd class="">
                                    <a href="javascript:void(0);" data-url="" data-id="">
                                        <cite></cite>
                                    </a>
                                </dd>
                            </dl>
                        </li>
EOF;
        */
        $last = [];
        foreach ($menus as $key_menu => &$menu_child) {
            $menu_child['level'] = count(explode(',', $menu_child['level_paths']));
            //二级菜单
            if ($menu_child['level']==2 && !isset($last[$menu_child['level_paths']])) {
                $last[$menu_child['level_paths']] = [];
                $last[$menu_child['level_paths']]['footer'] = '</dl></li>';
                $last[$menu_child['level_paths']]['header'] = '<li class="layui-nav-item"><a class="javascript:;" href="javascript:void(0);"><i class="fa  '.$menu_child['style_name'].'  fa-lg" aria-hidden="true"></i>';
                $last[$menu_child['level_paths']]['header'] .= '<cite>'.$menu_child['p_name'].'</cite></a><dl class="layui-nav-child">';
            }
            //三级菜单
            if ($menu_child['level']==3 && isset($last[$menu_child['p_paths']])) {
                if (!isset($last[$menu_child['p_paths']]['list'])) {
                    $last[$menu_child['p_paths']]['list'] = '';
                }
                $last[$menu_child['p_paths']]['list'] .= '<dd class=""><a href="javascript:void(0);" data-url="'.route($menu_child['route_name']).'" data-id="'.$menu_child['p_id'].'">';
                $last[$menu_child['p_paths']]['list'] .= '<cite>'.$menu_child['p_name'].'</cite></a></dd>';
            }
        }
        unset($menus);
        $string = '';
        foreach ($last as $key_last => $last_val) {
            if (isset($last_val['header'], $last_val['list'], $last_val['footer'])) {
                $string .= $last_val['header'] . $last_val['list'] .$last_val['footer'];
            }
        }
        return $string;
    }

    public static function authTree($data)
    {
        /*
        <div class="menu-content-box">
                       <h4>
                               <label>{$privilege_child.p_name}&nbsp;<input name="priv_ids[]" type="checkbox" value="{$privilege_child.p_id}"></label>
                       </h4>
                            <div class="priv-child-box">
                                <div class="priv-menu">
                                        <label>&nbsp;<input name="priv_ids[]" type="checkbox" value=""></label>
                                </div>
                                <div   class="priv-list">

                                    <label class="child-priv-label"><input name="priv_ids[]" type="checkbox" value="" checked="checked"></label>
                                </div>
                            </div>
                    </div>
        */
        $last = [];
        foreach ($data as $key_data => &$data_val) {
            $data_val['level'] = count(explode(',', $data_val['level_paths']));
            //二级
            if ($data_val['level']==2 && !isset($last[$data_val['level_paths']])) {
                $last[$data_val['level_paths']] = [];
                $last[$data_val['level_paths']]['top'] = '<div class="menu-content-box"><h4><label>'.$data_val['p_name'].'&nbsp;<input name="priv_ids[]" type="checkbox" value="'.$data_val['p_id'].'"></label></h4>';
                $last[$data_val['level_paths']]['footer'] = '</div>';
                $last[$data_val['level_paths']]['box'] = [];
            }
            //三级 及以上
            if ($data_val['level']>=3 ) {

                if ($data_val['level']==3 && isset($last[$data_val['p_paths']])) {
                    if (!isset($last[$data_val['p_paths']]['box'][$data_val['level_paths']])){
                        $last[$data_val['p_paths']]['box'][$data_val['level_paths']] = [];
                    }
                    $last[$data_val['p_paths']]['box'][$data_val['level_paths']]['list'] = '';
                    $last[$data_val['p_paths']]['box'][$data_val['level_paths']]['header'] = '<div class="priv-child-box"><div class="priv-menu"><label>'.$data_val['p_name'].'&nbsp;<input name="priv_ids[]" type="checkbox" value="'.$data_val['p_id'].'"></label></div><div   class="priv-list">';
                }

                if ($data_val['level']>3) {
                    preg_match('/^(\d{1},\d{1}),\d{1}/', $data_val['p_paths'], $temp);
                    if (isset($temp[0],$temp[1])){
                        $last[$temp[1]]['box'][$temp[0]]['list'] .= '<label class="child-priv-label">'.$data_val['p_name'].'<input name="priv_ids[]" type="checkbox" value="'.$data_val['p_id'].'" checked="checked"></label>';
                    }
                }

            }
        }
        unset($data);
        $string = '';
        foreach ($last as $keyOne => $valOne) {
            $string .= $valOne['top'];
            foreach ($valOne['box'] as $keyTwo => $valTwo) {
                $string .= $valTwo['header'];
                $string .= $valTwo['list'] .'</div></div>';
            }
            $string .= $valOne['footer'];
        }
        return  $string;
    }
}