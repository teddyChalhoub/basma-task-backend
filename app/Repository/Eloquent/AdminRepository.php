<?php

namespace App\Repository\Eloquent;


use App\Models\Admin;
use App\Repository\AdminRepositoryInterface;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface {

    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }

    /**
     *
     * fetch all admins
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]|mixed
     */
    public function all()
    {
        return $this->model->all();
    }
}
