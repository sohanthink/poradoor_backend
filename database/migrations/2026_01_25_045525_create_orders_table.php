<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\ShippingMethod;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('guest_id')->nullable()->unique();
            $table->foreignIdFor(User::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Address::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Coupon::class)->nullable()->constrained()->nullOnDelete();
            $table->tinyInteger('payment_status')->default(PaymentStatus::UNPAID->value);
            $table->tinyInteger('order_status')->default(OrderStatus::PENDING->value);
            $table->tinyInteger('payment_method')->default(PaymentMethod::CASH_ON_DELIVARY->value);
            $table->tinyInteger('shipping_method')->default(ShippingMethod::STANDARD->value);
            $table->decimal('total_amount')->nullable();
            $table->decimal('subtotal_amount')->nullable();
            $table->decimal('discount_amount')->nullable();
            $table->decimal('shipping_charge')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
