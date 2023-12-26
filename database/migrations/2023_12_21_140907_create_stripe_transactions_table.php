<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('stripe.table_name'), function (Blueprint $table) {
            $table->string('order_id')->primary();
            $table->string('item_name');
            $table->string('description')->nullable();
            $table->float('amount');
            $table->string('currency_code', 3);
            $table->unsignedMediumInteger('quantity')->default(1);
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('status', 30)->default(config('stripe.default_status'));
            $additionalColumns = array_merge(config('stripe.additional_input_columns'), config('stripe.response_columns'));
            foreach ($additionalColumns as $column) {
                $table->string(str_replace('.', '_', $column))->nullable();
            }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('stripe.table_name'));
    }
};
