@extends('layouts.master')

@section('content')
    <div id="main-content">
        <div id="container-fluid">
            <div class="row">
            
                <div class="col-md-12">
                    <div class="panel-content">
                    @if(session('sukses'))
                    <div class="alert alert-success" role="alert">
                        Data Berhasil Ditambahkan !
                    </div>
                    @endif
                    @if(session('editsukses'))
                    <div class="alert alert-success" role="alert">
                        Data Berhasil Diubah!
                    </div>
                    @endif
                    @if(session('hapus'))
                    <div class="alert alert-success" role="alert">
                        Data Berhasil Dihapus !
                    </div>
                    @endif
                        <div class="row">
                            <div class="col-md-6">
                                <h2> Detail Penyediaan</h2>
                            </div>
                            <div class="col-md-6">
                            <a href="/penyediaan">
                                    <button type="button" style="float:right" class="btn btn-primary float-right">
                                        Kembali Ke Data Penyediaan
                                    </button>
                                </a>
                            </div>
                        </div>
                        <table class="table table-hover no-margin" id="datatable">
							<thead>
								<tr>
                                    <th>KODE BARANG</th>
                                    <th>NAMA BARANG</th>
                                    <th>QTY</th>
                                    <th>HARGA(Rp.)</th>
                                    <th>JUMLAH(Rp.)</th>
                                    
								</tr>
							</thead>
							<tbody>
                            @foreach($data_penyediaan->barang as $barang)
                                <tr>
                                    <td>{{$barang->kode_barang}}</td>
                                    <td>{{$barang->nama_barang}}</td>
                                    <td style="text-align:right;">{{number_format((int)$barang->pivot->qty,0,',','.')}}</td>
                                    <td style="text-align:right;">{{number_format((int)$barang->pivot->harga,0,',','.')}}</td>
                                    <td style="text-align:right;">{{number_format((int)$barang->pivot->harga*$barang->pivot->qty,0,',','.')}}</td>
                                </tr> 
                            @endforeach
                                 
							</tbody>
						</table>   
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="modal-title" id="exampleModalLabel">Tambah Data Penyediaan</h2>
      </div>
      <div class="modal-body">
        <form action="/penyediaan/create" method="POST">
        {{csrf_field()}}
            <div class="form-group{{$errors->has('tanggal') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Tanggal</label>
                <input name="tanggal" type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="tanggal" value="{{old('tanggal')}}">
                @if($errors->has('tanggal'))
                    <span class="help-block">{{$errors->first('tanggal')}}</span>
                @endif
            </div>
            <input type="hidden" name="cabang_id" value="{{auth()->user()->cabang_id}}">
            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
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
@endsection
@stop

