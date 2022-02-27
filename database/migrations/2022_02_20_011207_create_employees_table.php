<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('employee_id');
            $table->unsignedInteger('group_id')->comment('Group');
            $table->string('employee_code', 25);
            $table->string('employee_first_name', 50);
            $table->string('employee_last_name', 50)->nullable()->default(null);
            $table->date('employee_birth_date')->nullable()->default(null);
            $table->string('employee_email_private', 50)->nullable()->default(null);
            $table->double('employee_basic_salary')->nullable()->default(null);
            $table->string('employee_description', 255)->nullable()->default(null);

            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);

            $table->foreign('group_id')->references('group_id')->on('groups')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
