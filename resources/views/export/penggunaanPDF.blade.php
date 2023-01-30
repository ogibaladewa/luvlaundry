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

<h2 style="text-align:center">Data Penggunaan</h2>
<table class="table">
    <thead>
        <tr>
            <th>NO.</th>
            <th>TANGGAL</th>
            <th>BARANG</th>
            <th>TERPAKAI</th>
            <th>CABANG</th>
            <th>PENCATAT</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $number = [];
    for($i=0;$i<count($penggunaan);$i++){
        $number[$i] = $i+1;
    }
    for($i=0;$i<count($penggunaan);$i++){
        echo'<tr>
                <td>'.$number[$i].'</td>
                <td style="text-align:center;">'.$penggunaan[$i]->tanggal.'</td>
                <td>'.$penggunaan[$i]->barang->nama_barang.'</td>
                <td style="text-align:right;">'.$penggunaan[$i]->terpakai.'</td>
                <td>'.$penggunaan[$i]->cabang->nama_cabang.'</td>
                <td>'.$penggunaan[$i]->user->name.'</td>
            </tr>';
    }
    ?>
    </tbody>
</table>