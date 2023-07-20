<?php

namespace App\Http\Controllers\wali_murid;

use App\Http\Controllers\Controller;
use App\Http\Requests\wali_murid\WaliMuridDeleteRequest;
use App\Http\Requests\wali_murid\WaliMuridStoreRequest;
use App\Http\Requests\wali_murid\WaliMuridUpdateRequest;
use App\Models\Murid;
use App\Models\User;
use App\Models\WaliMurid;
use Illuminate\Http\Request;

class WaliMuridController extends Controller
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
        $user = User::with(['wali_murid.murid'])->whereHas("role", function ($q) {
            $q->where("nama", "wali murid");
        });
        $user = $user->where(function ($q) use ($params) {
            $q->where("nama","like","%{$params['cari']}%");
            $q->orWhere("alamat","like","%{$params['cari']}%");
            $q->orWhere("no_hp","like","%{$params['cari']}%");
            $q->orWhereHas("wali_murid.murid",function ($m) use ($params){
                $m->where("nama","like","%{$params['cari']}%");
            });
        });
        $user = $user->paginate($params['show'])->withQueryString();

        $murid = User::whereHas("role",function($q){
            $q->where("id",4);
        })->get(['id',"nama"]);

        $data = [
            'user' => $user,
            'params' => $params,
            'murid' => $murid,
        ];
        return inertia()->render('master/wali_murid', $data);
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
    public function store(WaliMuridStoreRequest $request)
    {
        $user = new User();
        $user->nama = $request->nama;
        $user->no_hp = $request->no_hp;
        $user->username = $request->username;
        $user->role_id = 5;
        $user->alamat = $request->alamat;
        $user->password = bcrypt($request->password);
        $user->save();

        $wali_murid = new WaliMurid();
        $wali_murid->user_id = $user->id;
        $wali_murid->murid_id = $request->murid_id;
        $wali_murid->save();
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
    public function update(WaliMuridUpdateRequest $request, $id)
    {
        $user = User::find($request->id);
        $user->nama = $request->nama;
        $user->alamat = $request->alamat;

        if($request->username != $user->username){
            $request->validate([
                'username' => "unique:users,username"
            ]);
            $user->username = $request->username;
        }

        if($request->no_hp != $user->no_hp){
            $request->validate([
                'no_hp' => "unique:users,no_hp"
            ]);
            $user->no_hp = $request->no_hp;
        }
        
        if(!empty($request->password)){
            $request->validate([
                'password' => "confirmed"
            ]);
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $wali_murid = WaliMurid::where("user_id",$request->id)->first();
        $wali_murid->murid_id = $request->murid_id;
        $wali_murid->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(WaliMuridDeleteRequest $id)
    {
        $user = User::find($id)->first();
        $user->wali_murid()->delete();
        $user->delete();
        
    }
}
