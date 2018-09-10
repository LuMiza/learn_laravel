<!DOCTYPE html>
<html>

<head>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>权限列表</title>
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
        <button id="add-rule-bt"  class="layui-btn" id="btn-add">添加</button>
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

<script type="text/javascript">
    var total_page = 0;
    layui.use(['layer'], function(){
        var $ = layui.$;//jquery
        layer = layui.layer;//弹出层
        //以上模块根据需要引入

        function initContentList(url,isInitFlag)
        {
            var postData = {_token:'{{csrf_token()}}'};
            $.post(url,postData,function(data){
                layer.closeAll();
                $('#content-box-table ').html('');
                $('#content-box-table ').html(data);
                console.log(total_page);
                if( typeof isInitFlag !='undefined' && isInitFlag == true ){
                    (new RuleEvent()).initPage(total_page);
                }
            });
        }

        initContentList('{{route("admin::Admin.Power.rule")}}',true);

        function RuleEvent(){
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
                            var url = '{php} echo urldecode(url("Power/rule",array("p"=>"###"),true,true)); {/php}';
                            var last_url = url.replace(/###/gi,api.getCurrent());
                            initContentList(last_url,false);
                        }
                    });
                }
            },
                //添加权限
                this.add = function(){
                    $('#add-rule-bt').click(function(){
                        layer.open({
                            type: 2,
                            area: ['600px', '470px'],
                            fix: false, //不固定
                            maxmin: true,
                            shadeClose: true,
                            shade:0.4,
                            title: '添加权限',
                            content: '{{route("admin::Admin.Power.addRule")}}',
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
                                area: ['600px', '470px'],
                                fix: false, //不固定
                                maxmin: false,
                                shadeClose: true,
                                shade:0.4,
                                title: '编辑权限',
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
                            $.post( $.trim($(this).attr('data-url')),function(data,textStatus){
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
                }
        }
        (new RuleEvent()).add();
        (new RuleEvent()).edit();
        (new RuleEvent()).deleteData();
    });

</script>


</body>

</html>