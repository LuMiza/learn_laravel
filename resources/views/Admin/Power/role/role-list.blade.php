<!DOCTYPE html>
<html>

<head>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>角色列表</title>
    <link rel="stylesheet" href="{{asset('/static/admin/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('/static/admin/css/main.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/static/common/css/pagination.css')}}" media="screen">
    <script src="{{asset('/static/admin/layui/layui.js')}}"></script>
    <script src="{{asset('/static/admin/js/base.js')}}"></script>
    <script src="{{asset('/static/admin/js/jquery.min.js')}}" charset="utf-8"></script>
    <script src="{{asset('/static/common/js/jquery.pagination.js')}}" charset="utf-8"></script>
</head>

<body>

    <blockquote class="layui-elem-quote layui-table-tools">
        <div class="fl">
            <button class="layui-btn layui-btn-danger" id="btn-del">批量删除</button>
            <button id="add-role-bt"  class="layui-btn" id="btn-add">添加</button>
        </div>
        <div class="fr">
            <span class="layui-form-label">搜索条件：</span>
            <div class="layui-input-inline">
                <input type="text" autocomplete="off" placeholder="请输入搜索条件" class="layui-input">
            </div>
            <button class="layui-btn mgl-20">查询</button>
            <button class="layui-btn btn-add btn-default" id="btn-refresh" onclick="window.location.replace(location.href);"><i class="layui-icon">&#x1002;</i></button>
        </div>
    </blockquote>
    <!-- 数据表格 -->
    <div id="content-box-table"></div>
    <div class="pagination-style"></div>

    <!-- 工具条 -->
    <script type="text/html" id="tablebar">
        <a class="layui-btn layui-btn-mini" lay-event="detail">查看</a>
        <a class="layui-btn layui-btn-mini" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-mini" lay-event="del">删除</a>
    </script>
    <script type="text/javascript">
        var total_page = 0;
        layui.use(['element','form','table','layer'], function () {
		var $ = layui.$, //jquery
		element = layui.element, //元素操作
		form = layui.form, //表单
		table = layui.table, //数据表格
		// laypage = layui.laypage, //分页
		// laytpl = layui.laytpl, //模板引擎
		layer = layui.layer; //弹出层

        function initContentList(url,isInitFlag)
        {
            var postData = {_token:'{{csrf_token()}}'};
            $.post(url,postData,function(data){
                layer.closeAll();
                $('#content-box-table ').html('');
                $('#content-box-table ').html(data);
                if( typeof isInitFlag !='undefined' && isInitFlag == true ){
                    (new RoleEvent()).initPage(total_page);
                }
            });
        }

        initContentList('{{route("admin::Admin.Power.role")}}',true);


        function RoleEvent(){
            this.initPage = function(total_page){
                if( typeof total_page != 'undefined' && total_page != null  ){
                    $('.pagination-style').pagination({
                        pageCount:total_page,
                        jump: true,
                        coping: true,
                        homePage: '首页',
                        endPage: '末页',
                        prevContent: '上页',
                        nextContent: '下页',
                        callback: function (api) {
                            var url = '{{route("admin::Admin.Power.role",["p"=>"###"])}}';
                            var last_url = url.replace(/###/gi,api.getCurrent());
                            initContentList(last_url,false);
                        }
                    });
                }
            },
                //添加角色
                this.add = function(){
                    $('#add-role-bt').click(function(){
                        layer.open({
                            type: 2,
                            area: ['600px', '350px'],
                            fix: false, //不固定
                            maxmin: false,
                            shadeClose: true,
                            shade:0.4,
                            title: '添加角色',
                            content: '{{route("admin::Admin.Power.addRole")}}',
                            end:function(){
                                window.location.replace(window.location.href);
                            }
                        });
                    });
                },
                this.edit = function(){
                    $(document).on('click','.edit-bt',function(){
                        if( typeof $(this).attr('data-url') != 'undefined' ){
                            layer.open({
                                type: 2,
                                area: ['600px', '350px'],
                                fix: false, //不固定
                                maxmin: false,
                                shadeClose: true,
                                shade:0.4,
                                title: '编辑角色',
                                content: $.trim($(this).attr('data-url')),
                                end:function(){
                                    window.location.replace(window.location.href);
                                }
                            });
                            return;
                        }else{
                            layer.alert('数据有误无法操作', { title:"操作提示",icon: 0,time:1000});
                            return;
                        }
                    });
                },
                this.deleteData = function(){
                    $(document).on('click','.delete-data-bt',function(){
                        if( (typeof $(this).attr('data-url') != 'undefined')  ){
                            $.post( $.trim($(this).attr('data-url')), {_token:'{{csrf_token()}}'},function(data,textStatus){
                                if( textStatus == 'success' ){
                                    layer.alert(data.msg, { title:"操作提示",icon: data.code,time:1000});
                                    if( data.code == "1" ){
                                        setTimeout(function(){
                                            window.location.replace(window.location.href);
                                        },1500);
                                    }
                                    return;
                                }else{
                                    layer.alert('服务器繁忙', { title:"操作提示",icon: 0,time:1000});
                                    return;
                                }
                            },'json');
                            return;
                        }else{
                            layer.alert('数据有误无法操作', { title:"操作提示",icon: 0,time:1000});
                            return;
                        }
                    });
                },
                //角色分配权限
                this.allotPriv = function(){
                    $(document).on('click','.allot-privilege-bt',function(){
                        if( (typeof $(this).attr('data-url') != 'undefined') && (typeof $(this).attr('data-name') != 'undefined') ){
                            layer.open({
                                type: 2,
                                area: ['800px', '500px'],
                                fix: false, //不固定
                                maxmin: true,
                                shadeClose: true,
                                shade:0.4,
                                title: '正在给<span style="color:green;font-weight: bold;">【'+$(this).attr('data-name')+'】</span>分配权限',
                                content: $.trim($(this).attr('data-url')),
                                end:function(){
                                    window.location.replace(window.location.href);
                                }
                            });
                            return;
                        }else{
                            layer.alert('数据有误无法操作', { title:"操作提示",icon: 0,time:1000});
                            return;
                        }
                    });
                }
        }

        (new RoleEvent()).add();
        (new RoleEvent()).edit();
        (new RoleEvent()).deleteData();
        (new RoleEvent()).allotPriv();
	});

    </script>


</body>

</html>