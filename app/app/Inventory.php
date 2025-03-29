<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventorys'; // 👈 テーブル名を明示的に指定
    protected $fillable = ['product_id', 'quantity','user_id','expected_date','weight','confirmed_flag',];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}
}
