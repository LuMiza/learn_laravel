<!DOCTYPE html>
<html>

<head>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>角色修改</title>
    <link rel="stylesheet" href="{{asset('/static/common/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('/static/admin/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('/static/admin/css/main.css')}}">
    <script src="{{asset('/static/admin/layui/layui.js')}}"></script>
    <script src="{{asset('/static/admin/js/base.js')}}"></script>
    <script src="{{asset('/static/admin/js/jquery.min.js')}}" charset="utf-8"></script>
    <script src="{{asset('/static/common/js/select2.min.js')}}" charset="utf-8"></script>
</head>
<body>
<div style="padding: 10px 10px;">
    <form id="data-form" class="layui-form layui-form-pane" action="">
        {{csrf_field()}}
        <input type="hidden" name="role_id" value="{{$data_list['role_id']}}">
        <div class="layui-form-item">
            <label class="layui-form-label">角色名</label>
            <div class="layui-input-block">
                <input type="text" name="name" value="{!! $data_list['role_name'] !!}" autocomplete="off" placeholder="请输入角色名" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">描述</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" name="description" class="layui-textarea">{!! $data_list['role_description'] !!}</textarea>
            </div>
        </div>
        <div class="layui-form-item" style="text-align: center;">
            <button class="layui-btn" type="button">保存</button>
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
        function RoleEvent(){
            this.add = function(){
                $('button[type="button"]').click(function(){
                    $.post('{{route("admin::Admin.Power.editRole")}}',$('#data-form').serialize(),function(data,textStatus){
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

        (new RoleEvent()).add();

    });

</script>


</body>

</html>
