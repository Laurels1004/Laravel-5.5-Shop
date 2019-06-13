<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>文章列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    @include('admin.public.styles')
    @include('admin.public.script')
  </head>

  <body>
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
    <div class="x-body">
      <table class="layui-table">
        @if (count($goods) > 0)
        <thead>
          <tr>
            <th>ID</th>
            <th>商品名称</th>
            <th>缩略图</th>
            <th>商品价格(元)</th>
            <th>商品库存(件)</th>
            <th>商品销量(件)</th>
            <th>商品状态</th>
            <th>是否推荐</th>
            <th>入库时间</th>
            <th>操作</th></tr>
        </thead>
        <tbody>
        @foreach($goods as $v)
          <tr>
            <td>{{$v->goods_id}}</td>
            <td>{{$v->goods_name}}</td>
            <td><img src="{{$v->goods_thumb}}" alt="" style="width:90px;height:50px;"></td>
            <td>{{$v->goods_price}}</td>
            <td>{{$v->goods_stock}}</td>
            <td>{{$v->goods_sales}}</td>
            <td class="td-active">
                @if($v->goods_active == 0)
              <span class="layui-btn layui-btn-normal layui-btn-mini">已上架</span>
                @else
              <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">已下架</span>
                @endif
            </td>
            <td class="td-status">
                @if($v->goods_status == 1)
              <span class="layui-btn layui-btn-normal layui-btn-mini">已添加到推荐位</span>
                @else
              <span class="layui-btn layui-btn-normal layui-btn-mini layui-btn-disabled">未加入推荐位</span>
                @endif
            </td>
            <td>{{date('Y-m-d-H-i',$v->goods_time)}}</td>
            <td class="td-manage">
              <a title="编辑"  onclick="x_admin_show('编辑','{{ url('admin/goods/'.$v->goods_id.'/edit') }}',800,600)" href="javascript:;">
                <i class="layui-icon">&#xe642;</i>
              </a>
              <a title="删除" onclick="member_del(this,{{ $v->goods_id }})" href="javascript:;">
                <i class="layui-icon">&#xe640;</i>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
          <tr>
            <th>没有数据...</th>
          </tr>
        </tbody>
      </table>
      @endif

    </div>
    <script>
      layui.use(['form','layer','laydate'], function(){
        var laydate = layui.laydate;
          var form = layui.form;

        //执行一个laydate实例
        laydate.render({
          elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
          elem: '#end' //指定元素
        });

      });

      /*文章-删除*/
      function member_del(obj,id){
          layer.confirm('确认要删除吗？',function(index){
              //发异步删除数据
              $.post('{{ url('admin/goods/') }}/'+id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                  if(data.status == 0){
                      $(obj).parents("tr").remove();
                      layer.msg('已删除!',{icon:1,time:1000});
                  }else{
                      layer.msg('删除失败!',{icon:2,time:1000});
                  }

              })
          });
      }
    </script>

  </body>

</html>
