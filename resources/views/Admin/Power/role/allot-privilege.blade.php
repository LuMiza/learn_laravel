<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>角色分配权限</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/static/admin/layui/css/layui.css">
    <link rel="stylesheet" href="/static/admin/css/main.css">
    <script src="/static/admin/layui/layui.js"></script>
    <script src="/static/admin/js/base.js"></script>
    <style type="text/css">
        h4{
            padding:10px 5px;
            font-weight: bold;
            background-color: #979797;
            color: #FFF;
        }
        .priv-list{
            display: inline-block;
            margin-left:35px;
        }
        .priv-list > label{
            display: inline-block;
            padding:5px 5px;
        }
        .priv-menu{
            margin-left:20px;
            padding: 10px 0px;
            font-weight: bold;
            border-bottom: 1px solid #979797;
        }
        .child-priv-label{
            display: inline-block;
        }
    </style>
</head>

<body>
<div style="padding:5px 10px;">
    <form id="data-form"  onsubmit="return false;">
        <input type="hidden" name="role_id" value="{$role_id}">
        <div class="layui-form-item layui-form-text">

            {!! $list_string !!}

                    {{--<div class="menu-content-box">--}}
                       {{--<h4>--}}
                               {{--<label>{$privilege_child.p_name}&nbsp;<input name="priv_ids[]" type="checkbox" value="{$privilege_child.p_id}"></label>--}}
                       {{--</h4>--}}
                            {{--<div class="priv-child-box">--}}
                                {{--<div class="priv-menu">--}}
                                        {{--<label>&nbsp;<input name="priv_ids[]" type="checkbox" value=""></label>--}}
                                {{--</div>--}}
                                {{--<div   class="priv-list">--}}

                                    {{--<label class="child-priv-label"><input name="priv_ids[]" type="checkbox" value="" checked="checked"></label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                    {{--</div>--}}


        </div>
        <div class="layui-form-item">
            <button type="button" class="layui-btn" lay-submit="" lay-filter="add">保存</button>
        </div>
    </form>
</div>
<script>
    layui.use(['layer'], function(){
        $ = layui.jquery;
        var layer = layui.layer;

        function AllotEvent(){
            this.lastChild = function(){
                $(document).on('click','.priv-list input[name="priv_ids[]"]',function(){
                    if( this.checked ){
                        // $(this).parent().parent().siblings().children().children().attr('checked','checked');
                        // $(this).parent().parent().parent().siblings().children().children().attr('checked','checked');
                        $.each($(this).parent().parent().siblings().children().children(),function(){
                            this.checked = true;
                        });
                        $.each($(this).parent().parent().parent().siblings().children().children(),function(){
                            this.checked = true;
                        });
                    }
                });
            },
            this.childMenu = function(){
                $(document).on('click','.priv-menu input[name="priv_ids[]"]',function(){
                    if( this.checked ){
                        // $(this).parent().parent().siblings().find('input').attr('checked','checked');
                        // $(this).parent().parent().parent().siblings().children().children().attr('checked','checked');
                        $.each( $(this).parent().parent().siblings().find('input'),function(){
                            this.checked = true;
                        });
                        $.each( $(this).parent().parent().parent().siblings().children().children(),function(){
                            this.checked = true;
                        });
                    }else{
                        $.each( $(this).parent().parent().siblings().find('input'),function(){
                            this.checked = false;
                        });
                        //$.each( $(this).parent().parent().parent().siblings().children().children(),function(){
                            //this.checked = false;
                        //});
                    }
                });
            },
            this.topMenu = function(){
                $(document).on('click','.menu-content-box h4 input[name="priv_ids[]"]',function(){
                    if( this.checked ){
                        // $(this).parent().parent().siblings().find('input').attr('checked','checked');
                        $.each($(this).parent().parent().siblings().find('input'),function(){
                            this.checked = true;
                        });
                    }else{
                        $.each($(this).parent().parent().siblings().find('input'),function(){
                            this.checked = false;
                        });
                    }
                });
            },
            this.saveData = function(){
                $('button[type="button"]').click(function(){
                    $.post('{:url("Admin/Power/allotPriv",array(),true,true)}',$('#data-form').serialize(),function(data,textStatus){
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
        (new AllotEvent()).lastChild();
        (new AllotEvent()).childMenu();
        (new AllotEvent()).topMenu();
        (new AllotEvent()).saveData();

    });
</script>
</body>

</html>