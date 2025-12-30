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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->string('nama_penerima');
            $table->string('no_hp');
            $table->enum('metode_pembayaran', ['transfer_bank', 'cod', 'qris']);
            $table->string('catatan_pembeli')->nullable();
            $table->integer('jumlah');
            $table->decimal('total', 12, 2);
            $table->enum('status', ['pending_payment', 'dibayar', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('pending_payment');
            $table->text('alamat');
            $table->string('ekspedisi');
            $table->decimal('ongkir', 12, 2)->default(0);
            $table->string('resi')->nullable();
            $table->string('snap_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
