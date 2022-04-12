<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\InvoiceStatus;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->integer('year');
            $table->integer('number');
            $table->string('number_mark', 10)->nullable();
            $table->date('date_of_traffic');
            $table->date('payment_deadline');
            $table->decimal('total', 12, 2);
            $table->tinyInteger('payment_status')->default(InvoiceStatus::UNPAID);
            $table->date('payment_date')->nullable();
            $table->string('customer_name', 200)->nullable();
            $table->string('customer_pib', 50)->nullable();
            $table->string('customer_mb', 50)->nullable();
            $table->string('customer_address', 500)->nullable();
            $table->string('customer_city', 200)->nullable();
            $table->timestamps();

            $table
                ->foreign('customer_id')
                ->references('id')
                ->on('customers');

            $table->unique(['year', 'number', 'customer_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
