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
                                <form action="/penyediaan/laporan" method="GET">
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
                                <div id="chartTotalPenyediaanLine"></div>
                            </div>   
                        </div>
                        <div class="row" style="border-top:5px solid #f5f5fa;">
                                &nbsp;
                            <div class="col-md-12">
                                <div id="chartPenyediaanKatBulanan"></div>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
        <div id="container-fluid" style="border-top:20px solid #f5f5fa;">
            <div class="row">
            
                <div class="col-md-12">
                    <div class="panel-content"> 
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Laporan Penyediaan Bulan Lalu</h2>
                                &nbsp;
                            </div>
                        
                           
                            <div class="col-md-6">
                                
                            </div>
                        </div>              
                        <div class="row" style="border-top:5px solid #f5f5fa;">
                            <div class="col-md-6"  style="border-right:5px solid #f5f5fa;">
                                <div id="chartSumber"></div>
                            </div> 
                            <div class="col-md-6">
                                <div id="chartKategoriLalu"></div>
                            </div>    
                        </div>
                        <div class="row" style="border-top:5px solid #f5f5fa;">
                            <div class="col-md-12">
                                <div id="chartBarangLaluNew"></div>
                                <button id="plain" class="btn-primary">Plain</button>
                                <button id="inverted" class="btn-primary">Inverted</button>
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
    // Highcharts.chart('chartTotalPenyediaan', {
    //     chart: {
    //         type: 'column'
    //     },
    //     title: {
    //         text: 'Total Jumlah Penyediaan'
    //     },
    //     subtitle: {
    //         text: 'Total Jumlah Penyediaan pada Semua Cabang'
    //     },
    //     xAxis: {
    //         categories: [ 'Jan',
    //         'Feb',
    //         'Mar',
    //         'Apr',
    //         'May',
    //         'Jun',
    //         'Jul',
    //         'Aug',
    //         'Sep',
    //         'Oct',
    //         'Nov',
    //         'Dec'],
    //         crosshair: true
    //     },
    //     yAxis: {
    //         min: 0,
    //         title: {
    //             text: 'Jumlah Penyediaan'
    //         }
    //     },
    //     tooltip: {
    //         headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    //         pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
    //             '<td style="padding:0"><b>{point.y:.1f} pcs</b></td></tr>',
    //         footerFormat: '</table>',
    //         shared: true,
    //         useHTML: true
    //     },
    //     plotOptions: {
    //         column: {
    //             pointPadding: 0.2,
    //             borderWidth: 0
    //         }
    //     },
    //     series: [
    //     @foreach($nilaiPenggunaan as $nilai)    
    //     {
    //                 name: {!!json_encode($nilai['nama_cabang'])!!},
    //                 data: {!!json_encode($nilai['nilai'])!!}
    //     }, 
    //     @endforeach
    //     ]
    // });


Highcharts.chart('chartTotalPenyediaanLine', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Total Jumlah Penyediaan Tahun {{$tahun_id}}'
    },
    subtitle: {
        text: 'Total Jumlah Penyediaan yang dilakukan pada Cabang : <b>{{$namaCabangSort}}</b>'
    },
    xAxis: [{
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value} kali',
            style: {
                color: Highcharts.getOptions().colors[1]
            }
        },
        title: {
            text: 'Total Penyediaan',
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
                    data: {!!json_encode($nilai['nilai'])!!},
                    tooltip: {
                    valueSuffix: ' kali'
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

Highcharts.chart('chartSumber', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Persentase Sumber Penyediaan Bulan Lalu'
    },
    subtitle: {
        text: 'Persentase Sumber Penyediaan Barang Bulan Lalu pada Cabang : <b>{{$namaCabangSort}}</b>'
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
        name: 'Presentase',
        colorByPoint: true,
        data: [
        @foreach($nilaiPresentase as $nilaiP) 
        {
            name: {!!json_encode($nilaiP['nama_supplier'])!!},
            y: {!!json_encode($nilaiP['presentase'])!!}
        },
        @endforeach
        ]
        
        
        // {
        // name: 'Brands',
        // colorByPoint: true,
        // data: [{
        //     name: 'Pelembut',
        //     y: 4
            
        // }, {
        //     name: 'Wantek',
        //     y: 5
        // }, {
        //     name: 'Deterjen',
        //     y: 10
        // }
    }]
});

Highcharts.chart('chartKategoriLalu', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Jumlah Penyediaan Bulan Lalu'
        },
        subtitle: {
            text: 'Jumlah Penyediaan Bulan Lalu per Kategori pada Cabang : <b>{{$namaCabangSort}}</b>'
        },
        xAxis: {
            categories:
                {!!json_encode($namaKat)!!},
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
        series: [{
                    name: 'Peyediaan Per Kategori Bulan Lalu',
                    data: {!!json_encode($nilaiPenyediaanKat)!!}
        }, 
        
        ]
    });

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

    // Highcharts.chart('chartBarangLalu', {
    //     chart: {
    //         type: 'column'
    //     },
    //     title: {
    //         text: 'Jumlah Penyediaan Barang Bulan Lalu'
    //     },
    //     subtitle: {
    //         text: 'Jumlah Penyediaan Bulan Lalu per Barang'
    //     },
    //     xAxis: {
    //         categories:
    //             {!!json_encode($namaBarang)!!},
    //         crosshair: true
    //     },
    //     yAxis: {
    //         min: 0,
    //         title: {
    //             text: 'Jumlah Penyediaan'
    //         }
    //     },
    //     tooltip: {
    //         headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    //         pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
    //             '<td style="padding:0"><b>{point.y:.1f} pcs</b></td></tr>',
    //         footerFormat: '</table>',
    //         shared: true,
    //         useHTML: true
    //     },
    //     plotOptions: {
    //         column: {
    //             pointPadding: 0.2,
    //             borderWidth: 0
    //         }
    //     },
    //     series: [{
    //                 name: 'Peyediaan Per Barang Bulan Lalu',
    //                 data: {!!json_encode($nilaiPenyediaanBarang)!!}
    //     }, 
        
    //     ]
    // });

    var chart = Highcharts.chart('chartBarangLaluNew', {

    title: {
        text: 'Jumlah Penyediaan Bulan Lalu per-Barang'
    },

    subtitle: {
        text: 'Perbandingan Penyediaan Yang Dilakukan pada Bulan Lalu Untuk Masing-Masing Barang pada Cabang : <b>{{$namaCabangSort}}</b>'
    },

    xAxis: {
        categories: {!!json_encode($namaBarang)!!},
    },

    series: [{
        type: 'column',
        colorByPoint: true,
        data: {!!json_encode($nilaiPenyediaanBarang)!!},
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