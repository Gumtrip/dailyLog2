<?php

namespace App\Http\Controllers\Api\Admin\Admin;

use App\Http\Requests\Admin\BackendRequest as Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use App\Http\Resources\Admin\AdminResource;
class AdminController extends Controller
{
    const GUARD='admin';

    public function show( Request $request,Admin $admin)
    {
        return new AdminResource($admin);
    }


    public function me(Request $request){

        return response()->json([
            'code' => 20000,
            'data' => [
                'avatar' => "https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif",
                'introduction' => "I am a super administrator",
                'name' => "Super Admin",
                'roles'=>['admin']
            ]
        ]);
//        return new AdminResource($request->user(self::GUARD));
    }
}
