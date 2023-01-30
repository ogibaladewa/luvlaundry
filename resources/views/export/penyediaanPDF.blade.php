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

<h2 style="text-align:center">Data Penyediaan</h2>
<table class="table">
    <thead>
        <tr>
            <th>NO.</th>
            <th>TANGGAL</th>
            <th>SUPPLIER</th>
            <th>CABANG</th>
            <th>PENCATAT</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $number = [];
    for($i=0;$i<count($penyediaan);$i++){
        $number[$i] = $i+1;
    }
    for($i=0;$i<count($penyediaan);$i++){
        echo'<tr>
                <td>'.$number[$i].'</td>
                <td style="text-align:center;">'.date('d-m-Y',strtotime($penyediaan[$i]->tanggal)).'</td>
                <td>'.$penyediaan[$i]->supplier->nama_supplier.'</td>
                <td>'.$penyediaan[$i]->cabang->nama_cabang.'</td>
                <td>'.$penyediaan[$i]->user->name.'</td>
            </tr>';
    }
    ?>
    </tbody>
</table>