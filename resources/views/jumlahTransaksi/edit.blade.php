@extends('layouts.master')
@section('content')
<div id="main-content">
    <div id="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-content">
                <h2>Edit Data Jumlah Transaksi</h2>
                    <form action="/jumlahTransaksi/{{$jumlah_transaksi->id}}/update" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                        <div class="form-group{{$errors->has('periode') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Periode</label>
                            <input name="periode" type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Tanggal Lahir" value="{{$jumlah_transaksi->periode}}">
                            @if($errors->has('periode'))
                                <span class="help-block">{{$errors->first('periode')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{$errors->has('jumlah') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Jumlah</label>
                            <input name="jumlah" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Tempat Lahir" value="{{$jumlah_transaksi->jumlah}}">
                            @if($errors->has('jumlah'))
                                <span class="help-block">{{$errors->first('jumlah')}}</span>
                            @endif
                        </div>
                        <div class="form-group{{$errors->has('total_berat') ? ' has-error' : ''}}">
                            <label for="exampleInputEmail1">Total Berat</label>
                            <input name="total_berat" type="number" step="0.01" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="No Telepon" value="{{$jumlah_transaksi->total_berat}}">
                            @if($errors->has('total_berat'))
                                <span class="help-block">{{$errors->first('total_berat')}}</span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@stop