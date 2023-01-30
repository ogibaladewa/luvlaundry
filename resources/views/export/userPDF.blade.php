<style>
.table {
    font-family: sans-serif;
    color: #232323;
    border-collapse: collapse;
    width:100%;
}
 
.table, th, td {
    border: 1px solid #999;
}
</style>

<h2 style="text-align:center">Data User</h2>
<table class="table">
    <thead>
        <tr>
            <th>NO.</th>
            <th>NAMA</th>
            <th>ROLE</th>
            <th>EMAIL</th>
            <th>TEMPAT LAHIR</th>
            <th>TANGGAL LAHIR</th>
            <th>JENIS KELAMIN</th>
            <th>NO. TELP</th>
            <th>ALAMAT</th>
            <th>CABANG</th>
            <th>STATUS</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $number = [];
    for($i=0;$i<count($user);$i++){
        $number[$i] = $i+1;
    }
    for($i=0;$i<count($user);$i++){
        echo'<tr>
                <td>'.$number[$i].'</td>
                <td>'.$user[$i]->name.'</td>
                <td>'.$user[$i]->role.'</td>
                <td>'.$user[$i]->email.'</td>
                <td>'.$user[$i]->tempat_lahir.'</td>
                <td>'.$user[$i]->tanggal_lahir.'</td>
                <td>'.$user[$i]->jenis_kelamin.'</td>
                <td>'.$user[$i]->no_telp.'</td>
                <td>'.$user[$i]->alamat.'</td>
                <td>'.$user[$i]->cabang->nama_cabang.'</td>
                <td>'.$user[$i]->status.'</td>
                
            </tr>';
    }
    ?>
    </tbody>
</table>