<?php

namespace App\Http\Controllers\murid;

use App\Http\Controllers\Controller;
use App\Http\Requests\murid\MuridStoreRequest;
use App\Models\Jurusan;
use App\Models\Murid;
use App\Models\User;
use Illuminate\Http\Request;

class MuridController extends Controller
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

        $user = User::with(["role","murid"])->whereHas("role", function($q){
            $q->where("nama","murid");
        });

        $user = $user->where(function($q) use($params){
            $q->where("nama","like","%{$params['cari']}%");
            $q->orWhere("alamat","like","%{$params['cari']}%");
            $q->orWhere("no_hp","like","%{$params['cari']}%");
        });
        $user = $user->latest()->paginate($params['show'])->withQueryString();

        $jurusan = Jurusan::with("kelas")->get();

        $data = [
            "params" => $params,
            "murid" => $user,
            "jurusan" => $jurusan,
        ];
        return inertia()->render("master/murid",$data);
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
    public function store(MuridStoreRequest $request)
    {
       $user = new User();
       $user->nama = $request->nama;
       $user->username = $request->username;
       $user->alamat = $request->alamat;
       $user->no_hp = $request->no_hp;
       $user->password = bcrypt($request->password);
       $user->save();

       $murid = new Murid();
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
        //
    }
}
