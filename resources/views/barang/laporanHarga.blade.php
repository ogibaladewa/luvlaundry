@extends('layouts.master')
@section('content')
    <div id="main-content">
        <div id="container-fluid">
            <div class="row">
            
                <div class="col-md-12">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Laporan Perubahan Harga</h2>
                                &nbsp;
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                        </div>
                        <div class="row" style="border-top:5px solid #f5f5fa;">
                        &nbsp;
                                <form action="/barang/laporanHarga" method="GET">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label>Tahun</label>
                                            <select name="tahun" id="tahun">
                                                @foreach($data_tahun as $tahun)
                                                <option value="{{$tahun}}" <?php if($tahun_id == $tahun){echo 'selected';} ?>>{{$tahun}}</option>
                                                @endforeach
                                            </select>
                                            <label>Supplier</label>
                                            <select name="supplier" id="supplier">
                                                @foreach($data_supplier as $supplier)
                                                <option value="{{$supplier->id}}" <?php if($supplier_id == $supplier->id){echo 'selected';} ?>>{{$supplier->nama_supplier}}</option>
                                                @endforeach
                                            </select>
                                            <label>Kategori</label>
                                            <select name="kategori" id="kategori">
                                                @foreach($data_kategori as $kategori)
                                                <option value="{{$kategori->id}}" <?php if($kategori_id == $kategori->id){echo 'selected';} ?>>{{$kategori->nama_kategori}}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn-primary">
                                                Tampilkan
                                            </button>
                                        </div>
                                        
                                    </div>
                                </form>
                            <div class="col-md-12">
                                <div id="chartPenggunaanBarangLine"></div>
                            </div> 
                            <div class="row">
                                <div class="col-md-6">
                                    
                                </div>
                                <div class="col-md-6">
                                    <button style="float:right; margin-right:5px;"  onclick="exportToExcel('exportDataHarga', 'LaporanPerubahanHarga_{{$tahun_id}}Kategori{{$namaKategoriSort}}Supplier{{$namaSupplierSort}}')" class="btn btn-success"><i class="fa fa-save"></i> &nbsp;Excel</button>
                                </div> 
                            </div>
                            <table class="table" id="exportDataHarga">
                                
                                <!-- <tr>
                                    <td colspan="13" style="text-align:center">
                                         Supplier : <b>{{$namaSupplierSort}}</b>, Kategori : <b>{{$namaKategoriSort}}</b>
                                    </td>
                                </tr> -->
                                <tr>
                                    <th colspan="13" style="text-align:center;text-transform:uppercase">PERUBAHAN HARGA RATA-RATA TAHUN {{$tahun_id}}</th>
                                </tr>
                                <tr>
                                    <td>Kategori : {{$namaKategoriSort}}</td>
                                    <td colspan="12"></td>
                                </tr>
                                <tr>
                                    <td>Supplier : {{$namaSupplierSort}}</td>
                                    <td colspan="12"></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Jan</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>Mei</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Ags</th>
                                    <th>Sep</th>
                                    <th>Okt</th>
                                    <th>Nov</th>
                                    <th>Des</th>
                                </tr>
                                <?php
                                    for($i=0;$i<count($nilaiHargaKat);$i++){
                                        echo '<tr>
                                                <td>'.$nilaiHargaKat[$i]['nama_barang'].'</td>
                                            ';
                                        for($j=0;$j<12;$j++){
                                            if($nilaiHargaKat[$i]['nilai'][$j] == 0){
                                                echo'<td>Rp.-</td>';
                                            }
                                            else{

                                                echo '
                                                <td>Rp.'.number_format((int)$nilaiHargaKat[$i]['nilai'][$j],0,',','.').'</td>
                                                ';
                                            }
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
Highcharts.chart('chartPenggunaanBarangLine', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Perubahan Harga Rata-rata Tahun {{$tahun_id}}'
    },
    subtitle: {
        text: 'Perubahan Harga Rata Rata Barang tiap Bulan di Kategori : <b>{{$namaKategoriSort}}</b> pada Supplier : <b>{{$namaSupplierSort}}</b>'
    },
    xAxis: [{
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: 'Rp.{value}',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Total Penggunaan',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        }
    }, { // Secondary yAxis
        title: {
            text: '',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        labels: {
            format: 'Rp.{value}',
            style: {
                color: Highcharts.getOptions().colors[0]
            }
        },
        opposite: true
    }],
    tooltip: {
        shared: true
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        x: 120,
        verticalAlign: 'top',
        y: 100,
        floating: true,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || // theme
            'rgba(255,255,255,0.25)'
    },
    series: [
        
        @foreach($nilaiHargaKat as $nilai)    
        {
                    name: '{!!json_encode($nilai['nama_barang'])!!}',
                    type: 'spline',
                    data: {!!json_encode($nilai['nilai'])!!},
                    tooltip: {
                    valueSuffix: ' rupiah'
                    }
        }, 
        @endforeach
    ]
    
});

</script>
@stop