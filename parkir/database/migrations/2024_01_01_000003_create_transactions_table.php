git push -u origin main
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parkir_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_lokasi');
            $table->string('no_tiket', 255)->unique();
            $table->string('no_polisi', 15)->nullable();
            $table->unsignedBigInteger('id_jenis');
            $table->dateTime('masuk');
            $table->dateTime('keluar')->nullable();
            $table->integer('perjam_pertama')->nullable();
            $table->integer('perjam_berikutnya')->nullable();
            $table->integer('max_perhari')->nullable();
            $table->integer('total_jam')->nullable();
            $table->integer('total_bayar')->nullable();
            $table->timestamps();

            $table->foreign('id_lokasi')->references('id')->on('parkir_locations');
            $table->foreign('id_jenis')->references('id')->on('parkir_vehicle__types');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parkir_transactions');
    }
};
