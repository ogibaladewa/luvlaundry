@extends('layouts.master')
@section('content')
    <div id="main-content">
        <div id="container-fluid">
            <div class="row">
            
                <div class="col-md-12">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Laporan Stock Terkini</h2>
                                &nbsp;
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                        </div>
                        <div class="row" style="border-top:5px solid #f5f5fa;">
                        &nbsp;
                                <form action="/barang/laporanStock" method="GET">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label>Cabang</label>
                                            <select name="cabang" id="cabang">
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
                                <div id="chartStockTerkini"></div>
                            </div>  
                            <div class="row">
                                <div class="col-md-6">
                                    
                                </div>
                                <div class="col-md-6">
                                    <button style="float:right; margin-right:5px;"  onclick="exportToExcel('exportDataStock', 'LaporanStockTerkiniCabang{{$namaCabangSort}}{{date('d-m-Y')}}')" class="btn btn-success"><i class="fa fa-save"></i> &nbsp;Excel</button>
                                </div> 
                            </div> 
                                <table class="table table-hover no-margin" id="exportDataStock">
                                
                                    <thead>
                                        <tr>
                                            <th colspan="5" style="text-align:center;text-transform:uppercase">JUMLAH STOCK TERKINI</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2">TANGGAL : {{date('d-m-Y')}}</td>
                                            <td colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">CABANG : {{$namaCabangSort}}</td>
                                            <td colspan="3"></td>
                                        </tr>
                                        <tr>
                                            <th>NO.</th>
                                            <th>KODE BARANG</th>
                                            <th>NAMA BARANG</th>
                                            <th>STOCK</th>
                                            <th>SATUAN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $no=1;?>
                                    @foreach($nilaiStockTerkini as $nilai)
                                        <tr>
                                            <td>{{$no}}</td>
                                            <td>{{$nilai['kode_barang']}}</td>
                                            <td>{{$nilai['nama_barang']}}</td>
                                            <td style="text-align:right;">{{$nilai['nilai']}}</td>
                                            <td>{{$nilai['satuan']}}</td>
                                        </tr>
                                        <?php $no++; ?>
                                    @endforeach
                                    </tbody>
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

    $(document).ready(function() 
    {
        $('#datatable').DataTable({
            processing:true,
            serverside:true,
            ajax:"{{route('ajax.get.data.laporanstock')}}",
            columns:[
                {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'kode_barang',name:'kode_barang'},
                {data:'nama_barang',name:'nama_barang'},
                {data:'stock',name:'stock'},
                {data:'satuan',name:'satuan'},
                
            ],
            columnDefs: [
                {"className": "dt-right", "targets": [3]}
            ]
        })
    });

Highcharts.chart('chartStockTerkini', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Jumlah Stock Terkini'
        },
        subtitle: {
            text: 'Jumlah Stock Terkini per-Barang pada Cabang : <b>{{$namaCabangSort}}</b>'
        },
        xAxis: {
            categories:[''],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah Stock Terkini'
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
        
        @foreach($nilaiStockTerkini as $nilai)    
        {
                    name: {!!json_encode($nilai['nama_barang'])!!},
                    data: [{!!json_encode($nilai['nilai'])!!}]
        }, 
        @endforeach
        
        ]
    });
</script>
@stop