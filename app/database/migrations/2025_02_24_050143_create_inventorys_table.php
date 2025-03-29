<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventorys', function (Blueprint $table) {
            $table->bigIncrements('id'); // 在庫ID
            $table->integer('product_id'); // 商品ID
            $table->integer('user_id'); // ユーザーID
            $table->integer('quantity'); // 数量
            $table->integer('weight'); // 重量
            $table->date('expected_date'); // 入荷予定日
            $table->boolean('confirmed_flag')->default(false); // 確定フラグ
            $table->timestamps(); // 登録日時、更新日時
            $table->softDeletes();
            $table->unsignedBigInteger('user_id')->after('product_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventorys');
    }
}
