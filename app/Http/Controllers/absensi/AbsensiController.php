<?php

namespace App\Http\Controllers\absensi;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
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

        $absensi = Absensi::with(["jadwal_pelajaran.kelas", "user"]);
        $absensi = $absensi->whereHas('jadwal_pelajaran', function ($jadwal) use ($request) {
            $jadwal->where("user_id", $request->user()->id);
        });
        $absensi = $absensi->where(function ($q) use ($params) {
           $q->whereHas('user', function ($user) use ($params) {
                $user->where("nama", "like", "%{$params['cari']}%");
            });
            $q->orWhereHas('jadwal_pelajaran.kelas', function ($kelas) use ($params) {
                $kelas->where("kelas", "like", "%{$params['cari']}%");
            });
            $q->orWhereHas('jadwal_pelajaran', function ($tanggal) use ($params) {
                $tanggal->where("tanggal", "like", "%{$params['cari']}%");
            });
            $q->orWhere("status", "like", "%{$params['cari']}%");
        });

        $absensi = $absensi->paginate($params['show'])->withQueryString();

        $data = [
            'absensi' => $absensi,
            'params' => $params,

        ];
        return inertia()->render('laporan/absensi', $data);
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
    public function store(Request $request)
    {
        //
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
