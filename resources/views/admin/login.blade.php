<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理员登录</title>
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon"/>
    @include('admin.public.styles')
    @include('admin.public.script')

</head>
<body class="login-bg">
<div class="login" style="margin-top:190px">
    <div class="message">后台管理</div>
    <div id="darkbannerwrap"></div>
    @if (count($errors) > 0)
        @if(is_object($errors))
            <script>
                $(function () {
                    layui.use('form', function () {
                        layer.msg('表单验证规则错误!', function () {
                            //关闭后的操作
                        });
                    });
                })
            </script>
            <div style="border:1px solid rgb(220, 222, 224);border-radius: 3px;color:red">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @else
            <script>
                $(function () {
                    layui.use('form', function () {
                        layer.msg('{{$errors}}', function () {
                            //关闭后的操作
                        });
                    });
                })
            </script>
        @endif
    @endif
    <hr class="hr15">

    <form method="post" action="{{url('admin/doLogin')}}" class="layui-form">
        {{ csrf_field() }}
        <input name="username" placeholder="用户名" type="text" lay-verify="required" class="layui-input">
        <hr class="hr15">
        <input name="password" lay-verify="required" placeholder="密码" type="password" class="layui-input">
        <hr class="hr15">
        <input name="code"  style="width:180px;float:left" lay-verify="required" type="text" placeholder="验证码">
        <a onclick="javascript:re_captcha();">
        <img style="float:right;border:1px solid rgb(220, 222, 224);border-radius: 3px"  src="{{ URL('/code/captcha/1') }}" id="127ddf0de5a04167a9e427d883690ff6">
        </a>
        <hr class="hr15">
        <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
        <hr class="hr20">
    </form>
</div>
<script type="text/javascript">
    function re_captcha() {
        $url = "{{ URL('/code/captcha') }}";
        $url = $url + "/" + Math.random();
        document.getElementById('127ddf0de5a04167a9e427d883690ff6').src = $url;
    }
</script>
</body>
</html>
