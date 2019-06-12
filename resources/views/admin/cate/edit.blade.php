<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>分类编辑</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    {{--请求体中放置CSRF令牌--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <form class="layui-form">
        <div class="layui-form-item">
            <label for="L_catename" class="layui-form-label">
                <span class="x-red">*</span>分类名
            </label>
            <div class="layui-input-inline">
                <input type="hidden" name="id" value="{{$cate->cate_id}}">
                <input type="text" id="L_catename" value="{{$cate->cate_name}}" name="catename" required="" lay-verify="nikename"
                       autocomplete="off" class="layui-input">
            </div>
            <div class="layui-form-mid layui-word-aux">
                <span class="x-red">*</span>
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_title" class="layui-form-label">
                <span class="x-red">*</span>分类标题
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_title" value="{{$cate->cate_title}}" name="catetitle" required=""
                       autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_order" class="layui-form-label">
                <span class="x-red">*</span>分类排序
            </label>
            <div class="layui-input-inline">
                <input type="text" id="L_order" value="{{$cate->cate_order}}" name="cateorder" required=""
                       autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label for="L_repass" class="layui-form-label">
            </label>
            <button  class="layui-btn" lay-filter="eidt" lay-submit="">
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
                    return '分类名至少得1个字符啊';
                }
            }
        });

        //监听提交
        form.on('submit(eidt)', function(data){
            // 获取id
            var id = $("input[name='id']").val();
            //发异步，把数据提交给php
            $.ajax({
                type: 'PUT',
                url: '/admin/cate/'+id,
                'dataType': 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                'data': data.field,
                success: function(data){
                    // 弹层提示添加成功,并刷新父页面
                    if(data.status == 0) {
                        layer.alert(data.message, {icon: 6}, function(){
                            parent.location.reload(true);
                        });
                    } else {
                        layer.alert(data.message, {icon: 5});
                    }
                },
                error: function(){
                    // 错误信息
                }

            });
            return false;
        });


    });
</script>
</body>
</html>
