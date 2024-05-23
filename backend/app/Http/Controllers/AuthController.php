<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        return User::create([
            'role' => $request->input('role'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
    }
    public function login(Request $request)
    {
        // То же самое, что и:
        // Auth::attempt([
        //     'email' => $request->input('email'),
        //     'password' => $request->input('password'),
        // ]);
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'success' => false,
                'error' => 'Ошибочные данные'
            ], Response::HTTP_UNAUTHORIZED); // 401
        }

        $user = Auth::user();

        $token = $user->createToken('token')->plainTextToken;
        // Примечание: великий гугл планирует ограничить кукисы
        $cookie = cookie('jwt', $token, 60 * 24);

        return response([
            'success' => true,
            'user' => $user
        ])->withCookie($cookie);
    }
    public function user()
    {
        return response([
            'success' => true,
            'user' => Auth::user()
        ]);
    }
}
