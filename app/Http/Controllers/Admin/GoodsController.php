<?php

namespace App\Http\Controllers\Admin;

use App\Model\Cate;
use App\Model\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取所有文章,返回视图
        $goods = Goods::get();
        return view('admin.goods.list',compact('goods'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取格式化后的分类并返回视图
        $cates = (new Cate())->format();
        return view('admin.goods.add',compact('cates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //1.获取发送来的数据
        $input = $request->except('_token', 'photo');
        $input['goods_time'] = time();

        //2.数据入库
        $res = Goods::create($input);
        if($res){
            return redirect('admin/goods');
        }else{
            return back();
        }
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
        //获取分类和对应ID的商品,并返回视图
        $cates = (new Cate())->format();
        $goods = Goods::find($id);
        return view('admin.goods.edit',compact('cates','goods'));
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
        //获取前台发送的数据
        $input = $request->except('goodid','_token','photo','file');

        //修改表记录
        $good = Goods::find($id);
        $res = $good->update($input);
        if($res){
            $data=[
                'status'=>0,
                'msg'=>'修改成功!'
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'修改失败!'
            ];
        }
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //通过ID查找商品并删除
        $res = Goods::find($id)->delete();
        if($res){
            $data = [
                'status'=>0,
                'message'=>'删除成功!'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'删除失败!'
            ];
        }
        return $data;
    }

    //文件上传
    public function upload(Request $request)
    {
        //1.获取上传文件
        $file = $request->file('photo');

        //2.验证上传文件的有效性
        if(!$file->isValid()){
            return response()->json(['ServerNo'=>'400','ResultData'=>'上传文件无效']);
        }

        //3.获取源文件扩展名
        $extraname = $file->getClientOriginalExtension();

        //4.生成新文件名
        $newfilename = md5(time().rand(1000,9999)).'.'.$extraname;

        //5.指定文件上传路径
        $filepath = public_path('uploads');

        //6.图片处理,保存文件至指定位置
        $res = Image::make($file)->resize(185,160)->save($filepath.'/'.$newfilename);
        if ($res) {
            // 上传成功
            return response()->json(['ServerNo'=>'200', 'ResultData'=>$newfilename]);
        } else {
            return response()->json(['ServerNo'=>'400', 'ResultData'=>'文件上传失败!']);
        }


    }
}
