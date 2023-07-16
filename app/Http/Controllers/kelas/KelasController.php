<?php

namespace App\Http\Controllers\kelas;

use App\Http\Controllers\Controller;
use App\Http\Requests\kelas\KelasStoreRequest;
use App\Http\Requests\kelas\KelasUpdateRequest;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
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

        $kelas = Kelas::where(function($q) use($params){
            $q->where("kelas","like","%{$params['cari']}%");
        });
        $kelas = $kelas->latest();
        $kelas = $kelas->paginate($params['show'])->withQueryString();
        $data = [
            "kelas" => $kelas,
            'params' => $params,
        ];
        return inertia()->render('master/kelas',$data);
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
    public function store(KelasStoreRequest $request)
    {
        $kelas = new Kelas();
        $kelas->kelas = $request->kelas;
        $kelas->save();
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
    public function update(KelasUpdateRequest $request, $id)
    {
        $kelas = Kelas::find($request->id);
        $kelas->kelas = $request->kelas;
        $kelas->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd($id);
    }
}
