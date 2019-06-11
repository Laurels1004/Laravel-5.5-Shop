<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>用户所属角色设置</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    @include('admin.public.styles')
    @include('admin.public.script')
    <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
    <!--[if lt IE 9]>
    <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
    <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="x-body">
    <form class="layui-form" action="{{ url('/admin/user/doauth') }}" method="post">
        <div class="layui-form-item">
            <label for="username" class="layui-form-label">
                <span class="x-red">*</span>用户名
            </label>
            <div class="layui-input-inline">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                <input type="text" id="username" name="username" required="" lay-verify="required"
                       autocomplete="off" value="{{ $user->user_name }}" class="layui-input" readonly="readonly" style="cursor: default">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"><span class="x-red">*</span>用户所属角色</label>
            <div class="layui-input-block">
                @foreach ($roles as $v)
                    @if (in_array($v->id, $userown_roleids))
                        <input type="checkbox" name="role_id[]" value="{{ $v->id }}" lay-skin="primary" title="{{ $v->role_name }}"
                               checked="">
                    @else
                        <input type="checkbox" name="role_id[]" value="{{ $v->id }}" lay-skin="primary" title="{{ $v->role_name }}">
                    @endif
                @endforeach
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="edit" lay-submit="">
                修改
            </button>
        </div>
    </form>

</div>
<script>
    layui.use(['form','layer'], function(){
        $ = layui.jquery;
        var form = layui.form
            ,layer = layui.layer;

        //自定义验证规则
        form.verify({
            nikename: function(value){
                if(value.length < 1){
                    return '角色名至少得1个字符啊';
                }
            }
        });
    });
</script>
<script>var _hmt = _hmt || []; (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();</script>
</body>

</html>
