<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index(){
        // $data = [
        //     'level_id'=>2,
        //     'nama'=>'Manager 3',
        //     'username' => 'manager_tiga',
        //     'password' => Hash::make('12345')
        // ];
        // UserModel::create($data);

        // $user = UserModel::all();
        // return view('user', ['data'=>$user]);

        // $user = UserModel::firstWhere('level_id',1);
        // return view('user', ['data'=>$user]);

        // $user = UserModel::findOr(20,['username','nama'],function(){
        //     abort(404);
        // });
        // return view('user', ['data'=>$user]);

        // $user = UserModel::findOrFail(1);
        // return view('user', ['data'=>$user]);

        // $user = UserModel::where('username', 'manager9')->firstorFail();
        // return view('user', ['data'=>$user]);
        
        // $count = UserModel::where('active', 1)->count();
        // $max = UserModel::where('active', 1)->max('price');

        // $user = UserModel::where('level_id', 2)->count();
        // return view('user', ['data'=>$user]);
        
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manage Tiga Tiga',
        //         'password'=> Hash::make('12345'),
        //         'level_id' => 2

        //     ]
        // );
        // $user->save();
        // return view('user', ['data'=>$user]);

        // $user = UserModel::create(
        //     [
        //         'username'=>'manager11',
        //         'nama'=>'Manager11',
        //         'password'=>Hash::make('12345'),
        //         'level_id' =>2
        //     ]);

        //     $user->username='manager12';
        //     // $user->isDirty();
        //     // $user->isDirty('username');
        //     // $user->isDirty('nama');
        //     // $user->isDirty(['nama','username']);

        //     // $user->isClean();
        //     // $user->isClean('username');
        //     // $user->isClean('nama');
        //     // $user->isClean(['nama','username']);
            
        //     $user->save();
            
        //     // $user->isDirty();
        //     // $user->isClean();
        //     // dd($user->isDirty());

        //     $user->wasChanged();
        //     $user->wasChanged('username');
        //     $user->wasChanged(['username','level_id']);
        //     $user->wasChanged('nama');
        //     dd($user->wasChanged(['nama','username']));

        // $user=UserModel::all();
        // return view('user',['data'=>$user]);

        $user = UserModel::with('level')->get();
        return view('user', ['data' => $user]);
        }

        public function tambah(){
            return view('user_tambah');
        }

        public function tambah_simpan(Request $request){
            UserModel::create([
                'username'=>$request->username,
                'nama'=>$request->nama,
                'password'=>Hash::make($request->password),
                'level_id'=>$request->level_id
            ]);
            return redirect('/user');
        }

        public function ubah($id){
            $user = UserModel::find($id);
            return view('user_ubah', ['data'=>$user]);
        }

        public function ubah_simpan($id, Request $request){
            $user = UserModel::find($id);
            $user->username=$request->username;
            $user->nama =$request->nama;
            $user->password=Hash::make($request->password);
            $user->save();
            return redirect('/user');
        }

        public function hapus($id){
            $user =UserModel::find($id);
            if ($user) {
                $user->delete();
            }

            return redirect('/user');
        }
}
