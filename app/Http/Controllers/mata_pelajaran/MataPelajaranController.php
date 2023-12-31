<?php

namespace App\Http\Controllers\mata_pelajaran;

use App\Http\Controllers\Controller;
use App\Http\Requests\mata_pelajaran\MataPelajaranDeleteRequest;
use App\Http\Requests\mata_pelajaran\MataPelajaranStoreRequest;
use App\Http\Requests\mata_pelajaran\MataPelajaranUpdateRequest;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
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

        $pelajaran = MataPelajaran::where(function($q) use ($params){
            $q->where("pelajaran" ,'like',"%{$params['cari']}%");
        });
        $pelajaran = $pelajaran->latest()->paginate($params['show'])->withQueryString();

        $data = [
            "pelajaran" => $pelajaran,
            "params" => $params
        ];
        return inertia()->render('master/mata_pelajaran',$data);
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
    public function store(MataPelajaranStoreRequest $request)
    {
        $pelajaran = new MataPelajaran();
        $pelajaran->pelajaran = $request->pelajaran;
        $pelajaran->save();
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
    public function update(MataPelajaranUpdateRequest $request, $id)
    {
        $pelajaran = MataPelajaran::find($request->id);
        $pelajaran->pelajaran = $request->pelajaran;
        $pelajaran->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MataPelajaranDeleteRequest $id)
    {
        $pelajaran = MataPelajaran::find($id)->first();
        $pelajaran->delete();
    }
}
