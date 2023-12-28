<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::allows('owner')) {
            $user=User::all();
            return view('users.show_users',compact('user'));
        } else
            abort(403, 'Unauthorized');
    }

    public function create()
    {
        $user=User::all();
        if (Gate::allows('owner')) {
            return view('users.add',compact('user'));
        } else {
            abort(403, 'Unauthorized');
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'admin' => 'required|in:0,1', // Make sure 'admin' is either 0 or 1
            'Status' => 'required|in:مفعل,غير مفعل', // Add validation for 'Status'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        $user->admin = $request->input('admin');
        $user->save();
        return redirect()->route('users.index')->with('success', 'تم اضافة المستخدم بنجاح');
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|same:confirm-password',
            'admin' => 'required|required|in:0,1',
        ]);

        $input = $request->except('_token', '_method', 'confirm-password');

        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        $user = User::find($id);
        $user->update($input);
        $user->admin = $request->input('admin');
        $user->save();
        return redirect()->route('users.index')->with('success', 'تم تحديث معلومات المستخدم بنجاح');

    }
    public function destroy(User $user)
    {
       $user->delete();
        return redirect('/users');
    }
}
