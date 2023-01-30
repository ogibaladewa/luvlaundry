<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Auth;
use Hash;
use Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // $items = $request->items ?? 5;
        // $page = $request->has('page') ? $request->get('page') : 1;
        // $total = \App\User::count();
        // $per_page = $items;
        // $showing_total = $page * $per_page;

        // $current_showing = $showing_total>$total ? $total : $showing_total;
        // $showing_started = $showing_total - $per_page + 1;
        // $table_info = "Showing $showing_started to $current_showing of $total";

        if($request->has('cari')){
            $data_user = \App\User::where('name','LIKE','%'.$request->cari.'%')->paginate(5);
        }
        else{
            $data_user = \App\User::all();
        }
        $data_cabang = \App\Cabang::all();
        return view('user.index',['data_user' => $data_user, 'data_cabang' => $data_cabang]);
    }


    public function create(Request $request)
    {
        if($request->hasfile('avatar')){
            $avatar = $request->file('avatar')->getClientOriginalName();
        }
        else{
            $avatar = $request->avatar = 'default.png';
        }
        $this->validate($request,[
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'avatar' => 'mimes:jpg,png',
            'cabang_id' => 'required',
        ]);
        DB::table('users')->insert([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'avatar' => $avatar,
            'status' => $request->status,
            'cabang_id' => $request->cabang_id,
            'remember_token' => $request->remember_token
        ]);
        if($request->hasfile('avatar')){
            $request->file('avatar')->move('images/',$request->file('avatar')->getClientOriginalName());
        }

        return redirect('/user')->with('sukses','Data Berhasil Ditambahkan !');  
    }

    public function edit($id)
    {
        $user = \App\User::find($id);
        return view('user/edit',['user' => $user]);
    }

    public function update(Request $request,$id)
    {
        //dd($request->all());
        $user = \App\User::find($id);
        $user->update($request -> all());
        if($request->hasfile('avatar')){
            $request->file('avatar')->move('images/',$request->file('avatar')->getClientOriginalName());
            $user->avatar = $request->file('avatar')->getClientOriginalName();
            $user->save();
        }
        return redirect('/user')->with('editsukses','Data Berhasil Diupdate !');  
    }

    public function delete($id)
    {
        $user = \App\User::find($id);
        $user->delete();
        return redirect('/user')->with('hapus','Data Berhasil Dihapus !'); 
    }

    public function profile($id)
    {
        $user = \App\User::find($id);
        return view('user.profile',['user' => $user]);
    }

    public function dataDiri($id)
    {
        $data_diri = \App\User::find($id);
        return view('user.data_diri',['data_diri' => $data_diri]);
    }

    public function ubahPassword($id)
    {
        $data_diri = \App\User::find($id);
        return view('user.ubah_password',['data_diri' => $data_diri]);
    }

    public function updatePassword($id, Request $request)
    {
        // custom validator
        Validator::extend('password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, \Auth::user()->password);
        });
 
        // message for custom validation
        $messages = [
            'password' => 'Invalid current password.',
        ];
 
        // validate form
        $validator = Validator::make(request()->all(), [
            'current_password' => 'required|password',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
 
        ], $messages);
 
        // if validation fails
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors());
        }
 
        // update password
        $user = \App\User::find(Auth::id());
 
        $user->password = bcrypt(request('password'));
        $user->save();
 
        return redirect('/user/'.$id.'/ubah_password')->with('sukses', 'Password Lama Salah!');


//asdasdada


        // $this->validate($request,[
        //     'passwordLama' => 'required|min:8',
        //     'passwordBaru' => 'required|min:8',
        //     'passwordKonfirm' => 'required|min:8',
        // ]);

        // $data_diri = \App\User::find($id);

        // $cekPassLama = bcrypt($request->passwordLama);
        // $cekPassBaru = bcrypt($request->passwordBaru);
        // $cekPassKonfirm = bcrypt($request->passwordKonfirm);
        // // dd($data_diri->password);
        // dd($cekPassLama);
        // if($data_diri->password == $cekPassLama){
        //     if($cekPassBaru != $cekPassLama){
        //         if($cekPassBary == $cekPassKonfirm){
                    
        //         }
        //         else{
        //             return redirect('/user/'.$id.'/ubah_password')->with('gagal3', 'Password Konfirmasi Tidak Cocok!');
        //         }
        //     }
        //     else{
        //         return redirect('/user/'.$id.'/ubah_password')->with('gagal2', 'Password Baru dan Password Lama Tidak Boleh Sama!');
        //     }
        // }
        // elseif($data_diri->password != $cekPassLama){
        //     return redirect('/user/'.$id.'/ubah_password')->with('gagal1', 'Password Lama Salah!');
        // }
    }



    public function getdatauser()
    {
        $user = \App\User::select('users.*');

        return \DataTables::eloquent($user)
        ->addColumn('cabang',function($u){
            return $u->cabang->nama_cabang;
        })
        ->addColumn('aksi',function($u){
            return '<a href="/user/'.$u->id.'/edit" class="btn btn-warning btn-sm"><i class="lnr lnr-pencil"></i></a>
            <a href="/user/'.$u->id.'/profile" class="btn btn-info btn-sm"><i class="lnr lnr-eye"></i></a>
            <a href="/user/'.$u->id.'/delete" class="btn btn-danger btn-sm" onclick="return confirm(\'Yakin Hapus Data?\')"><i class="lnr lnr-trash"></i></a>';
        })
        ->rawColumns(['cabang','aksi'])
        ->addIndexColumn()
        ->toJson();
    }

    public function exportPDF()
    {
        $user = \App\User::all();
        
        $pdf = PDF::loadView('export.userPDF', ['user' => $user] )->setPaper('a4', 'landscape');
        return $pdf->download('dataUser.pdf');
    }
}
