<?php

namespace App\Http\Controllers\rapor;

use App\Http\Controllers\Controller;
use App\Models\Murid;
use App\Models\Raport;
use App\Models\User;
use Illuminate\Http\Request;

class RaporController extends Controller
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

        $murid = Murid::with(["user"])->get();
        $raport = User::with(["murid.kelas", "murid.jurusan", "raport"])->has("raport")->where("nama", "like", "%{$params['cari']}%")->paginate($params["show"])->withQueryString();
        $data = [
            "params" => $params,
            "murid" => $murid,
            "raport" => $raport,
        ];
        return inertia()->render('laporan/rapor', $data);
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
        foreach ($request->data_raport as $key => $value) {
            $raport = new Raport();
            $raport->user_id = $request->user_id;
            $raport->pelajaran = $value["nama"];
            $raport->nilai = $value["nilai"];
            $raport->save();
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
        $user = User::find($id);
        $user->raport()->delete();
    }
}
