<?php

namespace App\Repository;


interface UserRepositoryInterface{

    /**
     * @return mixed
     */
    public function all();

    /**
     * @param $perPage
     * @return mixed
     */
    public function paginate($perPage);

    /**
     * @return mixed
     */
    public function allUserCount();

    /**
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public function fetchUserPerDate($startDate,$endDate);
}
