<?php

namespace App\Services;

use App\Http\Requests\RegisterAuthRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function register(RegisterAuthRequest $request)
    {
        $request->validated();

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cpf' => $request->cpf,
            'groups' => $request->groups ?? 'client',
        ]);
    }

    public function findUser(int $id)
    {
        try {
            return User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function updateUser(RegisterAuthRequest $request, User $user)
    {
        $request->validated();
        
        $user->update($request->all());

        return $user;
    }

    public function deleteUser(User $user)
    {
        $user->delete();

        return $user;
    }
}
