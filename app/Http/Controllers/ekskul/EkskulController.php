<?php

namespace App\Http\Controllers\ekskul;

use App\Http\Controllers\Controller;
use App\Http\Requests\ekskul\EkskulDeleteRequest;
use App\Http\Requests\ekskul\EkskulStoreRequest;
use App\Http\Requests\ekskul\EkskulUpdateRequest;
use App\Models\Ekskul;
use Illuminate\Http\Request;

class EkskulController extends Controller
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

        $ekskul = Ekskul::where(function($q) use ($params){
            $q->where("ekskul" ,'like',"%{$params['cari']}%");
        });
        $ekskul = $ekskul->latest()->paginate($params['show'])->withQueryString();

        $data = [
            "ekskul" => $ekskul,
            "params" => $params
        ];
        return inertia()->render('master/ekskul',$data);
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
    public function store(EkskulStoreRequest $request)
    {
        $ekskul = new Ekskul();
        $ekskul->ekskul = $request->ekskul;
        $ekskul->save(); 
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
    public function update(EkskulUpdateRequest $request, $id)
    {
        $ekskul = Ekskul::find($request->id);
        $ekskul->ekskul = $request->ekskul;
        $ekskul->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EkskulDeleteRequest $id)
    {
        $ekskul = Ekskul::find($id)->first();
        $ekskul->delete();
    }
}
