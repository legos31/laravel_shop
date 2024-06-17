<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up() :void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Domain\Cart\Models\Cart::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\Domain\Product\Models\Product::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('price');
            $table->integer('quantity');
            $table->string('string_option_values')->nullable();
            $table->timestamps();
        });

        Schema::create('cart_item_option_value', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Domain\Cart\Models\CartItem::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\Domain\Product\Models\OptionValue::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
        });


    }


    public function down() :void
        {
            if (!app()->isProduction()) {
                Schema::table('cart_items', function (Blueprint $table) {

                });
                Schema::table('cart_item_option_values', function (Blueprint $table) {

                });
            }
        }
};
