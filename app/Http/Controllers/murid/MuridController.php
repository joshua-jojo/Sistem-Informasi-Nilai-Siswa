<?php

namespace App\Http\Controllers\murid;

use App\Http\Controllers\Controller;
use App\Http\Requests\murid\MuridDeleteRequest;
use App\Http\Requests\murid\MuridStoreRequest;
use App\Http\Requests\murid\MuridUpdateRequest;
use App\Models\Agama;
use App\Models\Jurusan;
use App\Models\Murid;
use App\Models\User;
use Illuminate\Http\Request;

class MuridController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'cari' => !empty($request->cari) ? $request->cari : '',
            'show' => !empty($request->show) ? $request->show : 5,
        ];

        $user = User::with(["role", "murid.agama", "murid.kelas", "murid.jurusan"])->whereHas("role", function ($q) {
            $q->where("nama", "murid");
        });

        $user = $user->where(function ($q) use ($params) {
            $q->where("nama", "like", "%{$params['cari']}%");
            $q->orWhere("alamat", "like", "%{$params['cari']}%");
            $q->orWhere("no_hp", "like", "%{$params['cari']}%");
            $q->orWhereHas("murid.agama", function ($agama) use ($params) {
                $agama->where("agama", "like", "%{$params['cari']}%");
            });
            $q->orWhereHas("murid.kelas", function ($agama) use ($params) {
                $agama->where("kelas", "like", "%{$params['cari']}%");
            });
            $q->orWhereHas("murid.jurusan", function ($agama) use ($params) {
                $agama->where("jurusan", "like", "%{$params['cari']}%");
            });
            $q->orWhereHas("murid", function ($agama) use ($params) {
                $agama->where("nis", "like", "%{$params['cari']}%");
            });
        });
        $user = $user->latest()->paginate($params['show'])->withQueryString();

        $jurusan = Jurusan::with("kelas")->get();
        $agama = Agama::all();

        $data = [
            "params" => $params,
            "murid" => $user,
            "jurusan" => $jurusan,
            "agama" => $agama,
        ];
        return inertia()->render("master/murid", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MuridStoreRequest $request)
    {
        $user = new User();
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->alamat = $request->alamat;
        $user->no_hp = $request->no_hp;
        $user->role_id = 4;
        $user->password = bcrypt($request->password);
        $user->save();

        $murid_terakhir = Murid::latest()->first();
        $urutan = !empty($murid_terakhir) ? $murid_terakhir->id + 1 : 1;
        $murid = new Murid();
        $murid->nis = sprintf("M-%06s", $urutan);
        $murid->agama_id = $request->agama_id;
        $murid->user_id = $user->id;
        $murid->kelas_id = $request->kelas_id;
        $murid->jurusan_id = $request->jurusan_id;
        $murid->tanggal_lahir = $request->tanggal_lahir;
        $murid->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MuridUpdateRequest $request, $id)
    {
        $user = User::find($request->id);
        $user->nama = $user->nama != $request->nama ? $request->nama : $user->nama;
        $user->no_hp = $user->no_hp != $request->no_hp ? $request->no_hp : $user->no_hp;
        $user->alamat = $user->alamat != $request->alamat ? $request->alamat : $user->alamat;

        if (!empty($request->password)) {
            $request->validate([
                "password" => "confirmed"
            ]);

            $user->password = bcrypt($request->password);
        }

        if ($request->username != $user->username) {
            $request->validate([
                "username" => "unique:users,username"
            ]);
            $user->username = $request->username;
        }

        $user->save();

        $murid = Murid::where("user_id", $user->id)->first();
        if (!empty($murid)) {
            $murid->tanggal_lahir = ($murid->tanggal_lahir != $request->tanggal_lahir) ? $request->tanggal_lahir : $murid->tanggal_lahir;
            $murid->kelas_id = $murid->kelas_id != $request->kelas_id ? $request->kelas_id : $murid->kelas_id;
            $murid->jurusan_id = $murid->jurusan_id != $request->jurusan_id ? $request->jurusan_id : $murid->jurusan_id;
            $murid->agama_id = $murid->agama_id != $request->agama_id ? $request->agama_id : $murid->jurusan_id;
            $murid->save();
        } else {
            $murid = new Murid();
            $murid->user_id = $user->id;
            $murid->tanggal_lahir = $request->tanggal_lahir;
            $murid->kelas_id = $request->kelas_id;
            $murid->jurusan_id = $request->jurusan_id;
            $murid->agama_id = $request->agama_id;
            $murid->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MuridDeleteRequest $id)
    {
        $user = User::with("murid")->find($id)->first();

        $user->murid->delete();
        $user->delete();
    }
}
