<?php

namespace App\Http\Controllers;

use App\Models\permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:80|unique:permissions'
        ]);

        Permission::create($request->all());

        return response()->json([
            'status' => true,
            'Message' => 'Permission added successfully!'
        ], 200);
    }
	
	/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:80|unique:permissions,name,'.$id
        ]);

        $permission = Permission::find($id);
        $permission->update($request->all());

        return response()->json([
            'status' => true,
            'Message' => 'Permission updated successfully!'
        ], 200);
    }
	
}
