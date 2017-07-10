<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //category数据库
    protected $table = 'category';
    protected $primaryKey = 'cate_id';
    public $timestamps = false;
    protected $guarded = [];

    //从控制器中已过来的2个方法，放在model处理数据在返回controller比较合适所以已过来啦，
    public function tree()
    {
        $category = $this->orderby('cate_order', 'asc')->get();
        //dd($category);
        $data = $this->getTree($category, 'cate_name', 'cate_id', 'cate_pid', 0);
        return $data;
    }

    //重组分类，实现父分类下跟子分类
    public function getTree($data, $file_name, $field_id='id', $field_pid='pid', $pid=0)
    {
        $arr = array();
        foreach($data as $k=>$v){
            if($v->$field_pid==$pid){
                $data[$k]['_'.$file_name] = $data[$k][$file_name];
                $arr[] = $data[$k];
            }
            foreach($data as $m=>$n){
                if($v->$field_id==$n->$field_pid){
                    $data[$m]['_'.$file_name] = '|-- '.$data[$m][$file_name];
                    $arr[] = $data[$m];
                }
            }
        }
        return $arr;
    }


}
