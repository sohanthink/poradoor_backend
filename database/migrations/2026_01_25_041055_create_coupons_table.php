<?php

use App\Enums\CouponType;
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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->default(CouponType::PERCENTAGE->value);
            $table->string('coupon',50);
            $table->integer('limit');
            $table->integer('usage');
            $table->integer('value');
            $table->text('product_ids')->nullable();
            $table->text('except_ids')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
