<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
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
            'name' => 'required|string|max:80|unique:roles',
            // 'permissions.*' => 'required',
        ]);

        $role = Role::create($request->all());
        if($request->permissions){
            $role->permissions()->attach($request->permissions);
        }

        return response()->json([
            'status' => true,
            'Message' => 'Role added successfully!'
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
            'name' => 'required|string|max:80|unique:roles,name,'.$id
        ]);

        $role = Role::find($id);
        $role->update($request->all());
        $role->permissions()->sync($request->permissions);

        return response()->json([
            'status' => true,
            'Message' => 'Role updated successfully!'
        ], 200);
    }
}
