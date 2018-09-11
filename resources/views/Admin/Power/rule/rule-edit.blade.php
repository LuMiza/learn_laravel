<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>修改权限</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="{{asset('/static/common/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('/static/admin/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('/static/admin/css/main.css')}}">
    <script src="{{asset('/static/admin/layui/layui.js')}}"></script>
    <script src="{{asset('/static/admin/js/base.js')}}"></script>
    <script src="{{asset('/static/admin/js/jquery.min.js')}}" charset="utf-8"></script>
    <script src="{{asset('/static/common/js/select2.min.js')}}" charset="utf-8"></script>
    <style type="text/css">
        .select2-container .select2-selection--single{
            height:38px!important;
        }
        .select2-container .select2-selection__arrow{
            height:38px!important;
        }
        .select2-container .select2-selection__rendered{
            height:38px!important;
            line-height: 38px!important;
        }
    </style>
</head>

<body>
<div style="padding:5px 10px;">


    <form  id="data-form" onsubmit="return false;">
        {{csrf_field()}}
        <input type="hidden" name="privilege_id" value="{!! $data_list['p_id'] !!}">
        <div class="layui-form-item">
            <label class="layui-form-label">权限名称</label>
            <div class="layui-input-block">
                <input type="text" value="{!! $data_list['p_name'] !!}" name="name"  autocomplete="off" placeholder="请输入权限名称" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">父级权限</label>
            <div class="layui-input-block">
                <select name="parent_id" lay-verify="required" lay-search="">
                    <option value="">请选择</option>
                    <option value="0">顶级权限</option>
                    @foreach ($privilege_list as $privilege_key => $privilege_child)
                        <option value="{{$privilege_child['p_id']}}" @if ($privilege_child['p_id']==$data_list['p_pid']) selected="selected" @endif >
                            @if ($privilege_child['level']>2){{str_repeat('&nbsp;&nbsp;',$privilege_child['level'])}}├@endif{!! $privilege_child['p_name'] !!}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">模块名称</label>
            <div class="layui-input-inline">
                <input type="text" value="{!! $data_list['module_name'] !!}" name="module_name" lay-verify="pass" placeholder="目前统一填admin" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">目前统一填admin</div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">路由别名</label>
            <div class="layui-input-block">
                <input type="text" value="{!! $data_list['route_name'] !!}" name="route_name"   placeholder="例如：admin::Admin.Power.index" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">控制器动作</label>
            <div class="layui-input-block">
                <input type="text" value="{!! $data_list['action_name'] !!}" name="action_name"  placeholder="例如：Admin\PowerController@index" autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">样式名称</label>
            <div class="layui-input-inline">
                <input type="text" value="{!! $data_list['style_name'] !!}" name="style_name"  placeholder="请输入样式名称" autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                权限图标css样式名，可不填，<a href="http://www.fontawesome.com.cn/faicons/" target="_blank" style="color:red;">查看</a>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="" type="button">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<script>
    $('select').select2({width:'100%'});
    layui.use(['form','layer'], function(){
        //$ = layui.jquery;
        layer = layui.layer;

        function RuleEvent(){
            this.add = function(){
                $('button[type="button"]').click(function(){
                    $.post('{{route("admin::Admin.Power.editRule")}}',$('#data-form').serialize(),function(data,textStatus){
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
        (new RuleEvent()).add();
    });
</script>
</body>

</html>