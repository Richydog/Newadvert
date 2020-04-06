<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index(Request $request)
    {
     //   $user = User::orderBy('id', 'desc')->paginate(10);
        $query = User::orderBy('id');

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }
        if (!empty($value = $request->get('last_name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('email'))) {
            $query->where('email', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('role'))) {
            $query->where('role', $value);
        }

        $user = $query->paginate(10);
        $roles=User::rolesList();
        return view('admin.users.index', compact('user','roles'));
    }


    public function create()
    {
        return view('admin.users.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'=> ['required', 'string', 'max:255','regex:/^\d+$/s'],
            'role' => [ 'string', 'max:16'],
        ]);
        $user = User::create(array(
            'name' => $request['name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone'=>$request['phone'],
            'role' => $request['role'],
        ));
        return redirect()->route('users.show', $user);
    }

    public function show(User $user)
    {

        return view('admin.users.show', compact('user'));
    }


    public function edit(User $user)

    {
        $roles=User::rolesList();
        return view('admin.users.edit', compact('user','roles'));
    }


    public function update(Request $request, User $user)
    {
        $data = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users,id,' . $user->id,
            'phone'=> ['required', 'string', 'max:255','regex:/^\d+$/s'],
            'role' => [ 'string', 'max:16'],
        ]);
        $user->update($data);
        return view('admin.users.show', compact('user'));

    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect('admin.users.index');
    }





}
