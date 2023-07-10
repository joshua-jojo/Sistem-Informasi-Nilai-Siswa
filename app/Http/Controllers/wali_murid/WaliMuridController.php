<?php

namespace App\Http\Controllers\wali_murid;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        $user = User::whereHas("role", function ($q) {
            $q->where("nama", "wali murid");
        });
        $user = $user->where(function ($q) use ($params) {
            $q->where("nama","like","%{$params['cari']}%");
            $q->orWhere("alamat","like","%{$params['cari']}%");
            $q->orWhere("no_hp","like","%{$params['cari']}%");
        });
        $user = $user->paginate($params['show'])->withQueryString();

        $data = [
            'user' => $user,
            'params' => $params,
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
