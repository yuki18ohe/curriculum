<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id'); // 商品ID
            $table->integer('user_id'); // ユーザーID
            $table->string('name', 255); // 商品名
            $table->integer('weight'); // 重量
            $table->string('image')->nullable(); // 画像
            $table->timestamps(); // 登録日時、更新日時
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
