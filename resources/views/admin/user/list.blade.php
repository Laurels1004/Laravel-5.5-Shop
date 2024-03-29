<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>用户列表页</title>
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
    @if (count($errors) > 0)
      <script>
          $(function  () {
              layui.use('form', function(){
                  layer.msg('{{$errors}}');
              });
          })
      </script>
    @endif
    <div class="x-nav">
      <span class="layui-breadcrumb">
        <a href="">首页</a>
        <a href="">演示</a>
        <a>
          <cite>导航元素</cite></a>
      </span>
      <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" href="javascript:location.replace(location.href);" title="刷新">
        <i class="layui-icon" style="line-height:30px">ဂ</i></a>
    </div>
      <div class="layui-row">
        <form style="margin-top: 20px"  class="layui-form layui-col-md12 x-so" method="get" action="{{url('admin/user')}}">
          <div class="layui-input-inline">
            <select name="number" lay-filter="aihao">
              <option value="" >每页显示条数(默认12条)</option>
              <option value="8" @if($request->input('number')==8) selected @endif>8条</option>
              <option value="16" @if($request->input('number')==16) selected @endif>16条</option>
              <option value="32" @if($request->input('number')==32) selected @endif>32条</option>
              <option value="64" @if($request->input('number')==64) selected @endif>64条</option>
            </select>
          </div>
          <input type="text" name="username" value="{{$request->input('username')}}" placeholder="请输入用户名" autocomplete="off"
                 class="layui-input">
          <input type="email" name="useremail" value="{{$request->input('useremail')}}" placeholder="请输入用户邮箱" autocomplete="off"
                 class="layui-input">
          <input type="phone" name="userphone" value="{{$request->input('userphone')}}" placeholder="请输入用户电话" autocomplete="off"
                 class="layui-input">
          <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
        </form>
      </div>
      <xblock>
        <button class="layui-btn layui-btn-danger" onclick="delAll()"><i class="layui-icon"></i>批量删除</button>
        <span class="x-right" style="line-height:40px">共有数据：{{$count_users}} 条</span>
      </xblock>
      <table class="layui-table">
        <thead>
        @if (count($users) > 0)
          <tr>
            <th>
              <div class="layui-unselect header layui-form-checkbox" lay-skin="primary"><i class="layui-icon">&#xe605;</i></div>
            </th>
            <th>序号</th>
            <th>ID</th>
            <th>用户名</th>
            <th>邮箱</th>
            <th>手机</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $v)
          <tr>
            <td>
              <div class="layui-unselect layui-form-checkbox" lay-skin="primary" data-id='{{$v->user_id}}'><i class="layui-icon">&#xe605;</i></div>
            </td>
            <td>{{$i++}}</td>
            <td>{{$v->user_id}}</td>
            <td>{{$v->user_name}}</td>
            <td>{{$v->email}}</td>
            <td>{{$v->phone}}</td>
            @if($v->status == 1)
            <td class="td-status">
              <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span>
            </td>
            <td class="td-manage">
              <a onclick="member_stop(this,'{{$v->user_id}}')" href="javascript:;" status="{{$v->status}}" title="停用">
                <i class="layui-icon">&#xe601;</i>
              </a>
            @else
              <td class="td-status">
                <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">已停用</span>
              </td>
              <td class="td-manage">
                <a onclick="member_stop(this,'{{$v->user_id}}')" href="javascript:;" status="{{$v->status}}" title="启用">
                  <i class="layui-icon">&#xe62f;</i>
                </a>
             @endif
              <a title="编辑"  onclick="x_admin_show('编辑','{{url('admin/user/'. $v->user_id. '/edit/?tag=edit')}}',600,405)"
                 href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              <a onclick="x_admin_show('修改密码','{{url('admin/user/'. $v->user_id. '/edit/?tag=pass')}}',600,405)" title="修改密码"
                 href="javascript:;">
                <i class="layui-icon">&#xe631;</i>
              </a>
              <a title="删除" onclick="member_del(this,'{{$v->user_id}}')" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <div class="page">
        {!! $users->appends($request->all())->render() !!}
      </div>
      @else
          <tr>
            <th>没有数据...</th>
          </tr>
        </tbody>
      </table>
      @endif
    </div>
    <script>
      layui.use('laydate', function(){
        var laydate = layui.laydate;

        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });
      });

       /*用户-停用*/
      function member_stop(obj,id){
          var str = '';
          $(obj).attr('title') == '启用' ? str = '启用' : str = '停用';
          layer.confirm('确认'+str+'吗?',function(index){
              var status = $(obj).attr('status');
              if (status == 1) {
                  status = 0;
              } else {
                  status = 1;
              }
              $.post("user/changestatus", { 'status': status,'id':id, "_token": "{{csrf_token()}}"}, function(data){
                  if (data.status !== undefined) {
                      if (data.status == 0) {
                          if ($(obj).attr('title') == '启用') {

                              $(obj).attr('title', '停用')
                              $(obj).find('i').html('&#xe601;');

                              $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                              layer.msg('已启用!', {icon: 1, time: 1000});

                          } else {
                              $(obj).attr('title', '启用')
                              $(obj).find('i').html('&#xe62f;');

                              $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                              layer.msg('已停用!', {icon: 1, time: 1000});
                          }
                          $(obj).attr('status', status);
                      } else {
                          layui.use('form', function () {
                              layer.msg(data.message, function () {
                              });
                          });
                      }
                  } else {
                      layer.msg('访问失败,权限不足!',function(){});
                  }

              });
          });
      }

      /*用户-删除*/
      function member_del(obj,id) {
          layer.confirm('确认要删除吗？', function (index) {
              //发异步删除数据
              $.post('/admin/user/' + id, {"_method": "delete", "_token": "{{csrf_token()}}"}, function (data) {
                  // console.log(data.message);
                  // 弹层提示添加成功,移除当前元素
                  if (data.status !== undefined) {
                      if (data.status == 0) {
                          $(obj).parents("tr").remove();
                          layer.alert(data.message, {icon: 6, time: 1000}, function(){
                              location.replace(location.href);
                          });
                      } else {
                          layer.alert(data.message, {icon: 5, time: 1000});
                      }
                  } else {
                      layer.msg('访问失败,权限不足!',function(){});
                  }
                  // $(obj).parents("tr").remove();
                  // layer.msg('已删除!',{icon:1,time:1000});
              });
          });
      }



      function delAll (argument) {
        // 获取到批量删除的用户id
        var ids = [];

        $(".layui-form-checked").not('.header').each(function(i, v){
            // ajax数组
            var u = $(v).attr('data-id');
            ids.push(u);
        });


        layer.confirm('确认要删除吗？',function(index){
            $.post('user/del', {'ids': ids, "_token": "{{csrf_token()}}"}, function(data) {
                // console.log(data);
                // 弹层提示添加成功,移除当前元素
                if (data.status == 0) {
                    $(".layui-form-checked").not('.header').parents('tr').remove();
                    layer.alert(data.message, {icon: 6, time: 1000}, function(){
                        location.replace(location.href);
                    });
                } else {
                    layer.alert(data.message, {icon: 5, time: 1000});
                }
            });
            //捉到所有被选中的，发异步进行删除
            //layer.msg('删除成功', {icon: 1});
        });
      }
    </script>
  </body>

</html>
