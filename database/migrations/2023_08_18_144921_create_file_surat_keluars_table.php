<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileSuratKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_keluar_id');
            $table->string('nama_file');
            $table->string('hash_file');
            $table->string('mime_type');
            $table->string('extensi');
            $table->string('ukuran_file')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_surat_keluars');
    }
}
