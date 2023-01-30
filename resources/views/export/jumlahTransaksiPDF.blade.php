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

<h2 style="text-align:center">Data Jumlah Transaksi</h2>
<table class="table">
    <thead>
        <tr>
            <th>NO.</th>
            <th>PERIODE</th>
            <th>JUMLAH</th>
            <th>TOTAL BERAT(kg)</th>
            <th>CABANG</th>
            <th>PENCATAT</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $number = [];
    for($i=0;$i<count($jumlahTransaksi);$i++){
        $number[$i] = $i+1;
    }
    for($i=0;$i<count($jumlahTransaksi);$i++){
        echo'<tr>
                <td>'.$number[$i].'</td>
                <td style="text-align:center;">'.date('d-m-Y',strtotime($jumlahTransaksi[$i]->periode)).'</td>
                <td style="text-align:right;">'.$jumlahTransaksi[$i]->jumlah.'</td>
                <td style="text-align:right;">'.$jumlahTransaksi[$i]->total_berat.'</td>
                <td>'.$jumlahTransaksi[$i]->cabang->nama_cabang.'</td>
                <td>'.$jumlahTransaksi[$i]->user->name.'</td>
            </tr>';
    }
    ?>
    </tbody>
</table>