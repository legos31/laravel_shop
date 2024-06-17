<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up() :void
    {
        Schema::create('payment_history', function (Blueprint $table) {
            $table->id();
            $table->string('payment_gateway');
            $table->string('method')->nullable();
            $table->json('payload');
            $table->timestamps();
        });
    }


    public function down() :void
        {
            if (!app()->isProduction()) {
                Schema::table('payment_history', function (Blueprint $table) {

                });
            }
        }
};
