@extends('layouts.master')

@section('content')
    <div id="main-content">
        <div id="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-6">
                                <h2> Data Stock Barang</h2>
                            </div>
                            <div class="col-md-6">
                                <a href="/barang/exportPDF">
                                    <button type="button" style="float:right; margin-right:5px;" class="btn btn-danger float-right">
                                        <i class="fa fa-save"></i> &nbsp;PDF
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                               
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                        </div>
                        <table class="table table-hover no-margin" id="datatable">
							<thead>
								<tr>
                                  <th>NO.</th>
                                  <th>KODE BARANG</th>
                                  <th>NAMA BARANG</th>
                                  <th style="text-align:left;">STOCK</th>
                                  <th>SATUAN</th>
								</tr>
							</thead>
							<tbody>
                            
							</tbody>
						</table>
                        <div class="row">
                            <div class="col-md-12">
                                
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>

  @section('script')
    @if (count($errors) > 0)
	    <script>
        $(document).ready(function() {
            $('#exampleModal').modal('show');
        } );
	    </script>
    @endif
  
    <script>
    $(document).ready(function() 
    {
        $('#datatable').DataTable({
            processing:true,
            serverside:true,
            ajax:"{{route('ajax.get.data.stock')}}",
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
    </script>
@endsection



@stop

