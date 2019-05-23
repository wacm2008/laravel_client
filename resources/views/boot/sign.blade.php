<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="/js/jquery.js"></script>
    <script src="/bootstrap/js/bootstrap.js"></script>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
</head>
<body>
<!-- Indicates a successful or positive action -->
<button type="button" class="btn btn-success" id="butt">（签到）Sign</button>
</body>
</html>
<script>
    $(function(){
        var uid="{{$uid}}";
        $('#butt').click(function () {
            $.ajax({
                type:'get',
                url : "http://client.1809a.com/boot/sign",
                data: {uid:uid},
                success:function(res){
                    console.log(res);
                }
            });
        })
    })
</script>