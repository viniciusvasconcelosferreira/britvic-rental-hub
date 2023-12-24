<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAuthRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::paginate(8);
        return UserResource::collection($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterAuthRequest $request)
    {
        $user = $this->userService->register($request);
        $userResource = new UserResource($user);
        return $userResource->additional([
            'message' => 'User created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = $this->userService->findUser($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegisterAuthRequest $request, int $id)
    {
        $userExist = $this->userService->findUser($id);

        if (!$userExist) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user = $this->userService->updateUser($request, $userExist);

        $userResource = new UserResource($user);

        return $userResource->additional([
            'message' => 'User updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $userExist = $this->userService->findUser($id);

        if (!$userExist) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user = $this->userService->deleteUser($userExist);

        $userResource = new UserResource($user);

        return $userResource->additional([
            'message' => 'User deleted successfully'
        ]);
    }
}
