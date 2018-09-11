<table  class="layui-table">
    <thead>
    <tr>
        <th>
            <input type="checkbox" name="" value="">
        </th>
        <th>ID</th>
        <th>角色名</th>
        <th>权限</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
        @foreach ($data_list as $data_key => $role_child)
            <tr>
                <td>
                    <input type="checkbox" value="1" name="">
                </td>
                <td>{{$role_child['role_id']}}</td>
                <td>{!! $role_child['role_name'] !!}</td>
                <td >
                    <a class="allot-privilege-bt layui-btn  layui-btn-mini" href="javascript:void(0);" data-name="{!! $role_child['role_name'] !!}" data-url="{{route('admin::Admin.Power.allotPriv', ['id'=>$role_child['role_id']])}}" >分配权限</a>
                </td>
                <td >{!! $role_child['role_description'] !!}</td>
                <td class="td-manage">
                    <a class="edit-bt ml-5" data-url="{{route('admin::Admin.Power.editRole', ['id'=>$role_child['role_id']])}}" title="编辑" href="javascript:void(0);" style="text-decoration:none">
                        <i class="layui-icon">&#xe642;</i>
                    </a>
                    <a class="delete-data-bt" data-url="{{route('admin::Admin.Power.delRole', ['id'=>$role_child['role_id']])}}" title="删除" href="javascript:void(0);"  style="text-decoration:none">
                        <i class="layui-icon">&#xe640;</i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
     total_page = parseInt('{{$page_total}}');
</script>
