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
        Schema::create('prescriptions', function (Blueprint $table) {
           $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->date('date');

            // Sphere
            $table->decimal('sph_od', 4, 2);
            $table->decimal('sph_os', 4, 2);

            // Cylinder
            $table->decimal('cyl_od', 4, 2)->default(0);
            $table->decimal('cyl_os', 4, 2)->default(0);

            // Axis (0 if no cylinder)
            $table->unsignedSmallInteger('axis_od')->default(0);
            $table->unsignedSmallInteger('axis_os')->default(0);

            // ADD
            $table->decimal('add_od', 4, 2)->nullable();
            $table->decimal('add_os', 4, 2)->nullable();

            // PD (single value)
            $table->decimal('pd', 5, 2);

            // Lens Type
            $table->enum('type', [
                'Single Vision',
                'Bifocal',
                'Progressive',
                'Reading',
                'Computer',
                'Contact Lens'
            ]);

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
