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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('transaction_number');
            $table->enum('title', ["пополнение", "перевод"]);
            $table->integer('sum')->default(0);
            $table->unsignedBigInteger("sender_id")->nullable();
            $table->unsignedBigInteger("receiver_id");
            $table->timestamps();

            $table->foreign("sender_id")
                ->references("id")
                ->on("users")
                ->onUpdate("cascade")
                ->onDelete("set null");

            $table->foreign("receiver_id")
                ->references("id")
                ->on("users")
                ->onUpdate("cascade")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
