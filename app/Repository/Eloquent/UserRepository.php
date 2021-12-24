<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     *
     * fetch all registered users
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]
     */
    public function all(){
        return $this->model->all();
    }

    /**
     *
     * fetch all registered users
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]
     */
    public function paginate($perPage){
        return $this->model->paginate($perPage);
    }

    /**
     *
     * get the number of users that are registered
     *
     * @return mixed
     */
    public function allUserCount(){
        return $this->model->count();
    }


    /**
     *
     * get the number of users that are between two specified dates
     *
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public function fetchUserPerDate($startDate,$endDate){
        return $this->model->whereBetween('created_at', [$startDate, $endDate])->count();
    }
}
