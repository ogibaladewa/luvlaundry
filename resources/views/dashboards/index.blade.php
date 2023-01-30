@extends('layouts.master')
@section('content')
    <div id="main-content">
        <div id="container-fluid">
            <div class="row">
            
                <div class="col-md-12">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="infobox infobox1">
                                    <table style="height:100%; width:100%; border:0px solid green; color:white;">
                                        <tr>
                                            <td style="font-size:80px;  text-align:center;"><i class="lnr lnr-user"></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td style="text-align:right;"><b style="font-size:30px;">{{$jumlahUser}}</b><br>Jumlah User Aktif</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="infobox infobox2">
                                    <table style="height:100%; width:100%; border:0px solid green; color:white;">
                                        <tr>
                                            <td style="font-size:80px;  text-align:center;"><i class="lnr lnr-apartment"></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td style="text-align:right;"><b style="font-size:30px;">{{$jumlahSupplier}}</b><br>Jumlah Supplier Aktif</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="infobox infobox3">
                                    <table style="height:100%; width:100%; border:0px solid green; color:white;">
                                        <tr>
                                            <td style="font-size:80px;  text-align:center;"><i class="lnr lnr-book"></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td style="text-align:right;"><b style="font-size:30px;">{{$jumlahTransaksi}}</b><br>Jumlah Transaksi Bulan Lalu</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="infobox infobox4">
                                    <table style="height:100%; width:100%; border:0px solid green; color:white;">
                                        <tr>
                                            <td style="font-size:80px;  text-align:center;"><i class="lnr lnr-coffee-cup"></td>
                                            <td>&nbsp;&nbsp;</td>
                                            <td style="text-align:right;"><b style="font-size:30px;">{{$jumlahPenyediaan}}</b><br>Jumlah Penyediaan Bulan Lalu</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br />
                        <div class="row" style="border-top:5px solid #f5f5fa;border-bottom:5px solid #f5f5fa;">
                            <div class="col-md-7" style="border-right:5px solid #f5f5fa;">
                                <div id="chartKategoriLalu"></div>
                            </div>
                            <div class="col-md-5">
                                <div id="chartPie"></div>
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
<script>
    Highcharts.chart('chartKategoriLalu', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Jumlah Penggunaan Bulan Lalu'
        },
        subtitle: {
            text: 'Jumlah Penggunaan Bulan Lalu per Kategori'
        },
        xAxis: {
            categories:
                {!!json_encode($namaKat)!!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Penggunaan'
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
        series: [{
                    name: 'Penggunaan Per Kategori Bulan Lalu',
                    data: {!!json_encode($nilaiPenggunaanKat)!!}
        }, 
        
        ]
    });

    Highcharts.chart('chartPie', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Persentase Penggunaan Bulan Lalu'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [
            <?php
            for($i=0; $i<count($nilaiPenggunaanKat);$i++){
                echo "{
                        name: '".$namaKat[$i]."',
                        y: ".$nilaiPenggunaanKat[$i]."
                      },";
            }
            ?>
        ]
    }]
});
</script>
@stop