<?php

namespace App\Http\Controllers\jurusan;

use App\Http\Controllers\Controller;
use App\Http\Requests\jurusan\JurusanDeleteRequest;
use App\Http\Requests\jurusan\JurusanStoreRequest;
use App\Http\Requests\jurusan\JurusanUpdateRequest;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
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

        $kelas = Jurusan::where(function($q) use($params){
            $q->where("jurusan","like","%{$params['cari']}%");
        });
        $kelas = $kelas->latest();
        $kelas = $kelas->paginate($params['show'])->withQueryString();

        $data = [
            "jurusan" => $kelas,
            'params' => $params,
        ];
        return inertia()->render('master/jurusan',$data);
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
    public function store(JurusanStoreRequest $request)
    {
        $jurusan = new Jurusan();
        $jurusan->jurusan = $request->jurusan;
        $jurusan->save();
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
    public function update(JurusanUpdateRequest $request, $id)
    {
        $jurusan = Jurusan::find($request->id);
        $jurusan->jurusan = $request->jurusan;
        $jurusan->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(JurusanDeleteRequest $id)
    {
        $jurusan = Jurusan::with("kelas")->find($id)->first();
        
        foreach ($jurusan->kelas as $key => $value) {
            $value->delete();
        }

        $jurusan->delete();
    }
}
