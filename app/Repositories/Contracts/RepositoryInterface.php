<?php
namespace App\Repositories\Contracts;

interface RepositoryInterface {
 
    public function all($columns = array('*'));
 
    public function paginate($perPage = 15, $columns = array('*'));
 
    public function create(array $data);
 
    public function update(array $data, $id);
 
    public function delete($id);
 
    public function find($id, $columns = array('*'));
 
    public function findBy($field, $value, $columns = array('*'));

    public function findLimitBy($attribute, $value, $limit,$attOrder, $columns = array('*'));
    
    public function findLimitLikeBy($attribute, $value, $limit, $attOrder, $columns = array('*'));

    public function findAllBy($field, $value, $columns = array('*'));

    public function findWhere($where, $columns = array('*'));

    public function findWhereLimit($where, $limit,$columns = ['*'], $or = false);

    public function count();

}