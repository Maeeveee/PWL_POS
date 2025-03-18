<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\LevelModel as ModelsLevelModel;
use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
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

        // $user = UserModel::with('level')->get();
        // return view('user', ['data' => $user]);
        // }

        // public function tambah(){
        //     return view('user_tambah');
        // }

        // public function tambah_simpan(Request $request){
        //     UserModel::create([
        //         'username'=>$request->username,
        //         'nama'=>$request->nama,
        //         'password'=>Hash::make($request->password),
        //         'level_id'=>$request->level_id
        //     ]);
        //     return redirect('/user');
        // }

        // public function ubah($id){
        //     $user = UserModel::find($id);
        //     return view('user_ubah', ['data'=>$user]);
        // }

        // public function ubah_simpan($id, Request $request){
        //     $user = UserModel::find($id);
        //     $user->username=$request->username;
        //     $user->nama =$request->nama;
        //     $user->password=Hash::make($request->password);
        //     $user->save();
        //     return redirect('/user');
        // }

        // public function hapus($id){
        //     $user =UserModel::find($id);
        //     if ($user) {
        //         $user->delete();
        //     }

        //     return redirect('/user');
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list'  => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        $level = LevelModel::all();

        return view('user.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Ambil data user dalam bentuk json untuk datatables 
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->with('level');

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {  // menambahkan kolom aksi 
                $btn  = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn
sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/user/' . $user->user_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return 
confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list'  => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah user baru'
        ];

        $level = LevelModel::all();
        $activeMenu = 'user';

        return view('user.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username',
            'nama'     => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);
        UserModel::create([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]);
        return redirect('/user')->with('success', 'Data user berhasil disimpan');
    }
    public function show(string $id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list'  => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'user';

        return view('user.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            "title" => "Edit User",
            "list" => ["Home", "User", "Edit"]
        ];

        $page = (object) [
            "title" => "Edit User"
        ];

        $activeMenu = 'user'; // set menu yang sedang aktif

        return view('user.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            // username harus diisi, berupa string, minimal 3 karakter,
            // dan bernilai unik di tabel m_user, kecuali untuk user dengan id yang sedang diedit
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'nullable|min:5', // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
            'level_id' => 'required|integer' // level_id harus diisi dan berupa angka
        ]);

        UserModel::find($id)->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    // Menghapus data user
    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) { // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id); // Hapus data level

            return redirect('/user')->with('success', 'Data user berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
