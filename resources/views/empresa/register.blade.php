<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/e_reg" method="post" enctype="multipart/form-data">
        @csrf
        企业名称：<input type="text" name="e_name" /><br>
        法人：<input type="text" name="e_corpo" /><br>
        税务号：<input type="text" name="e_impuesto" /><br>
        对公账号：<input type="text" name="e_bcard" /><br>
        营业执照：<input type="file" name="e_licencia" value="文件上传" /><br>
        <input type="submit" value="注册" />
    </form>
</body>
</html>