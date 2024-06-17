<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up() :void
    {
        Schema::create('delivery_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('price')->default(0);
            $table->boolean('with_address')->default(false);
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('delivery_types')->insert(['title' => 'Самовывоз']);
        \Illuminate\Support\Facades\DB::table('delivery_types')->insert([
            'title' => 'Курьером',
            'with_address' => true
        ]);
    }


    public function down() :void
        {
            if (!app()->isProduction()) {
                Schema::table('delivery_types', function (Blueprint $table) {

                });
            }
        }
};
