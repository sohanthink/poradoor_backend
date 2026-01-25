<?php

use App\Enums\Status;
use App\Models\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('small_desc',512);
            $table->decimal('price');
            $table->decimal('regular_price')->nullable();
            $table->text('desc');
            $table->text('atributes')->nullable();
            $table->integer('quantity');
            $table->integer('alert_quantity');
            $table->tinyInteger('status')->default(Status::PUBLIC);
            $table->foreignIdFor(Category::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
