<?php

namespace App\Http\Controllers\jadwal_pelajaran;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
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

        $jadwal_pelajaran = JadwalPelajaran::latest()->paginate($params['show'])->withQueryString();

        $data = [
            'params' => $params,
            'jadwal_pelajaran' => $jadwal_pelajaran,
        ];

        return inertia()->render("master/jadwal_pelajaran",$data);
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
