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

<h2 style="text-align:center">Data Kategori</h2>
<table class="table">
    <thead>
        <tr>
            <th>NO.</th>
            <th>NAMA KATEGORI</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $number = [];
    for($i=0;$i<count($kategori);$i++){
        $number[$i] = $i+1;
    }
    for($i=0;$i<count($kategori);$i++){
        echo'<tr>
                <td>'.$number[$i].'</td>
                <td>'.$kategori[$i]->nama_kategori.'</td>
            </tr>';
    }
    ?>
    </tbody>
</table>