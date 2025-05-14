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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number')->unique();
            $table->enum('type', ['Standard', 'Deluxe', 'Suite', 'Executive Suite', 'Presidential Suite']);
            $table->integer('floor');
            $table->decimal('price_per_night', 10, 2);
            $table->integer('capacity');
            $table->text('description');
            $table->json('amenities');
            $table->enum('status', ['Available', 'Occupied', 'Maintenance', 'Cleaning'])->default('Available');
            $table->boolean('has_view')->default(false);
            $table->boolean('is_smoking')->default(false);
            
            // Room Images
            $table->string('image_url')->nullable(); // Main room image
            /* Future image fields to consider:
             * - bathroom_image_url
             * - view_image_url
             * - floor_plan_image_url
             * - living_area_image_url (for suites)
             * - dining_area_image_url (for presidential suites)
             * - Or consider a separate room_images table for multiple images
             * Example structure for room_images table:
             * - id
             * - room_id (foreign key)
             * - image_url
             * - image_type (main, bathroom, view, etc.)
             * - sort_order
             * - is_featured
             * - created_at, updated_at
             */
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
