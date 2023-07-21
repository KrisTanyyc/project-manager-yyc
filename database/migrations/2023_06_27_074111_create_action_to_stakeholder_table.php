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
        Schema::create('action_to_stakeholder', function (Blueprint $table) {
            $table->unsignedBigInteger('action_id');
            $table->unsignedBigInteger('stakeholder_id');
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
            $table->foreign('stakeholder_id')->references('id')->on('stakeholders')->onDelete('cascade');
            $table->primary(['action_id', 'stakeholder_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('action_to_stakeholder');
    }
};
