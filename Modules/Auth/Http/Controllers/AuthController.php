<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Resources\UserResource;
use Modules\Auth\UseCases\LoginUseCase;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store', 'refresh']]);
    }

    public function store(Request $request): JsonResource
    {
        $credentials = request(['email', 'password']);

        $token = LoginUseCase::perform($credentials);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     */
    public function me(): UserResource
    {
        return new UserResource(auth()->user());
    }

    /**
     * Refresh a token.
     */
    public function refresh(): JsonResource
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     */
    protected function respondWithToken(string $token): JsonResource
    {
        return new JsonResource([
            'access_token' => $token,
            'token_type' => 'bearer',
            // @phpstan-ignore-next-line
            'expires_in' => auth()->factory()->getTTL() * 60 * 1000,
        ]);
    }
}
