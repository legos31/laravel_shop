<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up() :void
    {
        Schema::create('option_values', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Domain\Product\Models\Option::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('option_value_product', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Domain\Product\Models\Product::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(\Domain\Product\Models\OptionValue::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });
    }


    public function down() :void
        {
            if (!app()->isProduction()) {
                Schema::table('option_values', function (Blueprint $table) {

                });
            }
        }
};
