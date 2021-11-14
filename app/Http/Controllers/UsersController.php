<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UsersController extends Controller
{
    /**
     * Display all users
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        $users = User::latest();

        if($request->get('status') == 'archived') {
            $users = $users->onlyTrashed();
        }

        $users = $users->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show form for creating user
     * 
     * @return \Illuminate\Http\Response
     */
    public function create() 
    {
        return view('users.create');
    }

    /**
     * Store a newly created user
     * 
     * @param User $user
     * @param StoreUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, StoreUserRequest $request) 
    {
        //For demo purposes only. When creating user or inviting a user
        // you should create a generated random password and email it to the user
        $user->create(array_merge($request->validated(), [
            'password' => 'test' 
        ]));

        return redirect()->route('users.index')
            ->withSuccess(__('User created successfully.'));
    }

    /**
     * Show user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(User $user) 
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Edit user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) 
    {
        return view('users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update user data
     * 
     * @param User $user
     * @param UpdateUserRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request) 
    {
        $user->update($request->validated());

        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Delete user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) 
    {
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess(__('User deleted successfully.'));
    }

    /**
     *  Restore user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function restore($id) 
    {
        User::where('id', $id)->withTrashed()->restore();

        return redirect()->route('users.index', ['status' => 'archived'])
            ->withSuccess(__('User restored successfully.'));
    }

    /**
     * Force delete user data
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id) 
    {
        User::where('id', $id)->withTrashed()->forceDelete();

        return redirect()->route('users.index', ['status' => 'archived'])
            ->withSuccess(__('User force deleted successfully.'));
    }

    /**
     * Restore all archived users
     * 
     * @param User $user
     * 
     * @return \Illuminate\Http\Response
     */
    public function restoreAll() 
    {
        User::onlyTrashed()->restore();

        return redirect()->route('users.index')->withSuccess(__('All users restored successfully.'));
    }
}
