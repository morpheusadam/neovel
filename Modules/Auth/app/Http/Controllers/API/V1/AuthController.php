<?php

namespace Modules\Auth\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\Auth\Models\API\V1\User;

class AuthController extends Controller
{
    public function index()
    {
        return response()->json(['message' => __('auth::messages.auth.index')]);
    }

    public function show($id)
    {
        return response()->json(['message' => __('auth::messages.auth.show'), 'id' => $id]);
    }

    public function register(Request $request)
    {
        $this->validateRequest($request);

        try {
            $user = $this->createUser($request);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return $this->respondWithDuplicateEntryError();
            }
            throw $e;
        }

        return $this->respondWithToken($user);
    }

    public function login(Request $request)
    {
        if (!$this->attemptLogin($request)) {
            return $this->respondWithUnauthorized();
        }

        $user = $this->getUserByEmail($request->email);

        $this->revokeExistingTokens($user);

        return $this->respondWithToken($user);
    }

    private function validateRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $this->respondWithValidationError($validator);
        }
    }

    private function createUser(Request $request)
    {
        return User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
    }

    private function attemptLogin(Request $request)
    {
        return auth()->attempt($request->only('email', 'password'));
    }

    private function getUserByEmail($email)
    {
        return User::where('email', $email)->firstOrFail();
    }

    private function revokeExistingTokens(User $user)
    {
        $user->tokens()->delete();
    }

    private function respondWithToken(User $user)
    {
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'auth::messages.auth.success',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    private function respondWithValidationError($validator)
    {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422)->throwResponse();
    }

    private function respondWithUnauthorized()
    {
        return response()->json([
            'status' => 'error',
            'message' => __('auth::messages.auth.failed')
        ], 401);
    }

    private function respondWithDuplicateEntryError()
    {
        return response()->json([
            'status' => 'error',
            'message' => __('auth::messages.auth.duplicate')

        ]);
    }
}
