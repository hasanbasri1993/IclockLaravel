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
        Schema::create('template_fingers', function (Blueprint $table) {
            $table->increments('templateid');
            $table->integer('userid')->unsigned();
            $table->longText('Template');
            $table->smallInteger('FingerID');
            $table->smallInteger('Valid');
            $table->smallInteger('DelTag');
            $table->string('SN', 20)->nullable();
            $table->dateTime('UTime')->nullable();
            $table->longText('BITMAPPICTURE')->nullable();
            $table->longText('BITMAPPICTURE2')->nullable();
            $table->longText('BITMAPPICTURE3')->nullable();
            $table->longText('BITMAPPICTURE4')->nullable();
            $table->smallInteger('USETYPE')->nullable();
            $table->longText('Template2')->nullable();
            $table->longText('Template3')->nullable();
            $table->unique(['userid', 'FingerID']);
            $table->index('userid');
            $table->index('SN');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_fingers');
    }
};
