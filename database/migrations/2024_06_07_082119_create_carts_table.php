<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up() :void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('storage_id');
            $table->foreignIdFor(\Domain\Auth\Models\User::class)->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }


    public function down() :void
        {
            if (!app()->isProduction()) {
                Schema::table('carts', function (Blueprint $table) {

                });
            }
        }
};
