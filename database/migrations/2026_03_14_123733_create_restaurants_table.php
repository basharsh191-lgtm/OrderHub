<?php

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
        Schema::create('restaurants', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('owner_id')->nullable()->index();
    $table->string('name');
    $table->string('slug')->unique(); // اسم في الرابط
    $table->string('logo')->nullable();
    $table->string('cover_image')->nullable();
    $table->text('description')->nullable();
    $table->string('phone')->nullable();
    $table->string('address')->nullable();
    $table->double('latitude')->nullable(); // احداثي للموقع (خرائط)
    $table->double('longitude')->nullable(); // احداثي للموقع
    $table->boolean('is_active')->default(true);
    $table->time('opens_at')->nullable();
    $table->time('closes_at')->nullable();
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
