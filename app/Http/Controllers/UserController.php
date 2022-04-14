<?php

namespace App\Http\Controllers;

use View;
use App\Models\User;
use App\Datatables\UserDatatable;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{

    /**
     * Share the some variables with the view
     */
    public function __construct()
    {
        $modelName = 'User';
        $route = 'users';
        $options = [
            'Admin' => 'Admin',
            'Cashier' => 'Cashier',
            'Kitchen Staff' => 'Kitchen Staff',
            'Waiter' => 'Waiter',
        ];
        View::share(compact('modelName', 'route', 'options'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $table = new UserDatatable($users);

        return view('crud.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        $validatedRequest = $request->validated();
        unset($validatedRequest['role']);
        $validatedRequest['password'] = bcrypt($validatedRequest['password']);

        $user = User::create($validatedRequest);
        $user->syncRoles($request->role);

        return redirect()->route('users.index')
            ->with('success_message', 'User added successfully');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if ($this->isSuperAdmin($user->id)) {
            return $this->superAdminRedirect();
        }

        $id = $user->id;
        $user->role = $user->getRoleNames()->first();
        return view('users.edit', compact('user', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($this->isSuperAdmin($user->id)) {
            return $this->superAdminRedirect();
        }

        $validatedRequest = $request->validated();
        unset($validatedRequest['role']);

        if (isset($validatedRequest['password'])) {
            $validatedRequest['password'] = bcrypt($validatedRequest['password']);
        }

        $user->update($validatedRequest);
        $user->syncRoles($request->role);

        return redirect()->route('users.index')
            ->with('success_message', 'User modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($this->isSuperAdmin($user->id)) {
            return $this->superAdminRedirect();
        }

        $user->delete();
        return redirect()->route('users.index')
            ->with('success_message', 'User deleted successfully');
    }

    /**
     * Check if the user is a super admin
     *
     * @param int $id
     * @return bool
     */
    private function isSuperAdmin(int $id)
    {
        return $id == 1;
    }

    /**
     * Redirect with an error message
     *
     * @return \Illuminate\Http\Response
     */
    private function superAdminRedirect()
    {
        return redirect()->route('users.index')
            ->with('error_message', 'You cannot modify the Super Admin');
    }
}
