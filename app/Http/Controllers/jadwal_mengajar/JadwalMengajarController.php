<?php

namespace App\Http\Controllers\jadwal_mengajar;

use App\Http\Controllers\Controller;
use App\Http\Requests\jadwal_mengajar\JadwalMengajarTugasRequests;
use App\Models\Absensi;
use App\Models\JadwalPelajaran;
use App\Models\TugasUlangan;
use Illuminate\Http\Request;

class JadwalMengajarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'dari' => !empty($request->dari) ? $request->dari : date("Y-m-d"),
            'sampai' => !empty($request->sampai) ? $request->sampai : date("Y-m-d"),
        ];

        $user = auth()->user();

        $jadwal_mengajar = JadwalPelajaran::with(['mata_pelajaran','kelas.murid.user',"absensi.user","tugas"])->FilterByDate($params['dari'],$params['sampai'])->where("user_id",$user->id)->get();

        $data = [
            "params" => $params,
            "jadwal_mengajar" => $jadwal_mengajar,
        ];
        return inertia()->render("laporan/jadwal_mengajar", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = $request->status;
        $jadwal_id = $request->id;

        if(!$status){
            foreach ($request->murid as $key => $value) {
                $absensi = new Absensi();
                $absensi->jadwal_pelajaran_id = $jadwal_id;
                $absensi->user_id = $value['user']['id'];
                $absensi->status = !empty($value['status']) ? $value['status'] : "-";
                $absensi->save();
            }
        }

        $absensi = Absensi::where("jadwal_pelajaran_id",$jadwal_id)->get();
        $absensi = $absensi->each(function($q) use ($request){
            foreach ($request->murid as $key => $value) {
                if($q->id == $value['id']){
                    $q->status = $value['status'];
                    break;
                }
            }
            $q->save();
        });
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
    public function destroy($id)
    {
        //
    }

    function tugas(JadwalMengajarTugasRequests $request){
        $tugas = new TugasUlangan();
        $tugas->kelas_id = $request->kelas_id;
        $tugas->jadwal_pelajaran_id = $request->jadwal_pelajaran_id;
        $tugas->judul = $request->judul;
        $tugas->mulai = $request->mulai;
        $tugas->selesai = $request->selesai;
        $tugas->save();
    }
}
