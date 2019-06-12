<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>文章添加</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.public.styles')
    @include('admin.public.script')
    <style>
        .input_width{
            width: 600px;
        }
    </style>
</head>

<body>
    <div class="x-body">
        <form class="layui-form" id="goods_form" action="{{ url('admin/goods') }}" method="post">
          <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">
                  <span class="x-red">*</span>分类
              </label>
              <div class="layui-input-inline">
                  <select name="cate_id">
                      @foreach($cates as $k=>$v)
                          <option value="{{ $v->cate_id }}">{{ $v->cate_name }}</option>
                      @endforeach
                  </select>
              </div>
              <div class="layui-form-mid layui-word-aux">
                  <span class="x-red"></span>
              </div>
          </div>

            <div class="layui-form-item">
                <label for="L_goods_title" class="layui-form-label">
                    <span class="x-red">*</span>文章标题
                </label>
                <div class="layui-input-block">
                    {{csrf_field()}}
                    <input type="text" id="L_goods_title" name="goods_title" required=""
                           autocomplete="off" class="layui-input input_width">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_goods_editor" class="layui-form-label">
                    <span class="x-red">*</span>编辑
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_goods_editor" name="goods_editor" required=""
                           autocomplete="off" class="layui-input input_width">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">缩略图</label>
                <div class="layui-input-block layui-upload">
                    <input type="hidden" id="img1" class="hidden" name="goods_thumb" value="">
                    <button type="button" class="layui-btn" id="test1">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    <input type="file" name="photo" id="photo_upload" style="display: none;" />
                </div>
            </div>


            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label"></label>
                <div class="layui-input-block">
                    <img src="" id="goods_thumb_img" style="max-width: 350px; max-height:100px;" alt="">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_goods_tag" class="layui-form-label">
                    <span class="x-red">*</span>关键词
                </label>
                <div class="layui-input-inline">
                    <input type="text" id="L_goods_tag" name="goods_tag" required=""
                           autocomplete="off" class="layui-input input_width">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_goods_tag" class="layui-form-label">
                    <span class="x-red">*</span>描述
                </label>
                <div class="layui-input-block">
                    <textarea placeholder="请输入内容" class="layui-textarea input_width" name="goods_description"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="L_goods_tag" class="layui-form-label">
                    <span class="x-red">*</span>内容
                </label>
                <div class="layui-input-block">
                    {{--引入配置文件--}}
                    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
                    {{--编辑器源码文件--}}
                    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"> </script>
                    {{--引入语言包--}}
                    <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>

                    {{--编辑器容器--}}
                    <script id="editor" type="text/plain" name="goods_content" style="width:600px;height:300px;">
                    </script>
                    <script type="text/javascript">
                    //实例化编辑器
                    var ue = UE.getEditor('editor');
                    </script>
                </div>
            </div>
          <div class="layui-form-item">
              <label for="L_repass" class="layui-form-label">
              </label>
              <button  class="layui-btn" lay-filter="add" lay-submit="">
                  添加
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
                                {{--$('#goods_thumb_img').attr('src', '{{ env('QINIU_DOMAIN')  }}'+data['ResultData']);--}}
                                {{--ver1&ver2--}}
                                // $('#goods_thumb_img').attr('src', '/uploads/'+data['ResultData']);
                                // $('input[name=goods_thumb]').val('/uploads/'+data['ResultData']);
                                // ver3
                                $('#goods_thumb_img').attr('src', '{{ env('ALIOSS_DOMAIN')  }}'+data['ResultData']);
                                $('input[name=goods_thumb]').val('{{ env('ALIOSS_DOMAIN')  }}'+data['ResultData']);
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
        });
    </script>
</html>
