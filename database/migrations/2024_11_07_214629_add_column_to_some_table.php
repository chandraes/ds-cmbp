<?php

use App\Models\InvoiceTagihan;
use App\Models\Pajak\PphPerusahaan;
use App\Models\Pajak\PpnKeluaran;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->boolean('keranjang')->default(0)->after('csr');
        });

        Schema::table('invoice_tagihans', function (Blueprint $table) {
            $table->bigInteger('total_awal')->default(0)->after('customer_id');
            $table->bigInteger('penyesuaian')->default(0)->after('total_awal');
            $table->bigInteger('penalty')->default(0)->after('penyesuaian');
            $table->bigInteger('ppn')->default(0)->after('penalty');
            $table->bigInteger('pph')->default(0)->after('ppn');
            $table->date('tanggal_hardcopy')->nullable()->after('sisa_tagihan');
            $table->date('estimasi_pembayaran')->nullable()->after('tanggal_hardcopy');
            $table->string('no_resi')->nullable()->after('estimasi_pembayaran');
            $table->string('no_validasi')->nullable()->after('no_resi');
            $table->boolean('ppn_dipungut')->default(1)->after('ppn');
        });

        $data = InvoiceTagihan::all();

        foreach ($data as $invoice) {
            $ppn = PpnKeluaran::where('invoice_tagihan_id', $invoice->id)->first();
            $pph = PphPerusahaan::where('invoice_tagihan_id', $invoice->id)->first();
            $nilai_ppn = $ppn ? $ppn->nominal : 0;
            $nilai_pph = $pph ? $pph->nominal : 0;
            $invoice->ppn = $ppn ? $ppn->nominal : 0;
            $invoice->pph = $pph ? $pph->nominal : 0;
            $invoice->total_awal = $invoice->total_tagihan - $nilai_ppn + $nilai_pph;
            $invoice->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('keranjang');
        });

        Schema::table('invoice_tagihans', function (Blueprint $table) {
            $table->dropColumn('total_awal');
            $table->dropColumn('ppn');
            $table->dropColumn('ppn_dipungut');
            $table->dropColumn('pph');
            $table->dropColumn('penyesuaian');
            $table->dropColumn('penalty');
            $table->dropColumn('tanggal_hardcopy');
            $table->dropColumn('estimasi_pembayaran');
            $table->dropColumn('no_resi');
            $table->dropColumn('no_validasi');
        });
    }
};
