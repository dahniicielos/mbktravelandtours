<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\UserEditFormRequest;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Role;

class UsersController extends Controller
{
    public function index()
	{
	    $users = User::all();
	    return view('admin.users', compact('users'));
	}


	public function update($id, UserEditFormRequest $request)
	{
	    $user = User::whereId($id)->firstOrFail();
	    $user->name = $request->get('name');
	    $user->email = $request->get('email');
	    $password = $request->get('password');
	    if($password != "") {
	        $user->password = Hash::make($password);
	    }
	    $user->save();

	    $userRole = Role::where('name', '=', $request->get('role'))->pluck('id');
		$user->roles()->attach($userRole);

	    //$user->roles()->sync($request->get('role'));

	    return redirect(action('Admin\UsersController@edit', $user->id))->with('status', 'The user has been updated!');
	}

	public function edit($id)
	{
	    $user = User::whereId($id)->firstOrFail();
	    $roles = Role::all();
	    $selectedRoles = $user->roles()->pluck('name')->toArray();
	    return view('backend.users.edit', compact('user', 'roles', 'selectedRoles'));
	}

}
