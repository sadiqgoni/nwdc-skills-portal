<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table): void {
            $table->unique(['user_id', 'programme_cycle_id'], 'applications_user_cycle_unique');
        });

        Schema::create('application_notifications', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->string('channel');
            $table->string('recipient');
            $table->string('subject')->nullable();
            $table->text('body');
            $table->string('status')->default('queued');
            $table->text('provider_response')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['application_id', 'channel']);
            $table->index(['channel', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_notifications');

        Schema::table('applications', function (Blueprint $table): void {
            $table->dropUnique('applications_user_cycle_unique');
        });
    }
};
