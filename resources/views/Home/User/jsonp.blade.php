<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Generator" content="EditPlus®">
    <meta name="Author" content="">
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <title>jsonp</title>
    <script src="/Home/js/jquery.min.js" type="text/javascript"></script>
    <script>
        // function showdata(result){
        //     console.log(result);
        // }
    </script>
    {{--<script src="http://www.tp5.com:8080/index.php/Index/Index?callback=showdata" type="text/javascript"></script>--}}
    <script src="http://www.laravel.cn/User/response" type="text/javascript"></script>
</head>
<body>

<center>
    <button type="button">jsonp demo</button>
</center>
<script>
    $(function(){

        $('button').click(function(){
            $.ajax({
                 url: "http://www.tp5.com:8080/index.php/Index/Index",
                 type: "GET",
                // dataType:'json',
                 dataType: "jsonp",  //指定服务器返回的数据类型
                 jsonp: "callback",   //指定参数名称
                 jsonpCallback: "success",  //指定回调函数名称
                 success: function (data) {
                     console.info("调用success");
                     console.log(data);
                 }
            });
        });

    });
</script>
</body>
</html>
