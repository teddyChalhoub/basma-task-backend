<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserRequest;
use App\Repository\UserRepositoryInterface;
use http\Env\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    /**
     * @var UserRepositoryInterface
     */
    private  $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource and pagination option.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (isset($request['per_page']) && $request['per_page'] != 0) {
            $users = $this->userRepository->paginate($request['per_page']);
        } else {
            $users = $this->userRepository->all();
        }

        if ($users->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'User fetched successfully',
                'data' => $users
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No user founds',
                'data' => $users
            ], 404);
        }
    }

    /**
     * filter user data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterUserData(Request $request)
    {
        $inputs = $request->all();

        $patternEmail = "/" . $inputs['email'] . "/i";
        $patternName = "/" . $inputs['name'] . "/i";

        $users = $this->userRepository->all();
        $users = $users->toArray();

        $filteredUsers = array_map(function ($user) use ($inputs, $patternName, $patternEmail) {
            if (!empty($inputs['email']) && preg_match($patternEmail, $user['email'])) {
                return $user;
            }
            if (!empty($inputs['name']) && preg_match($patternName, $user['name'])) {
                return $user;
            }
            if (!empty($inputs['id']) && $user['id'] == $inputs['id']) {
                return $user;
            }
            return null;
        }, $users);

        $array = [];
        foreach ($filteredUsers as $filter) {
            if ($filter) {
                array_push($array, $filter);
            }
        }

        $filteredData = collect($array);


        if ($filteredData->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'Users fetched successfully',
                'data' => $filteredData
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No user found',
                'data' => $filteredData
            ], 404);
        }
    }

    /**
     * filter user data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function averageUserRegisterPerDate(Request $request)
    {

        $users_nb = $this->userRepository->allUserCount();

        $start_date = Carbon::parse($request['start_date']);
        $end_date = Carbon::parse($request['end_date']);

        if ($users_nb !== 0) {
            $users_nb_per_date = $this->userRepository->fetchUserPerDate($start_date, $end_date);
            $average_registered = ($users_nb_per_date / $users_nb) * 100;
        } else {
            $average_registered = 0;
        }

        return response()->json([
            "success" => true,
            "message" => "Average of student registered in percentage",
            "average_registered" => $average_registered,
            "total_users" => $users_nb
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTotalUserCount()
    {
        $users_nb = $this->userRepository->allUserCount();

        return response()->json([
            "success" => true,
            "message" => "Successfully retrieved registered students",
            "total_users" => $users_nb
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *s
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddUserRequest $request)
    {
        try {
            $user = $this->userRepository->create($request->all());

            if ($user) {
                return response()->json([
                    'success' => true,
                    'message' => 'User successfully registered',
                    'user' => $user
                ]);
            }
        } catch (\Exception $error) {
            return response()->json([
                'success' => false,
                'message' => 'Some problem occurred',
            ], 500);
        }
        return null;
    }

    //    /**
    //     * Display the specified resource.
    //     *
    //     * @param  int  $id
    //     * @return \Illuminate\Http\Response
    //     */
    //    public function show($id)
    //    {
    //        //
    //    }
    //
    //    /**
    //     * Update the specified resource in storage.
    //     *
    //     * @param  \Illuminate\Http\Request  $request
    //     * @param  int  $id
    //     * @return \Illuminate\Http\Response
    //     */
    //    public function update(Request $request, $id)
    //    {
    //        //
    //    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = $this->userRepository->delete($id);

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted registered',
                'user' => $user
            ]);
        }
    }
}
