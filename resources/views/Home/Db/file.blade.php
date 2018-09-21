<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文件上传</title>
</head>
<body>
    <div style="margin:5% auto;width:100px;">
        <form enctype ="multipart/form-data" method="post" action="/db/upload"  >
            {{csrf_field()}}
            <div style="margin-top:30px;">
                <input type="file" name="remote_upload[]"   multiple="multiple">
            </div>
            <div style="margin-top:30px;">
                <button type="submit">提交</button>
            </div>
        </form>
    </div>
</body>
</html>