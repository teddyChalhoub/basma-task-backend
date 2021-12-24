<?php
namespace  App\Repository;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface{
    /**
     * @param $id
     * @return Model|null
     */
    public function find($id) : ?Model;

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes) : Model;

    /**
     * @param array $attributes
     * @param $id
     * @return Model|null
     */
    public function update(array $attributes,$id) : ?Model;

    /**
     * @param $id
     * @return int|null
     */
    public function delete($id) : ?int;

}
