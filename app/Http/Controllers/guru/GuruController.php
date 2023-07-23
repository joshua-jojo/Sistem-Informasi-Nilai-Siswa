<?php

namespace App\Http\Controllers\guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\guru\GuruStoreRequests;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;

class GuruController extends Controller
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

        $guru = User::with(['guru'])->where("role_id", 3);
        $guru = $guru->where(function ($q) use ($params) {
            $q->where("nama", "like", "%{$params['cari']}%");
        });
        $guru = $guru->latest()->paginate($params['show'])->withQueryString();

        $data = [
            "params" => $params,
            "guru" => $guru,
        ];
        return inertia()->render('master/guru', $data);
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
    public function store(GuruStoreRequests $request)
    {
        $user = new User();
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;
        $user->role_id = 3;
        $user->password = $request->password;
        $user->save();

        $guru_terakhir = Guru::latest()->first();
        $urutan = !empty($guru_terakhir) ? $guru_terakhir->id + 1 : 1;
        $guru = new Guru();
        $guru->nip = sprintf("G-%06s", $urutan);
        $guru->user_id = $user->id;
        $guru->save();
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
