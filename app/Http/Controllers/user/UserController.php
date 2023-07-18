<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\DeleteUserRequest;
use App\Http\Requests\user\StoreUserRequest;
use App\Http\Requests\user\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = [
            'search' => $request->search ? $request->search : '',
            'show' => $request->show ? $request->show : 5,
        ];

        $role = Role::all();

        $user = User::with('role');
        $user = $user->where(function($q) use($params){
            $q->where("nama","like","%{$params['search']}%");
            $q->orWhere("username","like","%{$params['search']}%");
            $q->orWhere("alamat","like","%{$params['search']}%");
            $q->orWhere("no_hp","like","%{$params['search']}%");
            $q->orWhereHas("role",function($role) use($params){
                $role->where("nama","like","%{$params['search']}%");
            });
        });
        $user = $user->latest()->paginate($params['show'])->withQueryString();

        $data = [
            'role' => $role,
            'user' => $user,
            'params' => $params
        ];
        return inertia()->render('master/user',$data);
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
    public function store(StoreUserRequest $request)
    {
        $user = new User();
        $user->nama = $request->nama;
        $user->no_hp = $request->no_hp;
        $user->username = $request->username;
        $user->role_id = $request->role_id;
        $user->alamat = $request->alamat;
        $user->password = bcrypt($request->password);
        $user->save();
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
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::find($id);
        $user->nama = $request->nama;
        $user->alamat = $request->alamat;
        $user->no_hp = $request->no_hp;
        $user->username = $request->username;
        $user->role_id = $request->role_id;
        if(!empty($request->password)){
            $user->password = bcrypt($request->password);
        }
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteUserRequest $id)
    {
        $user = User::find($id)->first();
        $user->delete();
    }
}
