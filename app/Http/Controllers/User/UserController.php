<?php

namespace App\Http\Controllers\User;

use App\Helpers\Message;
use App\Helpers\MyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserController extends Controller
{
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $user = User::create(array_merge($data, [
                'id_user' => MyHelper::generateId(),
                'password' => bcrypt($data['password']),
            ]));

            DB::commit();
            return response()->json(Message::formatResponse(true, 'User registered successfully', [
                'id_user' => $user->id_user
            ]));
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(Message::formatResponse(false, 'Failed to register user', $e->getMessage()));
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('username', 'password');

            if (!Auth::attempt($credentials)) {
                throw new \Exception('Invalid username or password');
            }

            $user = Auth::user();

            $data = [
                'user' => $user,
                'token' => $user->createToken('api-token')->plainTextToken,
            ];

            return response()->json(Message::formatResponse(true, 'Login successful', $data));
        } catch (\Throwable $e) {
            return response()->json(Message::formatResponse(false, 'Login failed', $e->getMessage()));
        }
    }
}
