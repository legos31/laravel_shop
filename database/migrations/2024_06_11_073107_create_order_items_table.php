<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up() :void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Domain\Order\Models\Order::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\Domain\Product\Models\Product::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedInteger('price');
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });

        Schema::create('order_item_option_value', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Domain\Order\Models\OrderItem::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\Domain\Product\Models\OptionValue::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedInteger('price');
            $table->unsignedInteger('quantity');
            $table->timestamps();
        });
    }


    public function down() :void
        {
            if (!app()->isProduction()) {
                Schema::table('order_items', function (Blueprint $table) {

                });
            }
        }
};
