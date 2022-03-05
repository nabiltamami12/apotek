printer
.align('center')
.underline('false')
.bold(true)
.text('APOTEK AL-RAZAAK')
.text('BANYUWANGI - JAWA TIMUR')
.bold(false)
.feed(1)
.align('left')
.text('Tanggal : <?= $penjualan->tgl->format('d/m/y H:i:s') ?>')
.text('Nota    : <?= $penjualan->kode ?>')
.text('Kasir   : <?= $penjualan->user->fullname ?>')
.text('================================')
<?php foreach ($penjualan->penjualandetail as $key => $value) : ?>
.text("<?= $value->barang->nama ?>")
.text("<?php echo number_format($value->jumlah,0,".","."); echo " "; echo $value->barang->satuan;   echo "       ";    echo number_format($value->harga_jual,0,".",".");  echo "      ";    echo number_format($value->harga_jual*$value->jumlah,0,".","."); ?>")
<?php endforeach; ?>
.text("--------------------------------")
.text("Total   : <?php echo "         Rp."; echo number_format($penjualan->total(),0,".","."); ?>")
.text("Bayar   : <?php echo "         Rp."; echo number_format($penjualan->bayar,0,".",".");?>")
.text("Kembali : <?php echo "         Rp."; echo number_format($penjualan->bayar-$penjualan->total(),0,".","."); ?>")
.text("--------------------------------")
<?php if($penjualan->catatan != null) :?>
.text("Catatan : ")
.text("<?=$penjualan->catatan?>")
.text("--------------------------------")
<?php endif; ?>
<?php if ($penjualan->member != null) :?>
.text("========== DATA MEMBER =========")
.text("Member : <?=$penjualan->member->kode?>")
.text("Nama   : <?=$penjualan->member->nama?>")
.text("--------------------------------")
<?php endif; ?>
.align('center')
.text('Terima Kasih Telah Berbelanja')
.text('Di APOTEK AL-RAZAAK')
.text('APOTEK AL-RAZAAK')
.text('081252899024')
.feed(1)
.text('** Barang Yang Sudah Dibeli **')
.text('** Tidak Dapat Dikembalikan **')
.feed(1)
.text('======= TERIMA KASIH =======')
.cut()
.print()

