@extends('layouts.master')

@section('content')
    <div id="main-content">
        <div id="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel-content">
                        <div class="row">
                            <div class="col-md-12" style="text-align:center;">
                                <h2>UBAH PASSWORD</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                
                            </div>
                            <div class="col-md-6">
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-1">
                                
                            </div>
                            <div class="col-md-2">
                                
                            </div>
                            
                            <div class="col-md-6">
                            <form action="/user/{{auth()->user()->id}}/update_password" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}  
                            {{ method_field('put') }}     
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                        <div class="form-group{{$errors->has('current_password') ? ' has-error' : ''}}">
                                            <label for="exampleInputEmail1">Password Lama</label>
                                            <input name="current_password" type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{old('current_password')}}">
                                            @if($errors->has('current_password'))
                                                <span class="help-block">{{$errors->first('current_password')}}</span>
                                            @endif
                                        </div>
                                </div>
                            </div>                         
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                        <div class="form-group{{$errors->has('password') ? ' has-error' : ''}}">
                                            <label for="exampleInputEmail1">Password Baru</label>
                                            <input name="password" type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{old('password')}}">
                                            @if($errors->has('password'))
                                                <span class="help-block">{{$errors->first('password')}}</span>
                                            @endif
                                        </div>
                                </div>
                            </div>                         
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                        <div class="form-group{{$errors->has('password_confirmation') ? ' has-error' : ''}}">
                                            <label for="exampleInputEmail1">Konfirmasi Password Baru</label>
                                            <input name="password_confirmation" type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                            @if($errors->has('password_confirmation'))
                                                <span class="help-block">{{$errors->first('password_confirmation')}}</span>
                                            @endif
                                        </div>
                                </div>
                            </div>   
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">  
                            @if(session('gagal1'))
							
								<p style="color:#f72f2f;">Password Lama Salah!</p>
							
							@endif
                            @if(session('gagal2'))
							
								<p style="color:#f72f2f;">Password Baru dan Password Lama Tidak Boleh Sama!</p>
							
							@endif
                            @if(session('gagal3'))
							
								<p style="color:#f72f2f;">Password Konfirmasi Tidak Cocok!</p>
							
							@endif
                            @if(session('sukses'))
							
								<p style="color:#f72f2f;">Berhasil!</p>
							
							@endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">                    
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                            </form>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop