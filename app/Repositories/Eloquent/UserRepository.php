<?php

namespace App\Repositories\Eloquent;
use App\User;
use App\Repositories\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return User::class;
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findLimitOrderBy($attribute, $limit, $columns = array('*')) {
        return $this->model->take($limit)->orderBy($attribute,'des')->get($columns);
    }

    public function findLimitByView($attribute, $value, $limit, $attOrder, $columns = array('*')) {
        return $this->model->where($attribute, '=', $value)->take($limit)->orderBy($attOrder,'des')->get($columns);
    }

    public function findWherePaginate($where, $paginate,$columns = ['*'], $or = false)
    {
        $model = $this->model;
        foreach ($where as $field => $value) {
            if ($value instanceof \Closure) {
                $model = (!$or)
                    ? $model->where($value)
                    : $model->orWhere($value);
            } elseif (is_array($value)) {
                if (count($value) === 3) {
                    list($field, $operator, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, $operator, $search)
                        : $model->orWhere($field, $operator, $search);
                } elseif (count($value) === 2) {
                    list($field, $search) = $value;
                    $model = (!$or)
                        ? $model->where($field, '=', $search)
                        : $model->orWhere($field, '=', $search);
                }
            } else {
                $model = (!$or)
                    ? $model->where($field, '=', $value)
                    : $model->orWhere($field, '=', $value);
            }
        }

        return $model->orderBy('created_at','des')->paginate($paginate);
    }
}