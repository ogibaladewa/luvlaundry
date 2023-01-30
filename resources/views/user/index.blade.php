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
                                <h2> Data User</h2>
                            </div>
                            <div class="col-md-6">
                                <button type="button" style="float:right" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
                                    Tambah Data User
                                </button>
                                <a href="/user/exportPDF">
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
                                  <th>NAMA</th>
                                  <th>JABATAN</th>
                                  <th>EMAIL</th>
                                  <!-- <th>TEMPAT LAHIR</th>
                                  <th>TANGGAL LAHIR</th>
                                  <th>JENIS KELAMIN</th> -->
                                  <th>NO TELEPON</th>
                                  <th>ALAMAT</th>
                                  <th>CABANG</th>
                                  <th>STATUS</th>
                                  <th>AKSI</th>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h2 class="modal-title" id="exampleModalLabel">Tambah Data User</h2>   
      </div>
      <div class="modal-body">
        <form name="tambah_user" action="/user/create" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
            <div class="form-group{{$errors->has('name') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Nama</label>
                <input name="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Nama User" value="{{old('name')}}">
                @if($errors->has('name'))
                    <span class="help-block">{{$errors->first('name')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('role') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Jabatan</label>
                <select name="role" class="form-control" id="exampleInputEmail1">
                    <option value="admin"{{(old('role') ==  'admin') ? ' selected' : ''}}>Admin</option>
                    <option value="owner"{{(old('role') ==  'owner') ? ' selected' : ''}}>Owner</option>
                    <option value="pegawai"{{(old('role') ==  'pegawai') ? ' selected' : ''}}>Pegawai</option>
                </select>
                @if($errors->has('role'))
                    <span class="help-block">{{$errors->first('role')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('email') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Email</label>
                <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" value="{{old('email')}}">
                @if($errors->has('email'))
                    <span class="help-block">{{$errors->first('email')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('password') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Password</label>
                <input name="password" type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Password">
                @if($errors->has('password'))
                    <span class="help-block">{{$errors->first('password')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('tempat_lahir') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Tempat Lahir</label>
                <input name="tempat_lahir" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Tempat Lahir" value="{{old('tempat_lahir')}}">
                @if($errors->has('tempat_lahir'))
                    <span class="help-block">{{$errors->first('tempat_lahir')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('tanggal_lahir') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Tanggal Lahir</label>
                <input name="tanggal_lahir" type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Tanggal Lahir" value="{{old('tanggal_lahir')}}">
                @if($errors->has('tanggal_lahir'))
                    <span class="help-block">{{$errors->first('tanggal_lahir')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('jenis_kelamin') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" id="exampleInputEmail1">
                    <option value="L"{{(old('jenis_kelamin') ==  'L') ? ' selected' : ''}}>Laki-Laki</option>
                    <option value="P"{{(old('jenis_kelamin') ==  'P') ? ' selected' : ''}}>Perempuan</option>
                </select>
                @if($errors->has('jenis_kelamin'))
                    <span class="help-block">{{$errors->first('jenis_kelamin')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('no_telp') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">No Telepon</label>
                <input name="no_telp" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="No Telepon" value="{{old('no_telp')}}">
                @if($errors->has('no_telp'))
                    <span class="help-block">{{$errors->first('no_telp')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('alamat') ? ' has-error' : ''}}">
                <label for="exampleFormControlTextarea1">Alamat</label>
                <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3">{{old('alamat')}}</textarea>
                @if($errors->has('alamat'))
                    <span class="help-block">{{$errors->first('alamat')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('cabang_id') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Cabang</label>
                <select name="cabang_id" class="form-control" id="exampleInputEmail1">
                @foreach($data_cabang as $cabang)
                    <option value="{{$cabang->id}}">{{$cabang->nama_cabang}}</option>
                @endforeach
                </select>
                @if($errors->has('cabang_id'))
                    <span class="help-block">{{$errors->first('cabang_id')}}</span>
                @endif
            </div>
            <div class="form-group{{$errors->has('avatar') ? ' has-error' : ''}}">
                <label for="exampleInputEmail1">Avatar</label>
                <input type="file" name="avatar" class="form-control">
                @if($errors->has('avatar'))
                    <span class="help-block">{{$errors->first('avatar')}}</span>
                @endif
            </div>
            <input type="hidden" name="remember_token" value="{{Str::random(60)}}">
            <input type="hidden" name="status" value="Active">
            <!--
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Alamat</label>
                <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            !-->

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
  
    <script>
    $(document).ready(function() 
    {
        $('#datatable').DataTable({
            processing:true,
            serverside:true,
            ajax:"{{route('ajax.get.data.user')}}",
            columns:[
                {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'name',name:'name'},
                {data:'role',name:'role'},
                {data:'email',name:'email'},
                // {data:'tempat_lahir',name:'tempat_lahir'},
                // {data:'tanggal_lahir',name:'tanggal_lahir'},
                // {data:'jenis_kelamin',name:'jenis_kelamin'},
                {data:'no_telp',name:'no_telp'},
                {data:'alamat',name:'alamat'},
                {data:'cabang',name:'cabang'},
                {data:'status',name:'status'},
                {data:'aksi',name:'aksi'},
                
            ]
        })
    });
    </script>
@endsection



@stop

