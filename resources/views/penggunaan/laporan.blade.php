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
                                <form action="/penggunaan/laporan" method="GET">
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
                                &nbsp;
                                <div id="chartPenggunaanBarangLine"></div>
                            </div>   
                        </div>
                        <div class="row" style="border-top:5px solid #f5f5fa;">
                            <div class="col-md-12">
                                &nbsp;
                                <div id="chartPenggunaanKatBulanan"></div>
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
                            <div class="col-md-12">
                                &nbsp;
                                <div id="chartKategoriLalu"></div>
                            </div>   
                        </div>
                        <div class="row" style="border-top:5px solid #f5f5fa;">
                            <div class="col-md-12">
                                &nbsp;
                                <div id="chartBarangLalu"></div>
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
Highcharts.chart('chartPenggunaanBarangLine', {
    chart: {
        zoomType: 'xy'
    },
    title: {
        text: 'Total Penggunaan Barang Tahun {{$tahun_id}}'
    },
    subtitle: {
        text: 'Total Penggunaan Antar Barang di suatu Kategori'
    },
    xAxis: [{
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        crosshair: true
    }],
    yAxis: [{ // Primary yAxis
        labels: {
            format: '{value}pcs',
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
        
        @foreach($nilaiPenggunaanKatBT as $nilai)    
        {
                    name: '{!!json_encode($nilai['nama_barang'])!!}',
                    type: 'spline',
                    data: {!!json_encode($nilai['nilai'])!!},
                    tooltip: {
                    valueSuffix: 'pcs'
                    }
        }, 
        @endforeach
    ]
    
});

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

    Highcharts.chart('chartPenggunaanKatBulanan', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Total Penggunaan per-Kategori Tahun {{$tahun_id}}'
        },
        subtitle: {
            text: 'Total Jumlah Penggunaan per-Kategori'
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
        series: [
        @foreach($nilaiPenggunaanKatA as $nilai)    
        {
                    name: {!!json_encode($nilai['nama_kategori'])!!},
                    data: {!!json_encode($nilai['nilai'])!!}
        }, 
        @endforeach
        ]
    });

    var chart = Highcharts.chart('chartBarangLalu', {

    title: {
        text: 'Jumlah Penggunaan Bulan Lalu per-Barang'
    },

    subtitle: {
        text: 'Perbandingan Penggunaan Yang Dilakukan pada Bulan Lalu Untuk Masing-Masing Barang'
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