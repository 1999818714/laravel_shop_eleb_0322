<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //过滤，只有这里的才能修改
    protected $fillable = [
        'goods_name',
        'rating',
        'shop_id',
        'category_id',
        'goods_price',
        'description',
        'month_sales',
        'rating_count',
        'tips',
        'satisfy_count',
        'satisfy_rate',
        'goods_img',
        'status',
    ];

    //建立和商家店铺的关系 一对多（反向）   一（多）对一   articles.author_id ---> students.id
    public function getShops()
    {
        return $this->belongsTo(Shop::class,'shop_id','id');
    }

    //建立和菜品分类的关系 一对多（反向）   一（多）对一   articles.author_id ---> students.id
    public function getMenuCategory()
    {
        return $this->belongsTo(MenuCategory::class,'category_id','id');
    }


}
