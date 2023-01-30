<style>
.table {
    font-family: sans-serif;
    color: #232323;
    border-collapse: collapse;
    width:100%;
}
 
.table, th, td {
    border: 1px solid #999;
    padding: 8px 20px;
}
</style>

<h2 style="text-align:center">Data Laporan Harga Barang</h2>
<table class="table">
    <thead>
        <tr>
            <th>NO.</th>
            <th>KODE BARANG</th>
            <th>NAMA BARANG</th>
            <th>SATUAN</th>
            <th>KATEGORI</th>
            <th>STATUS</th>
            <th>DESKRIPSI</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $number = [];
    for($i=0;$i<count($barang);$i++){
        $number[$i] = $i+1;
    }
    for($i=0;$i<count($barang);$i++){
        echo'<tr>
                <td>'.$number[$i].'</td>
                <td>'.$barang[$i]->kode_barang.'</td>
                <td>'.$barang[$i]->nama_barang.'</td>
                <td>'.$barang[$i]->satuan.'</td>
                <td>'.$barang[$i]->kategori->nama_kategori.'</td>
                <td>'.$barang[$i]->status.'</td>
                <td>'.$barang[$i]->deskripsi.'</td>
            </tr>';
    }
    ?>
    </tbody>
</table>