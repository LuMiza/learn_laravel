# AdminTemplate #

WDPHP后台模板布局是基于LayUI 2.0实现的网站后台模板，支持所有LayUI组件。遵循原生HTML/CSS/JS的书写与组织形式，门槛极低，拿来即用。

官方下载地址：[http://www.wdphp.com/search/AdminTemplate](http://www.wdphp.com/search/AdminTemplate)

码云：[https://gitee.com/zunyunkeji/AdminTemplate](https://gitee.com/zunyunkeji/AdminTemplate)

演示网址可在官方下载地址处找到。

## 几个常用AJAX请求方法 ##

- JSON数据格式 

``
{"code":1,"msg":"操作成功！"}``
``

- AJAX请求

``
<a href="demo.php" class="ajax-get">ajax-get示例</a>
``
``
<a href="demo.php" class="ajax-post" target-form="表单class名称">ajax-post示例</a>
``
``
<a href="demo.php" class="ajax-get confirm">删除确认示例</a>
``

- 页面弹出层

``
<a href="http://www.wdphp.com" class="ajax-open" wdphp-width="800" wdphp-height="600" wdphp-title="WDPHP素材源码">页面预览</a>
``