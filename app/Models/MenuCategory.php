<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    //过滤，只有这里的才能修改
    protected $fillable = [
        'name',
        'type_accumulation',
        'shop_id',
        'description',
        'is_selected',
    ];
//建立和商家店铺的关系 一对多（反向）   一（多）对一   articles.author_id ---> students.id
    public function getShops()
    {
        return $this->belongsTo(Shop::class,'shop_id','id');
    }

}
