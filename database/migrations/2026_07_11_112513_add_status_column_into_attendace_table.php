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
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('schedule_id')->after('student_id')->constrained()->cascadeOnDelete();
            $table->date('date')->nullable()->change();
            $table->time('time_in')->nullable()->change();
            $table->enum('status',['pending','present','permission','sick','absent'])->default('pending')->after('date');
            $table->index('date');
            $table->unique(['schedule_id','student_id','date']);
            $table->index([
                'student_id',
                'date'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            //
        });
    }
};
