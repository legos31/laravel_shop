<?php

use Domain\Order\Models\DeliveryType;
use Domain\Order\Models\PaymentMethod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up() :void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status', array_column(\Domain\Order\Enums\OrderStatuses::cases(), 'value'))->default('new');
            $table->foreignIdFor(model: \Domain\Auth\Models\User::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(DeliveryType::class)->constrained();
            $table->foreignIdFor(PaymentMethod::class)->constrained();
            $table->unsignedInteger('amount')->default(0);
            $table->timestamps();
        });
    }


    public function down() :void
        {
            if (!app()->isProduction()) {
                Schema::table('orders', function (Blueprint $table) {

                });
            }
        }
};
