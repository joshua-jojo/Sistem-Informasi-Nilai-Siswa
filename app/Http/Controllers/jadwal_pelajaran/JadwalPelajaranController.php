<?php

namespace App\Http\Controllers\jadwal_pelajaran;

use App\Http\Controllers\Controller;
use App\Http\Requests\jadwal_pelajaran\JadwalPelajaranDeleteRequests;
use App\Http\Requests\jadwal_pelajaran\JadwalPelajaranStoreRequests;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalPelajaranController extends Controller
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

        $jadwal_pelajaran = JadwalPelajaran::with("user.guru", "kelas", "mata_pelajaran");
        $jadwal_pelajaran = $jadwal_pelajaran->where(function($q) use($params){
            $q->where("tanggal","like","%{$params['cari']}%");
            $q->orWhere("mulai","like","%{$params['cari']}%");
            $q->orWhere("selesai","like","%{$params['cari']}%");
            $q->orWhereHas("user.guru",function($guru) use ($params){
                $guru->where("nip","like","%{$params['cari']}%");
            });
            $q->orWhereHas("kelas",function($kelas) use ($params){
                $kelas->where("kelas","like","%{$params['cari']}%");
            });
            $q->orWhereHas("mata_pelajaran",function($pelajaran) use ($params){
                $pelajaran->where("pelajaran","like","%{$params['cari']}%");
            });
        });
        $jadwal_pelajaran = $jadwal_pelajaran->orderBy("tanggal","asc");
        $jadwal_pelajaran = $jadwal_pelajaran->paginate($params['show'])->withQueryString();

        $guru = User::where("role_id", 3)->get();
        $kelas = Kelas::orderBy("kelas", "asc")->get();
        $mata_pelajaran = MataPelajaran::orderBy("pelajaran", "asc")->get();

        $data = [
            'params' => $params,
            'jadwal_pelajaran' => $jadwal_pelajaran,
            'guru' => $guru,
            'kelas' => $kelas,
            'mata_pelajaran' => $mata_pelajaran,
        ];

        return inertia()->render("master/jadwal_pelajaran", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JadwalPelajaranStoreRequests $request)
    {
        foreach ($request->jadwal as $key => $value) {
            $jadwal = JadwalPelajaran::where(function ($q) use ($value) {
                $q->where("tanggal", $value['tanggal']);
                $q->where("kelas_id", $value['kelas_id']);
                $q->whereTime("selesai", ">", $value['mulai']);
            })->first();

            if (!empty($jadwal)) {
                return redirect()->back()->withErrors([
                    "jadwal{$value['tanggal']}{$value['mulai']}{$value['selesai']}" => "Jadwal sudah dipakai"
                ]);
            }
        }
        foreach ($request->jadwal as $key => $value) {
            $jadwal_pelajaran = new JadwalPelajaran();
            $jadwal_pelajaran->user_id = $request->guru_id;
            $jadwal_pelajaran->kelas_id = $value['kelas_id'];
            $jadwal_pelajaran->tanggal = $value['tanggal'];
            $jadwal_pelajaran->mata_pelajaran_id = $value['mata_pelajaran_id'];
            $jadwal_pelajaran->mulai = $value['mulai'];
            $jadwal_pelajaran->selesai = $value['selesai'];
            $jadwal_pelajaran->save();
        }
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
    public function destroy(JadwalPelajaranDeleteRequests $id)
    {
        $jadwal = JadwalPelajaran::find($id)->first();
        $jadwal->delete();
    }
}
