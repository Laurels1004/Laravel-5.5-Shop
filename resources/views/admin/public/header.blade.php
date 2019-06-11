<!-- 顶部开始 -->
<div class="container">
    <div class="logo"><a href="index.blade.php">博客管理</a></div>
    <div class="left_open">
        <i title="展开左侧栏" class="iconfont">&#xe699;</i>
    </div>
    <ul class="layui-nav right" lay-filter="">
        <li class="layui-nav-item">
            <a href="javascript:;">{{ Session::get('user')->user_name }}</a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
                <dd><a href="{{url('admin/logout')}}">退出</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item to-index"><a href="/index" target="_blank">前台首页</a></li>
    </ul>

</div>
<!-- 顶部结束 -->
