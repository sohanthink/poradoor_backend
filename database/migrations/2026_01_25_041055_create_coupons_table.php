<?php

use App\Enums\CouponType;
use App\Enums\Status;
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
            $table->integer('usage')->default(0);
            $table->integer('value');
            $table->dateTime('vaild_till')->nullable();
            $table->boolean('status')->default(Status::PUBLIC);
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
