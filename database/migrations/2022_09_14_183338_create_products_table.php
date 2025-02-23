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
            $table-> id();

            $table-> string('title')->index();
            $table-> foreignId('view');

            $table-> string('slug')->unique();

            $table-> longText('description');

            $table-> unsignedTinyInteger('status')->default(0);

            $table-> string('product_type')->default('product');

            $table-> unsignedTinyInteger('comment_able')->default(1);

            $table-> foreignId('user_id')->constrained()->onDelete('cascade');

            $table-> foreignId('category_id')->constrained()->onDelete('cascade');
            
            $table-> timestamps();
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