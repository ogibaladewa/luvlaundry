@extends('layouts.master')
@section('content')

    <div id="main-content">
        <div id="container-fluid">
            <div class="row">
            
                <div class="col-md-12">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Laporan Jumlah Transaksi</h2>
                                &nbsp;
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                        </div>
                        <div class="row" style="border-top:5px solid #f5f5fa;">
                        &nbsp;
                                <form action="/jumlahTransaksi/laporan" method="GET">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label>Tahun</label>
                                            <select name="tahun" id="tahun">
                                                @foreach($data_tahun as $tahun)
                                                <option value="{{$tahun}}" <?php if($tahun_id == $tahun){echo 'selected';} ?>>{{$tahun}}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="btn-primary">
                                                Tampilkan
                                            </button>
                                        </div>
                                        
                                    </div>
                                </form>
                            <div class="col-md-12">
                                <div id="chartPenggunaan"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    
                                </div>
                                <div class="col-md-6">
                                    <button style="float:right; margin-right:5px;"  onclick="exportToExcel('exportDataJumlah', 'LaporanJumlahTransaksiTahun_{{$tahun_id}}')" class="btn btn-success"><i class="fa fa-save"></i> &nbsp;Excel</button>
                                </div>
                            
                        </div>  
                            <table class="table" id="exportDataJumlah">
                                <!-- <tr>
                                    <td colspan="13">
                                        <h3 style="text-align:center">Jumlah Transaksi {{$tahun_id}}</h3>
                                        <a href="/barang/laporanHarga/exportPDF">
                                            <button type="button" style="float:right; margin-right:5px;" class="btn btn-danger float-right">
                                                <i class="fa fa-save"></i> &nbsp;PDF
                                            </button>
                                        </a>
                                    </td>
                                </tr> -->
                                <!-- <tr>
                                    <td colspan="13" style="text-align:center">
                                         
                                    </td>
                                </tr> -->
                                <tr>
                                    <th colspan="13" style="text-align:center;text-transform:uppercase">JUMLAH TRANSAKSI TAHUN {{$tahun_id}}</th>
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
                                    for($i=0;$i<count($nilaiPenggunaan);$i++){
                                        echo '<tr>
                                                <td>'.$nilaiPenggunaan[$i]['nama_cabang'].'</td>
                                            ';
                                        for($j=0;$j<12;$j++){
                                            if($nilaiPenggunaan[$i]['nilai'][$j] == 0){
                                                echo'<td>-</td>';
                                            }
                                            else{

                                                echo '
                                                <td>'.$nilaiPenggunaan[$i]['nilai'][$j].' Kali</td>
                                                ';
                                            }
                                        }
                                        echo'</tr>';
                                    }
                                ?>
                                
                            </table>  
                        </div>
                        
                        <div class="row" style="border-top:5px solid #f5f5fa;">
                            <div class="col-md-12">
                                &nbsp;
                                <div id="chartBerat"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    
                                </div>
                                <div class="col-md-6">
                                    <button style="float:right; margin-right:5px;"  onclick="exportToExcel('exportDataBerat', 'LaporanTotalBeratTahun_{{$tahun_id}}')" class="btn btn-success"><i class="fa fa-save"></i> &nbsp;Excel</button>
                                </div>
                            </div>   
                            <table class="table" id="exportDataBerat">
                                <!-- <tr>
                                    <td colspan="13">
                                        <h3 style="text-align:center">Jumlah Transaksi {{$tahun_id}}</h3>
                                        <a href="/barang/laporanHarga/exportPDF">
                                            <button type="button" style="float:right; margin-right:5px;" class="btn btn-danger float-right">
                                                <i class="fa fa-save"></i> &nbsp;PDF
                                            </button>
                                        </a>
                                    </td>
                                </tr> -->
                                <!-- <tr>
                                    <td colspan="13" style="text-align:center">
                                         
                                    </td>
                                </tr> -->
                                <tr>
                                    <th colspan="13" style="text-align:center;text-transform:uppercase">TOTAL BERAT LAUNDRY TAHUN {{$tahun_id}}</th>
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
                                    for($i=0;$i<count($nilaiPenggunaan);$i++){
                                        echo '<tr>
                                                <td>'.$nilaiPenggunaan[$i]['nama_cabang'].'</td>
                                            ';
                                        for($j=0;$j<12;$j++){
                                            if($nilaiPenggunaan[$i]['berat'][$j] == 0){
                                                echo'<td>-</td>';
                                            }
                                            else{

                                                echo '
                                                <td>'.$nilaiPenggunaan[$i]['berat'][$j].' Kg</td>
                                                ';
                                            }
                                        }
                                        echo'</tr>';
                                    }
                                ?>
                                
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="container"></div>
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
<!-- <script src="https://code.highcharts.com/highcharts.js"></script> -->

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

<script>
    Highcharts.chart('chartPenggunaan', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Jumlah Transaksi  Tahun {{$tahun_id}}'
        },
        subtitle: {
            text: 'Jumlah Transaksi Pelayanan Bulanan'
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
                text: 'Jumlah Transaksi'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.0f} kali</b></td></tr>',
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
        
        @foreach($nilaiPenggunaan as $nilai)  
        {
        
                    name: {!!json_encode($nilai['nama_cabang'])!!},
                    data: {!!json_encode($nilai['nilai'])!!}
        }, 
        @endforeach
        ]
    });

Highcharts.chart('chartBerat', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Total Berat Laundry Tahun {{$tahun_id}}'
    },
    subtitle: {
        text: 'Total Berat Pakaian dan Lainnya Dalam Pelayanan Bulanan'
    },
    xAxis: [{
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}kg',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Total Berat',
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
            format: '{value} pcs',
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
        
        @foreach($nilaiPenggunaan as $nilai)    
        {
                    name: {!!json_encode($nilai['nama_cabang'])!!},
                    type: 'spline',
                    data: {!!json_encode($nilai['berat'])!!},
                    tooltip: {
                    valueSuffix: 'kg'
                    }
        }, 
        @endforeach
    ]
    //     {
    //     name: 'Rainfall',
    //     type: 'column',
    //     yAxis: 1,
    //     data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
    //     tooltip: {
    //         valueSuffix: ' mm'
    //     }

    // }, {
    //     name: 'Temperature',
    //     type: 'spline',
    //     data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
    //     tooltip: {
    //         valueSuffix: '°C'
    //     }
    // }]
});

</script>
@stop