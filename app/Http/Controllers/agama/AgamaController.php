<?php

namespace App\Http\Controllers\agama;

use App\Http\Controllers\Controller;
use App\Http\Requests\agama\AgamaDeleteRequest;
use App\Http\Requests\agama\AgamaStoreRequest;
use App\Http\Requests\agama\AgamaUpdateRequest;
use App\Models\Agama;
use Illuminate\Http\Request;

class AgamaController extends Controller
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

        $agama = Agama::where("agama", 'like', "%{$params['cari']}%")->get();

        $data = [
            'agama' => $agama,
            'params' => $params,
        ];
        return inertia()->render('master/agama', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgamaStoreRequest $request)
    {
        $agama = new Agama();
        $agama->agama = $request->agama;
        $agama->save();
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
    public function update(AgamaUpdateRequest $request, $id)
    {
        $agama = Agama::find($request->id);
        $agama->agama = $request->agama;
        $agama->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgamaDeleteRequest $id)
    {
        $agama = Agama::find($id)->first();
        $agama->delete();
    }
}
