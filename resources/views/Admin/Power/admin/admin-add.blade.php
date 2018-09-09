<!DOCTYPE html>
<html>

<head>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>添加管理员</title>
    <link rel="stylesheet" href="{{asset('/static/admin/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('/static/admin/css/main.css')}}">
    <script src="{{asset('/static/admin/layui/layui.js')}}"></script>
    <script src="{{asset('/static/admin/js/base.js')}}"></script>
    <script src="{{asset('/static/admin/js/jquery.min.js')}}" charset="utf-8"></script>
</head>
<body>
<div style="padding: 10px 10px;">
    <form id="data-form" class="layui-form" action="" onsubmit="return false;">
        {{ csrf_field() }}
        <div class="layui-form-item">
            <label class="layui-form-label">登录名<span style="color:red;">*</span></label>
            <div class="layui-input-inline">
                <input type="text" name="username" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">字母、数字或_的组合</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">密码<span style="color:red;">*</span></label>
            <div class="layui-input-inline">
                <input type="password" name="password" lay-verify="pass" placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">密码仅能为六个数字</div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">确认密码<span style="color:red;">*</span></label>
            <div class="layui-input-inline">
                <input type="password" name="re_password" lay-verify="pass" placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux"></div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">是否禁用<span style="color:red;">*</span></label>
            <div class="layui-input-block">
                <select name="is_disabled" >
                    <option value="0">启用</option>
                    <option value="1">禁用</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-block">
                <label class="layui-form-label">角色<span style="color:red;">*</span></label>
                <div class="layui-input-block">
                    <select name="role_id" lay-verify="required" lay-search="">
                        <option value="">请选择角色</option>
                        @foreach ($role_list as $role_key => $role_child)
                            <option value="{{$role_child['role_id']}}">{!! $role_child['role_name'] !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" lay-filter="demo1" type="button">保存</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    layui.use(['element','form','table','layer'], function () {
        var $ = layui.$, //jquery
            element = layui.element, //元素操作
            form = layui.form, //表单
            table = layui.table, //数据表格
            layer = layui.layer; //弹出层
            function AdminEvent(){
                this.add = function(){
                    $('button[type="button"]').click(function(){
                        $.post('{{route("admin::Admin.Power.addAdmin")}}',$('#data-form').serialize(),function(data,textStatus){
                            if( textStatus == 'success' ){
                                layer.alert(data.msg, { title:"操作提示",icon: data.code,time:1000});
                                if( data.code == "1" ){
                                    setTimeout(function(){
                                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                        parent.layer.close(index);
                                    },1500);
                                }
                                return;
                            }else{
                                layer.alert('服务器繁忙', { title:"操作提示",icon: 0,time:1000});
                                return;
                            }
                        },'json');
                    });
                }
            }

            (new AdminEvent()).add();

    });

</script>


</body>

</html>
