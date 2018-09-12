<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{config('webs.admin.config.title')}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('/static/admin/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('/static/admin/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('/static/common/css/font-awesome.min.css')}}">
    <script src="{{asset('/static/admin/layui/layui.js')}}"></script>
    <script src="{{asset('/static/admin/js/base.js')}}"></script>
    <script type="text/javascript">
        //js判断是否在iframe中
        if (self != top) {
            console.log('在iframe中');
            // parent.location.reload();
        }
        //js判断是否在iframe中
        if (self.frameElement && self.frameElement.tagName == "IFRAME") {
            console.log('在iframe中 two');
        }
    </script>
    <style type="text/css">
        .login-main{
            width:400px;
            margin:10% auto;
            border:2px dashed #C6C6C6;
            padding:20px 20px;
            border-radius: 5px;
        }
        .layui-input{
            display: inline-block!important;
        }
        .login-title{
            width: 100%;
            padding:0px 0px 9px 0px;
            text-align: center;
            font-size:1.3em;
            /*font-weight: bold;*/
            color: #757575;
        }
    </style>
</head>
<body>

<div class="login-main">
    <form id="data-form" class="layui-form" action="" onsubmit="return false;">
        {{csrf_field()}}
        <div class="login-title">{{config('webs.admin.config.title')}}</div>
        <div class="layui-form-item">
            <label class="layui-form-label" style="display: inline-block;padding: 9px 5px;width: auto;">
                <i class="fa fa-user" aria-hidden="true" style="color:#C6C6C6;"></i>
            </label>
            <div class="layui-input-inline" style="width: 92%;">
                <input type="text" name="username" lay-verify="title" autocomplete="off" placeholder="请输入用户名" class="layui-input" >
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label" style="display: inline-block;padding: 9px 5px;width: auto;">
                <i class="fa fa-asterisk" aria-hidden="true" style="color:#C6C6C6;"></i>
            </label>
            <div class="layui-input-inline" style="width:91%;">
                <input type="password" name="password" lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button id="login-admin-bt" class="layui-btn layui-btn-primary"  type="button">登录</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

</div>
<script type="text/javascript">
    layui.use(['layer'], function() {
        var $ = layui.$;//jquery
        layer = layui.layer;//弹出层
        function LoginEvent(){
            this.request = function(){
                $.post('{{route("admin::Admin.Login.postIndex")}}',$('#data-form').serialize(),function(data,textStatus){
                    if( textStatus == 'success' ){
                        layer.alert(data.msg, { title:"操作提示",icon: data.code,time:1000});
                        if( data.code == "1" ){
                            window.location.href = data.url;
                            return;
                        }
                        return;
                    }else{
                        layer.alert('服务器繁忙', { title:"操作提示",icon: 0,time:1000});
                        return;
                    }
                },'json');
            };
            this.login = function(){
                var _this = this;
                $('#login-admin-bt').click(function(){
                    _this.request();
                });
            };
            //监听enter键
            this.enter = function(){
                var _this = this;
                $(document).keyup(function(e){
                    // 兼容FF和IE和Opera
                    var theEvent = e || window.event;
                    var code = theEvent.keyCode || theEvent.which || theEvent.charCode;
                    if (code == 13) {
                        _this.request();
                        return;
                    }
                });
            }
        }
        (new LoginEvent()).login();
        (new LoginEvent()).enter();

    });
</script>
</body>
</html>
