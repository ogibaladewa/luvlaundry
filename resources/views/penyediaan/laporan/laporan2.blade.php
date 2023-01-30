@extends('layouts.master')
@section('content')
    <div id="main-content">
        <div id="container-fluid">
            <div class="row">
            
                <div class="col-md-12">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Laporan Penyediaan</h2>
                                &nbsp;
                            </div>
                        
                           
                            <div class="col-md-6">
                                
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-12">
                                <div id="chartTotalPenyediaan"></div>
                            </div>   
                        </div> -->
                        <div class="row" style="border-top:5px solid #f5f5fa;">
                            &nbsp;
                                <form action="/penyediaan/laporan/penyediaan2" method="GET">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label>Tahun</label>
                                            <select name="tahun" id="tahun">
                                                @foreach($data_tahun as $tahun)
                                                <option value="{{$tahun}}" <?php if($tahun_id == $tahun){echo 'selected';} ?>>{{$tahun}}</option>
                                                @endforeach
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
                                <div id="chartPenyediaanKatBulanan"></div>
                            </div> 
                            <div class="row">
                                <div class="col-md-6">
                                    
                                </div>
                                <div class="col-md-6">
                                    <button style="float:right; margin-right:5px;"  onclick="exportToExcel('exportDataPenyediaan', 'LaporanPenyediaanPerKategoriTahun_{{$tahun_id}}')" class="btn btn-success"><i class="fa fa-save"></i> &nbsp;Excel</button>
                                </div> 
                            </div>  
                            <table class="table" id="exportDataPenyediaan">
                                
                                <!-- <tr>
                                    <td colspan="13" style="text-align:center">
                                         Cabang : <b>{{$namaCabangSort}}</b>
                                    </td>
                                </tr> -->
                                <tr>
                                    <th colspan="13" style="text-align:center;text-transform:uppercase">TOTAL PENYEDIAAN PER-KATEGORI TAHUN {{$tahun_id}}</th>
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
                                    for($i=0;$i<count($nilaiPenyediaanKatA);$i++){
                                        echo '<tr>
                                                <td>'.$nilaiPenyediaanKatA[$i]['nama_kategori'].'</td>
                                            ';
                                        for($j=0;$j<12;$j++){
                                            if($nilaiPenyediaanKatA[$i]['nilai'][$j] == 0){
                                                echo'<td>-</td>';
                                            }
                                            else{

                                                echo '
                                                <td>'.$nilaiPenyediaanKatA[$i]['nilai'][$j].' Pcs</td>
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
    

    Highcharts.chart('chartPenyediaanKatBulanan', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Total Penyediaan per-Kategori Tahun {{$tahun_id}}'
        },
        subtitle: {
            text: 'Total Jumlah Penyediaan per-Kategori Barang pada Cabang : <b>{{$namaCabangSort}}</b>'
        },
        xAxis: {
            categories: [ 'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Penyediaan'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} pcs</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
        @foreach($nilaiPenyediaanKatA as $nilai)    
        {
                    name: {!!json_encode($nilai['nama_kategori'])!!},
                    data: {!!json_encode($nilai['nilai'])!!}
        }, 
        @endforeach
        ]
    });

   
</script>
@stop