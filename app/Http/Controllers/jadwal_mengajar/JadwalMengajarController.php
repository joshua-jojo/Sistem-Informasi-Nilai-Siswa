<?php

namespace App\Http\Controllers\jadwal_mengajar;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
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

        $jadwal_mengajar = JadwalPelajaran::with(['mata_pelajaran','kelas'])->FilterByDate($params['dari'],$params['sampai'])->where("user_id",$user->id)->get();

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
