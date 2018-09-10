<table class="layui-table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" name="" value="">
        </th>
        <th>ID</th>
        <th>权限名称</th>
        <th>模块</th>
        <th>路由别名</th>
        <th>控制器方法</th>
        <th>样式</th>
        <th>父id</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody id="x-link">
        @foreach ($rule_list as $rule_key => $rule_child)
        <tr>
            <td>
                <input type="checkbox" value="1" name="">
            </td>
            <td>{{$rule_child['p_id']}}</td>
            <td>
                @if (count(explode(',',$rule_child['level_paths'])) > 2)
                    <span style="color:green;padding:0px 0px;font-weight: bold;">
                        {{str_repeat('&nbsp;&nbsp;',count(explode(',',$rule_child['level_paths'])))}}├
                    </span>
                @endif
                {!! $rule_child['p_name'] !!}
            </td>
            <td>{!! $rule_child['module_name'] !!}</td>
            <td>{!! $rule_child['route_name'] !!}</td>
            <td>{!! $rule_child['action_name'] !!}</td>
            <td>{!! $rule_child['style_name'] !!}</td>
            <td>{{$rule_child['p_pid']}}</td>
            <td class="td-manage">
                <a class="edit-bt ml-5" title="编辑" href="javascript:void(0);" data-url="{:url('Power/editRule',array('id'=>$rule_child['p_id']),true,true)}"  style="text-decoration:none">
                    <i class="layui-icon">&#xe642;</i>
                </a>
                <a class="delete-data-bt" title="删除" href="javascript:void(0);" data-url="{:url('Power/delRule',array('id'=>$rule_child['p_id']),true,true)}" style="text-decoration:none">
                    <i class="layui-icon">&#xe640;</i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
    var total_page = parseInt('{{$page_total}}');
</script>