<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{config('webs.admin.config.title')}}</title>
    <link rel="stylesheet" href="{{asset('/static/admin/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('/static/admin/wdfont/iconfont.css')}}">
    <link rel="stylesheet" href="{{asset('/static/admin/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('/static/common/css/font-awesome.min.css')}}">
    <script src="{{asset('/static/admin/layui/layui.js')}}"></script>
    <script src="{{asset('/static/admin/js/base.js')}}"></script>
</head>

<body>
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <div class="layui-logo" onclick="window.location.replace('{{route("admin::Admin.Index.index")}}');" style="cursor: pointer;">后台管理</div>
            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-right" lay-filter="UserNav">
                <li class="layui-nav-item">
                    <a id="close-all-iframe-bt" href="javascript:void(0);" title="关闭所有页面">
                        <img src="{{asset('/static/admin/images/avatar.png')}}" class="layui-nav-img">
                        {{config('webs.admin.config.title')}}
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" data-url="examples/form.html" data-id="22">基本资料</a><dd>
                        <dd><a href="javascript:;" data-url="examples/form.html" data-id="23">安全设置</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="layui-icon">&#xe629;</i>主题</a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" data-skin="0">默认</a></dd>
                        <dd><a href="javascript:;" data-skin="1">蓝白</a></dd>
                    </dl>
            	</li>
                <li class="layui-nav-item"><a href="{{route('admin::Admin.Login.getLogout')}}">注销</a></li>
            </ul>
        </div>

        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <ul class="layui-nav layui-nav-tree" lay-filter="leftNav">
                    {!! $menu_string !!}
                        {{--<li class="layui-nav-item">--}}
                            {{--<a class="javascript:;" href="javascript:void(0);">--}}
                                {{--<i class="fa    fa-lg" aria-hidden="true"></i>--}}
                                {{--<cite></cite>--}}
                            {{--</a>--}}
                            {{--<dl class="layui-nav-child">--}}
                                {{--<dd class="">--}}
                                    {{--<a href="javascript:void(0);" data-url="" data-id="">--}}
                                        {{--<cite></cite>--}}
                                    {{--</a>--}}
                                {{--</dd>--}}
                            {{--</dl>--}}
                        {{--</li>--}}


                    <!--<li class="layui-nav-item ">-->
                        <!--<a class="" href="javascript:;"><i class="wdfont wdicon-youqingwailian"></i>链接</a>-->
                        <!--<dl class="layui-nav-child">-->
							<!--<dd><a href="javascript:;" data-url="{:url('Power/role','',true,true)}" data-id="1000"><i class="wdfont wdicon-W" data-icon="fa-qq"></i>角色管理</a></dd>-->
                            <!--<dd><a href="javascript:;" data-url="{:url('Power/index','',true,true)}" data-id="1001"><i class="wdfont wdicon-youqing" data-icon="wdicon-youqing"></i>管理员列表</a></dd>-->
                            <!--<dd><a href="javascript:;" data-url="{:url('Power/rule','',true,true)}" data-id="1002"><i class="wdfont wdicon-QQ" data-icon="wdicon-square-QQ"></i>权限列表</a></dd>-->
                        <!--</dl>-->
                    <!--</li>-->
                </ul>
            </div>
        </div>

        <!-- 内容主体区域 -->
        <div class="layui-body">
            <!-- 顶部切换卡 -->
            <div class="layui-tab " lay-filter="main-tab" lay-allowclose="true">
                <div class="layui-tab-tool open" title="收起">
                    <i class="wdfont wdicon-xiangzuojiantou"></i>
                </div>
                <ul id="iframe-tab-list" class="layui-tab-title" style="z-index: 999;">
                    <li lay-id="0" class="layui-this"><i class="wdfont wdicon-shouye"></i>首页</li>
                </ul>
                <div id="iframe-page-list" class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <iframe id="0" src="{{route('admin::Admin.Index.getDesktop')}}" class="layui-tab-iframe"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- 底部固定区域 -->
         <div class="layui-footer">
          Copyright © <a href="javascript:void(0);" target="_self">{{config('webs.admin.config.title')}}</a>
        </div> 
    </div>
   <script type="text/javascript">
       layui.use(['layer'], function() {
           var $ = layui.$;//jquery
           layer = layui.layer;//弹出层

           function WindowEvent(){
               this.close =  function(){
                   $(document).on('click','#close-all-iframe-bt',function(){
                       var len = $('#iframe-tab-list li').length;
                       if( len > 1 ){
                           $('#iframe-tab-list li').eq(0).addClass('layui-this');
                           $('#iframe-page-list').children('.layui-tab-item').eq(0).addClass('layui-tab-item layui-show');
                           for (var i=len;i>0;i--){
                               $('#iframe-tab-list li').eq(i).remove();
                               $('#iframe-page-list').children('.layui-tab-item').eq(i).remove();
                           }
                       }
                   });
               };
               this.refreshCache = function(){
                   $(document).on('click','#refresh-admin-info-bt',function(){
                       $.post("{:url('Login/refresh',array(),true,true)}",function(data){
                           if( (typeof data.code !='undefined') && (typeof data.msg !='undefined') ){
                               layer.alert(data.msg, { title:"操作提示",icon: data.code,time:1000});
                               return;
                           }else{
                               layer.alert('服务器繁忙', { title:"操作提示",icon: 0,time:1000});
                               return;
                           }
                       },'json');
                   });
               }
           }
           (new WindowEvent()).close();
           (new WindowEvent()).refreshCache();
       });
   </script>
</body>
</html>