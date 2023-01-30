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

<h2 style="text-align:center">Data Supplier</h2>
<table class="table">
    <thead>
        <tr>
            <th>NO.</th>
            <th>NAMA SUPPLIER</th>
            <th>NO. TELP</th>
            <th>EMAIL</th>
            <th>ALAMAT</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $number = [];
    for($i=0;$i<count($supplier);$i++){
        $number[$i] = $i+1;
    }
    for($i=0;$i<count($supplier);$i++){
        echo'<tr>
                <td>'.$number[$i].'</td>
                <td>'.$supplier[$i]->nama_supplier.'</td>
                <td>'.$supplier[$i]->no_telp.'</td>
                <td>'.$supplier[$i]->email.'</td>   
                <td>'.$supplier[$i]->alamat.'</td>
                <td>'.$supplier[$i]->status.'</td>
                
            </tr>';
    }
    ?>
    </tbody>
</table>