<?php

use App\Enums\Status;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->tinyInteger('status')->default(Status::PUBLIC);
            $table->foreignIdFor(Category::class, "parent_id")->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        DB::table('categories')->insert([
            "name" => "Uncategorize",
            "slug" => "uncategorize",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
