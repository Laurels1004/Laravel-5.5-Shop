<?php

namespace App\Http\Controllers\Admin;

use App\Model\Cate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 1.执行分类处理操作
        $cates = (new Cate())->format();
        $count_cates = count($cates);
        return view('admin.cate.list', compact('cates', 'count_cates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取一级分类,返回添加分类视图
        $cate = Cate::where('cate_pid',0)->get();
        return view('admin.cate.add',compact('cate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1.接收前台提交表单数据
        $input = $request->all();

        // 2.进行表单验证

        // 3.添加到数据库的cate表
        $catename = $input['catename'];
        $catetitle = $input['catetitle'];
        $cateorder = $input['cateorder'];
        $catepid = $input['catepid'];

        $res = Cate::create(['cate_name'=>$catename, 'cate_title'=>$catetitle, 'cate_order'=>$cateorder, 'cate_pid'=>$catepid]);
        // 4.根据添加是否成功,给客户端返回一个json格式反馈
        if ($res) {
            $data = [
                'status' => 0,
                'message' => '添加成功!'
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '添加失败!'
            ];
        }
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //根据ID获取要修改的分类,返回编辑视图
        $cate = Cate::find($id);
        return view('admin.cate.edit', compact('cate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 1.根据ID获取到要修改的分类
        $cate = Cate::find($id);

        // 2.获取要修改的值
        $catename = $request->input('catename');
        $catetitle = $request->input('catetitle');
        $cateorder = $request->input('cateorder');

        $cate->cate_name = $catename;
        $cate->cate_title = $catetitle;
        $cate->cate_order = $cateorder;

        $res = $cate->save();
        if ($res) {
            $data = [
                'status' => 0,
                'message' => '修改成功!'
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '修改失败'
            ];
        }
        return  $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cate = Cate::find($id);

        $res = $cate->delete();
        if ($res) {
            $data = [
                'status' => 0,
                'message' => '删除成功!'
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '删除失败'
            ];
        }
        return $data;
    }

    // 删除选中的分类
    public function delAll(Request $request)
    {
        $input = $request->input('ids');

        $res = Cate::destroy($input);
        if ($res) {
            $data = [
                'status' => 0,
                'message' => '批量删除成功!'
            ];
        } else {
            $data = [
                'status' => 1,
                'message' => '批量删除失败!'
            ];
        }
        return $data;
    }
}
