<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_NEW = 1;
    const STATUS_SHIPPING = 2;
    const STATUS_DELIVERED = 3;
    protected $fillable = ['total', 'status','user_id'];

    public function orderItems (){
        return $this->hasMany(OrderItem::class);
    }
}
