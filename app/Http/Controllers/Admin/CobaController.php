<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use App\Models\Penjualan;
use App\Models\Utility;

class CobaController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function cobaStruk() {
    	$penjualan = Penjualan::orderBy('id', 'desc')->first();

    	Utility::printStruk($penjualan->kode);

  //   	$connector = new FilePrintConnector("/dev/usb/lp0");
		// $printer = new Printer($connector);
		// $printer->initialize();

		// $printer->text("PHONESHOPE\n");
		// $printer->text($penjualan->tgl->format('d/m/y H:i:s')."\n");
		// $printer->text("Nota: ".$penjualan->kode." ".($penjualan->member != null ? ", Member: ".$penjualan->member->kode."  -  ".$penjualan->member->nama : "")."\n");
		// $printer->text("Kasir: ".$penjualan->user->fullname."\n");
		// $printer->text("========================================\n");
		// $printer -> feed(1);

		// foreach ($penjualan->penjualandetail as $key => $value) {
		// 	$printer->text($value->jumlah."  ".$value->barang->nama."  ".Utility::tambahSpasi(number_format($value->harga_jual, 0, '.', ','), 11) ."  ".Utility::tambahSpasi(number_format($value->harga_jual*$value->jumlah, 0, '.', ','), 11)."\n");
		// }

		// $printer->text("\nTotal : ".Utility::tambahSpasi(number_format($penjualan->total(), 0, '.', ','), 31)."\n");

		// $printer -> feed(2);
		// $printer->text("Terima Kasih Membeli PhoneShope\n");

		// $printer -> cut();
		// $printer -> close();
    	
  //       return response('Selesai Coba Struk. Penjualan : '. $penjualan->kode, 200)->header('Content-Type', 'text/plain');
        
    }

  //   public function cobaStruk() {
  //   	$connector = new FilePrintConnector("/dev/usb/lp0");
		// $printer = new Printer($connector);
		// $printer->initialize();

		// // $strprint = "PT. BANK RAKYAT INDONESIA (PERSERO)\n".date('d/m/y').' '.date('h:i:s')."\nANU ABC\n";
		
		// // $printer -> text($strprint);
		// // $printer -> feed();
		// // $printer -> text("=====================\nTERIMA KASIH SUDAH BERKUNJUNG\n");
		// // 40 rows
		// $printer->text("========================================\n");
		// $printer -> cut();
		// $printer -> close();
    	
  //       return response('Selesai Coba Struk', 200)->header('Content-Type', 'text/plain');
        
  //   }
}
