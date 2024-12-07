<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Queries\FuzzyFilter;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new FuzzyFilter(
                    'id', 'username', 'chat', 'gender','age', 'location', 'viewers', 'status', 'new', 'likes', 'followers'
                )),
            ])
            ->allowedSorts(['id', 'name', 'email'])
            ->defaultSort('id')
            ->with(['roles'])
            ->paginate($request->perPage ?? 10)
        ->withQueryString();

        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create', [
            'roles' => Role::query()->pluck('name', 'id'),
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $user->assignRole($data['role']);

        return redirect()->route('users.index')->with(['message' => 'Successfully created user']);
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => $user->load(['roles']),
            'roles' => Role::query()->pluck('name', 'id'),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password'], $data['confirm_password']);
        }

        $user->update($data);
        $user->assignRole($data['role']);

        return redirect()->route('users.index');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id !== 1) {
            $user->delete();
        }

        return redirect()->back();
    }
}
