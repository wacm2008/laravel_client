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
    <form action="/test/logindo" method="post">
        @csrf
        用户名：<input type="text" name="name" id="name"><br>
        密码：<input type="password" name="pwd" id="pwd"><br>
        <input type="submit" value="登录" id="butt">
    </form>
</body>
</html>
<script src="/js/jquery.js"></script>
<script>
    // $(function(){
    //     $('#butt').click(function () {
    //         var name=$("#name").val();
    //         var pwd=$("#pwd").val();
    //         $.ajax({
    //             type:'post',
    //             url : "http://api.1809a.com/test/a",
    //             data: {name:name,pwd:pwd},
    //             success:function(res){
    //                 console.log(res);
    //             }
    //         });
    //     })
    // })
</script>