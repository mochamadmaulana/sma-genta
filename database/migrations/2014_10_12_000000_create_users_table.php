<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('username',50);
            $table->string('nik_ktp',50)->nullable();
            $table->string('nip_pegawai',50)->nullable();
            $table->foreignId('jabatan_id');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status',['aktif','nonaktif'])->default('aktif');
            $table->enum('role',['Admin','Kepala Sekolah','User']);
            $table->string('photo_profile', 100)->nullable();
            $table->string('photo_ktp', 100)->nullable();
            $table->string('alamat')->nullable();

            $table->boolean('dark_mode')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

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
        Schema::dropIfExists('users');
    }
}
