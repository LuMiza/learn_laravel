<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>后台系统</title>
    <link rel="stylesheet" href="{{asset('/static/admin/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('/static/admin/css/main.css')}}">
    <script src="{{asset('/static/admin/layui/layui.js')}}"></script>
    <script src="{{asset('/static/admin/js/base.js')}}"></script>
</head>

<body style="padding:10px">
    <div class="layui-col-xs12">
        <blockquote class="layui-elem-quote">
           今天是{{date('Y-m-d H:i:s', time())}}，欢迎回来！
        </blockquote>
    </div>
    <table class="layui-table">
        <thead>
            <tr>
                <th colspan="4" scope="col">服务器信息</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>操作系统</td>
                <td>Linux 3.10.0-514.21.1.el7.x86_64</td>
                <td>服务器域名</td>
                <td>www.wdphp.com</td>
            </tr>
            <tr>
                <td>服务器IP地址</td>
                <td>192.168.1.102</td>
                <td>服务器端口</td>
                <td>80</td>
            </tr>
            <tr>
                <td>服务器当前时间</td>
                <td>{{date('Y-m-d H:i:s', time())}}</td>
                <td>服务器解译引擎</td>
                <td>nginx/1.12.0</td>
            </tr>
        </tbody>
    </table>
    <div class="layui-row layui-col-space10">
        <div class="layui-col-md6">
            <div class="layui-collapse">
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">更新说明</h2>
                    <div class="layui-colla-content layui-show">
                        <ul class="layui-timeline">
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title">Ver 1.0.171130 released</h3>
                                    <span class="layui-badge-rim">2017-11-30</span>
                                    <p>增加后台风格切换功能，并新增两种风格。<br>增加 ajax-get、ajax-post、confirm 等一些常用JS操作方法。</p>
                                </div>
                            </li>
                            <li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title">Ver 1.0.171016 released</h3>
                                    <span class="layui-badge-rim">2017-10-16</span>
                                    <p>WDPHP后台模板 正式版发布</p>
                                </div>
                            </li>
							<li class="layui-timeline-item">
                                <i class="layui-icon layui-timeline-axis">&#xe63f;</i>
                                <div class="layui-timeline-content layui-text">
                                    <h3 class="layui-timeline-title">Ver 1.0.170929 beta</h3>
                                    <span class="layui-badge-rim">2017-09-29</span>
                                    <p>WDPHP后台模板 测试版发布</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md6">
            <div class="layui-collapse">
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title">基础信息</h2>
                    <div class="layui-colla-content layui-show">
                      <table class="layui-table layui-table-m">
                            <colgroup>
                                <col width="150">
                                <col>
                            </colgroup>
                            <tbody>
                                <tr>
                                    <td>系统名称</td>
                                    <td>WDPHP后台模板</td>
                                </tr>
                                <tr>
                                    <td>版本信息</td>
                                    <td>1.0.171130</td>
                                </tr>
                                <tr>
                                    <td>开发者</td>
                                    <td>WDPHP素材源码</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>