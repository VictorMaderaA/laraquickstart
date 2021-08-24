<?php

namespace VictorMaderaA\LaraQuickStart\Transactions;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('updated_byModel')->nullable();
            $table->unsignedBigInteger('updated_id');
            $table->string('updated_model');
            $table->enum('type', [
                'created',
                'updated',
                'deleted',
            ]);
            $table->json('updated_data');
            $table->json('snapshot');
            $table->timestamps();
            $table->softDeletes();

            $table->index('id');
            $table->index('updated_by');
            $table->index('updated_byModel');
            $table->index('updated_id');
            $table->index('updated_model');
            $table->index(['updated_id','updated_model']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_transactions');
    }
}
