<?php

use App\Models\Order;
use App\Models\User;
use App\Enums\AddressType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(AddressType::USER_SAVED->value);
            $table->foreignIdFor(User::class)->nullable()->nullable()->cascadeOnDelete();
            $table->foreignIdFor(Order::class)->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('city');
            $table->text('address');
            $table->string('delivary_area')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->text('additional_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_addresses');
    }
};
