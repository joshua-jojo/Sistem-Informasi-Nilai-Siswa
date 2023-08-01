<?php

namespace App\Http\Controllers\nilai_akademik;

use App\Http\Controllers\Controller;
use App\Models\NilaiTugasUlangan;
use Illuminate\Http\Request;

class NilaiAkademikController extends Controller
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

        $user = $request->user();
        $is_guru = $user->role_id == 3;

        $nilai_akademik = NilaiTugasUlangan::with(['murid.murid.kelas', 'tugas_ulangan.jadwal_pelajaran.user']);

        if ($is_guru) {
            $id_guru = $user->id;
            $nilai_akademik = $nilai_akademik->whereHas('tugas_ulangan.jadwal_pelajaran.user', function ($q) use ($id_guru) {
                $q->where("id", $id_guru);
            });
        }

        $nilai_akademik = $nilai_akademik->where(function ($q) use ($params) {
            $q->whereHas('murid.murid', function ($data_user) use ($params) {
                $data_user->where("nama", "like", "%{$params['cari']}%");
            });
            $q->orWhereHas('murid.murid.kelas', function ($data_kelas) use ($params) {
                $data_kelas->where("kelas", "like", "%{$params['cari']}%");
            });
            $q->orWhereHas('tugas_ulangan.jadwal_pelajaran', function ($data_kelas) use ($params) {
                $data_kelas->where("tanggal", "like", "%{$params['cari']}%");
            });
            $q->orWhereHas('tugas_ulangan.jadwal_pelajaran.user', function ($data_kelas) use ($params) {
                $data_kelas->where("nama", "like", "%{$params['cari']}%");
            });
            $q->orWhere("nilai", "like", "%{$params['cari']}%");
        });

        $nilai_akademik = $nilai_akademik->paginate($request['show'])->withQueryString();

        $data = [
            "params" => $params,
            "nilai_akademik" => $nilai_akademik,
        ];
        return inertia()->render('laporan/nilai_akademik', $data);
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
