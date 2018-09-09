<table class="layui-table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" name="" value="">
        </th>
        <th>ID</th>
        <th>登录名</th>
        <th>密码</th>
        <th>角色</th>
        <th>角色状态</th>
        <th>加入时间</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($admin_list as $list_key => $admin_child)
            <tr>
                <td>
                    <input type="checkbox" value="1" name="">
                </td>
                <td>{{$admin_child['a_id']}}</td>
                <td>{{$admin_child['a_username']}}</td>
                <td>{!! $admin_child['a_password'] !!}</td>
                <td>{!! $admin_child['role_name'] !!}</td>
                <td>
                    @if ($admin_child['role_is_delete'] == 1)
                        <span class="layui-btn layui-btn-mini layui-btn-disabled">已删除</span>
                    @endif
                </td>
                <td>{!! $admin_child['a_add_time'] !!}</td>
                <td class="td-status">
                    @if ($admin_child['a_is_disabled']==0)
                        <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
                    @else
                        <span class="layui-btn layui-btn-mini layui-btn-disabled">禁用</span>
                    @endif
                </td>
                <td class="td-manage">
                    <button class="disabled-data-bt layui-btn layui-btn-primary layui-btn-sm" data-disabled="{$admin_child.a_is_disabled}" data-url="{:url('Admin/Power/disAdmin',array('id'=>$admin_child['a_id']),true,true)}">
                        @if ($admin_child['a_is_disabled']==0)禁用@else启用@endif
                    </button>
                    <button class="edit-data-bt layui-btn layui-btn-primary layui-btn-sm" data-url="{:url('Admin/Power/editAdmin',array('id'=>$admin_child['a_id']),true,true)}" title="编辑">
                        <i class="layui-icon">&#xe642;</i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
    var total_page = parseInt('{{$page_total}}');
</script>