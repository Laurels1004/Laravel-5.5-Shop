<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    //1.关联数据表
    public $table = 'category';
    //2.主键
    public $primaryKey = 'cate_id';
    //3.不允许操作的字段
    public $guarded = [];
    //4.不维护ctreated_at和updated_at字段
    public $timestamps = false;

    //5.格式化分类数据
    public function format()
    {
        //按序号排序获取所有分类数据
        $cates = $this->orderBy('cate_order','asc')->get();

        //格式化(排序 二级类缩进)
        return $this->getFormat($cates);
    }

    //6.格式化(排序 二级类缩进)
    public function getFormat($category)
    {
        //存放最终排序完成的分类数据
        $cates = [];
        //获取一级分类
        foreach($category as $key => $value){
            if ($value->cate_pid == 0) {
                //一级类处理
                $cates[] = $value;
                //获取一级类下的二级类
                foreach($category as $k => $v){
                    //如果一级类的分类ID等于当前分类的父级ID
                    if($value->cate_id == $v->cate_pid){
                        //为分类名称添加缩进
                        $v->cate_name = '|----'.$v->cate_name;
                        $cates[] = $v;
                    }
                }
            }
        }
        return $cates;
    }
}
