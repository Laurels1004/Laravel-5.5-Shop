<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>欢迎页面-X-admin2.0</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      @include('admin.public.styles')
      @include('admin.public.script')
    <style>
        .input_width{
            width: 188px;
        }
    </style>
  </head>

  <body>
    <div class="x-body">
        <form class="layui-form" id="goods_form">
            <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">
                    <span class="x-red">*</span>分类
                </label>
                <div class="layui-input-inline">
                    <select name="cate_id">
                        {{--<option value="0">==顶级分类==</option>--}}
                        @foreach($cates as $k=>$v)
                            @if($v->cate_id == $goods->cate_id)
                            <option selected value="{{ $v->cate_id }}">{{ $v->cate_name }}</option>
                            @else
                            <option  value="{{ $v->cate_id }}">{{ $v->cate_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="layui-form-mid layui-word-aux">
                    <span class="x-red">*</span>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_goods_name" class="layui-form-label">
                    <span class="x-red">*</span>商品名称
                </label>
                <div class="layui-input-block">
                    {{csrf_field()}}
                    <input type="text" id="L_goods_name" name="goods_name" required=""
                           autocomplete="off" class="layui-input input_width" value="{{ $goods->goods_name }}">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">缩略图</label>
                <div class="layui-input-block layui-upload">
                    <input type="hidden" id="img1" class="hidden" name="goods_thumb" value="{{ $goods->goods_thumb }}">
                    <button type="button" class="layui-btn" id="test1">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    <input type="file" name="photo" id="photo_upload" style="display: none;" />
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label"></label>
                <div class="layui-input-block">
                    <img src="{{ $goods->goods_thumb }}" id="goods_thumb_img" style="max-width: 185px; max-height:160px;" alt="">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="L_goods_price" class="layui-form-label">
                    <span class="x-red">*</span>商品价格
                </label>
                <div class="layui-input-inline">
                    <input type="number" id="L_goods_price" name="goods_price" required=""
                           autocomplete="off" class="layui-input input_width" value="{{ $goods->goods_price }}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_goods_stock" class="layui-form-label">
                    <span class="x-red">*</span>商品库存
                </label>
                <div class="layui-input-inline">
                    <input type="number" id="L_goods_stock" name="goods_stock" required=""
                           autocomplete="off" class="layui-input input_width" value="{{ $goods->goods_stock }}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_goods_sales" class="layui-form-label">
                    <span class="x-red">*</span>商品销量
                </label>
                <div class="layui-input-inline">
                    <input type="number" id="L_goods_sales" name="goods_sales" required=""
                           autocomplete="off" class="layui-input input_width" value="{{ $goods->goods_sales }}">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_goods_active" class="layui-form-label">
                    <span class="x-red">*</span>商品状态
                </label>
                <div class="layui-input-inline" style="z-index: 1001">
                    <select id="L_goods_active" name="goods_active">
                            <option value="0">上架</option>
                            <option value="1">下架</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_goods_status" class="layui-form-label">
                    <span class="x-red">*</span>推荐栏位
                </label>
                <div class="layui-input-inline" style="z-index: 1000">
                    <select id="L_goods_status" name="goods_status">
                            <option value="0">否</option>
                            <option value="1">是</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_goods_desc" class="layui-form-label">
                    <span class="x-red">*</span>商品描述
                </label>
                <div class="layui-input-block">
                    <input type="text" id="L_goods_desc" name="goods_description" required=""
                           autocomplete="off" class="layui-input input_width" value="{{ $goods->goods_description }}">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">
                    <span class="x-red">*</span>详情内容
                </label>
                <div class="layui-input-block">
                    {{--引入配置文件--}}
                    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
                    {{--编辑器源码文件--}}
                    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"> </script>
                    {{--引入语言包--}}
                    <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>

                    {{--编辑器容器--}}
                    <script id="editor" type="text/plain" name="goods_content" style="width:600px;height:300px;z-index: 0">{!! $goods->goods_content !!}</script>
                    <script type="text/javascript">
                    //实例化编辑器
                    var ue = UE.getEditor('editor');
                    </script>
                </div>
            </div>
          <div class="layui-form-item">
              <input type="hidden" name="goodid" value="{{ $goods->goods_id }}">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="edit" lay-submit="">
                  修改
              </button>
          </div>
      </form>
    </div>

  </body>
<script>
    layui.use(['form','layer','upload','element'], function()
    {
        $ = layui.jquery;
        var form = layui.form
        ,layer = layui.layer;
        var upload = layui.upload;
        var element = layui.element;

        $('#test1').on('click',function ()
        {
            $('#photo_upload').trigger('click');
            $('#photo_upload').on('change',function () {
            var obj = this;

            var formData = new FormData($('#goods_form')[0]);
            $.ajax({
                url: '/admin/goods/upload',
                type: 'post',
                data: formData,
                // 因为data值是FormData对象，不需要对数据做处理
                processData: false,
                contentType: false,
                success: function(data){
                    if(data['ServerNo']=='200'){
                        // 如果成功
                        $('#goods_thumb_img').attr('src', '/uploads/'+data['ResultData']);
                        $('input[name=goods_thumb]').val('/uploads/'+data['ResultData']);
                        $(obj).off('change');
                    }else{
                        // 如果失败
                        alert(data['ResultData']);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var number = XMLHttpRequest.status;
                    var info = "错误号"+number+"文件上传失败!";
                    // 换成原图
                    // $('#pic').attr('src', '/file.png');
                    alert(info);
                },
                async: true
                });
            });

          });

        //监听提交
        form.on('submit(edit)', function(data){
            var goodid = $("input[name='goodid']").val();
            $.ajax({
                type: 'PUT',
                url: '/admin/goods/'+goodid,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                // data:JSON.stringify(data.field),
                data:data.field,
                success: function(data){

                    if(data.status == 0){
                        layer.alert("修改成功", {icon: 6},function () {
                            parent.location.reload();
                        });
                    }else{
                        layer.alert("修改失败", {icon: 5},function () {
                            parent.location.reload();
                        });
                    }
                },
                error:function(data) {
                },
            });
          return false;
        });
    });
</script>
</html>
