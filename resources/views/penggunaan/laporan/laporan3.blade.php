@extends('layouts.master')
@section('content')
    <div id="main-content">
        <div id="container-fluid">
            <div class="row">
            
                <div class="col-md-12">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Laporan Penggunaan</h2>
                                &nbsp;
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                        </div>
                        <div class="row" style="border-top:5px solid #f5f5fa;">
                        &nbsp;
                                <form action="/penggunaan/laporan/penggunaan3" method="GET">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label>Tahun</label>
                                            <select name="tahun" id="tahun">
                                                @foreach($data_tahun as $tahun)
                                                <option value="{{$tahun}}" <?php if($tahun_id == $tahun){echo 'selected';} ?>>{{$tahun}}</option>
                                                @endforeach
                                            </select>
                                            <label>Bulan</label>
                                            <select name="bulan" id="bulan">
                                                <?php
                                                    for($i=0;$i<12;$i++){
                                                        echo'<option value="'.$data_bulan['id_bulan'][$i].'"'; 
                                                            if($bulan_id == $data_bulan['id_bulan'][$i]){
                                                                echo ' selected >'.$data_bulan['nama_bulan'][$i].'</option>';
                                                            }
                                                            else{
                                                                echo '>'.$data_bulan['nama_bulan'][$i].'</option>';
                                                            }
                                                    }
                                                ?>
                                            </select>
                                            <label>Cabang</label>
                                            <select name="cabang" id="cabang">
                                                <option value="semua">Semua</option>
                                                @foreach($data_cabang as $cabang)
                                                <option value="{{$cabang->id}}" <?php if($cabang_id == $cabang->id){echo 'selected';} ?>>{{$cabang->nama_cabang}}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn-primary">
                                                Tampilkan
                                            </button>
                                        </div>
                                        
                                    </div>
                                </form>
                            <div class="col-md-12">
                                &nbsp;
                                <div id="chartBarangLalu"></div>
                                <button id="plain" class="btn-primary">Plain</button>
                                <button id="inverted" class="btn-primary">Inverted</button>
                            <div class="row">
                                <div class="col-md-6">
                                    
                                </div>
                                <div class="col-md-6">
                                    <button style="float:right; margin-right:5px;"  onclick="exportToExcel('exportDataPenggunaan', 'LaporanPenggunaanPerBarang{{$data_bulan['nama_bulan'][$bulan_id-1]}}{{$tahun_id}}Cabang{{$namaCabangSort}}')" class="btn btn-success"><i class="fa fa-save"></i> &nbsp;Excel</button>
                                </div> 
                            </div>
                                <table class="table" id="exportDataPenggunaan">
                                
                                <!-- <tr>
                                    <td colspan="13" style="text-align:center">
                                         Cabang : <b>{{$namaCabangSort}}</b>
                                    </td>
                                </tr> -->
                                <tr>
                                    <th colspan="2" style="text-align:center;text-transform:uppercase">JUMLAH PENGGUNAAN BULAN {{$data_bulan['nama_bulan'][$bulan_id-1]}} TAHUN {{$tahun_id}} PER-BARANG</th>
                                </tr>
                                <tr>
                                    <td>Cabang : {{$namaCabangSort}}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                </tr>
                                <?php
                                    for($i=0;$i<count($nilaiPenggunaanBarang);$i++){
                                        echo '<tr>
                                                <td>'.$namaBarang[$i].'</td>
                                            ';
                                            if($nilaiPenggunaanBarang[$i] == 0){
                                                echo'<td>-</td>';
                                            }
                                            else{

                                                echo '
                                                <td>'.$nilaiPenggunaanBarang[$i].' Pcs</td>
                                                ';
                                            }
                                        
                                        echo'</tr>';
                                    }
                                ?>
                                


                            </table> 
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('script')
<script src="{{asset('admin/assets/vendor/highcharts/highcharts.js')}}"></script>
<script src="{{asset('admin/assets/vendor/highcharts/modules/exporting.js')}}"></script>
<script src="{{asset('admin/assets/vendor/highcharts/modules/offline-exporting.js')}}"></script>
<script src="{{asset('admin/assets/vendor/highcharts/modules/export-data.js')}}"></script>
<script type="text/javascript">
function exportToExcel(tableID, filename = ''){
    var downloadurl;
    var dataFileType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTMLData = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'export_excel_data.xls';
    
    // Create download link element
    downloadurl = document.createElement("a");
    
    document.body.appendChild(downloadurl);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTMLData], {
            type: dataFileType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadurl.href = 'data:' + dataFileType + ', ' + tableHTMLData;
    
        // Setting the file name
        downloadurl.download = filename;
        
        //triggering the function
        downloadurl.click();
    }
}
 
</script>
<!-- <script src="https://code.highcharts.com/highcharts.js"></script> -->
<script>

    var chart = Highcharts.chart('chartBarangLalu', {

    title: {
        text: 'Jumlah Penggunaan per-Barang Bulan {{$data_bulan['nama_bulan'][$bulan_id-1]}} Tahun {{$tahun_id}} '
    },

    subtitle: {
        text: 'Perbandingan Penggunaan Yang Dilakukan pada Bulan Lalu Untuk Masing-Masing Barang pada Cabang : <b>{{$namaCabangSort}}</b>'
    },

    xAxis: {
        categories: {!!json_encode($namaBarang)!!},
    },

    series: [{
        type: 'column',
        colorByPoint: true,
        data: {!!json_encode($nilaiPenggunaanBarang)!!},
        showInLegend: false
    }]

    });


    $('#plain').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: false
        },
        subtitle: {
            text: 'Plain'
        }
    });
    });

    $('#inverted').click(function () {
    chart.update({
        chart: {
            inverted: true,
            polar: false
        },
        subtitle: {
            text: 'Inverted'
        }
    });
    });

    $('#polar').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: true
        },
        subtitle: {
            text: 'Polar'
        }
    });
    });
</script>
@stop