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

<h2 style="text-align:center">Data Cabang</h2>
<table class="table">
    <thead>
        <tr>
            <th>NO.</th>
            <th>NAMA CABANG</th>
            <th>NO. TELP</th>
            <th>ALAMAT</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $number = [];
    for($i=0;$i<count($cabang);$i++){
        $number[$i] = $i+1;
    }
    for($i=0;$i<count($cabang);$i++){
        echo'<tr>
                <td>'.$number[$i].'</td>
                <td>'.$cabang[$i]->nama_cabang.'</td>
                <td>'.$cabang[$i]->no_telp.'</td>
                <td>'.$cabang[$i]->alamat.'</td>
                <td>'.$cabang[$i]->status.'</td>
            </tr>';
    }
    ?>
    </tbody>
</table>