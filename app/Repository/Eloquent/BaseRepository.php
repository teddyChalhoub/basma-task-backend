<?php
namespace  App\Repository\Eloquent;

use App\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface{

    /**
     * @var Model
     */
    protected $model;

    /**
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @return Model|null
     */
    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @param $id
     * @return Model|null
     */
    public function update(array $attributes,$id) : ?Model
    {
        $updated =  $this->find($id);
        $isUpdated = $updated->update($attributes);

        if($isUpdated){
            return $updated;
        }
        return null;
    }

    /**
     * @param $id
     * @return int|null
     */
    public function delete($id) : ?int
    {
        $deleted =  $this->find($id);
        if($deleted->delete()){
            return $id;
        }

        return null;
    }

}
