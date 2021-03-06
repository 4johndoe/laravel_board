<?php

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRequest;
use App\Http\Requests\Admin\UpdateRequest;
use App\UseCases\Auth\RegisterService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $service;

    public function __construct(RegisterService $service)
    {
        $this->service = $service;
        $this->middleware('can:users-manage');
    }

    public function index(Request $request)
    {
        $query = User::orderByDesc('id');

        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('email'))) {
            $query->where('email', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('status'))) {
            $query->where('status', $value);
        }

        if (!empty($value = $request->get('role'))) {
            $query->where('role', $value);
        }

        $users = $query->paginate(20);

        $statuses = [
            User::STATUS_ACTIVE => 'Active',
            User::STATUS_WAIT => 'Wait'
        ];

        $roles = [
            User::ROLE_ADMIN => 'Admin',
            User::ROLE_USER => 'User'
        ];

        return view('admin.users.index', compact('users', 'statuses', 'roles'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(CreateRequest $request)
    {
        $user = User::new(
            $request['name'],
            $request['email']
        );

        return redirect()->route('admin.users.show', compact('user'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = [
            User::ROLE_USER => 'User',
            User::ROLE_ADMIN => 'Admin',
        ];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        $user->update($request->only(['name', 'email', 'status', 'role']));

        return redirect()->route('admin.users.show', $user);
    }

    public function destroy(User $user)
    {
        if (auth()->user()->id === $user->id) {
            return redirect()->route('admin.users.show', $user)
                ->with('info', 'You can not delete yourself');
        }

        $user->delete();

        return redirect()->route('admin.users.index');
    }

    public function verify(User $user)
    {
        try {
            $this->service->verify($user->id);
        } catch (\DomainException $e) {
            return redirect()->route('admin.users.show', $user)
                ->with('error', $e->getMessage());
        }

        return redirect()->route('admin.users.show', $user)
            ->with('info', 'Users successfully activated');
    }
}
