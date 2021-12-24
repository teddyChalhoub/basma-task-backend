<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddAdminRequest;
use App\Models\Admin;
use App\Repository\AdminRepositoryInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @var AdminRepositoryInterface
     */
    private  $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository=$adminRepository;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){

        $credentials = request(['email', 'password']);

        if (!$token = auth('admins')->attempt($credentials)) {
            return response()->json([
                'success'=>false ,
                'message' => 'Wrong username or password'
            ], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AddAdminRequest $request) {


        try{
            $user = $this->adminRepository->create($request->all());

            if($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin successfully registered',
                    'user' => $user
                ], 201);
            }
        }catch(\Exception $error){
            return response()->json([
                'success' =>false,
                'message' => 'Some problem occurred',
            ], 500);
        }
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth("admins")->logout();

        return response()->json([
            'success' =>true,
            'message' => 'User successfully signed out'
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){

        return response()->json([
            'success'=>true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth("admins")->factory()->getTTL() * 60,
            'user' => auth("admins")->user()
        ]);
    }
}
