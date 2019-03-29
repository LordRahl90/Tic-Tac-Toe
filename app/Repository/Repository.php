<?php
/**
 * Created by PhpStorm.
 * User: alugbinabiodun
 * Date: 2019-03-29
 * Time: 14:20
 */

namespace App\Repository;


use App\Repository\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface
{

    private $app;
    protected $model;

    public function __construct(App $app)
    {
        $this->app=$app;
        $this->makeModel();
    }


    abstract function model();          //to be implemented by the calling class.


    public function makeModel(){
        $model=$this->app->make($this->model);
        if(!$model instanceof Model){
            throw new RepositoryException("Class {$this->model} must be an instance of Eloquent Model");
        }

        return $this->model=$model;
    }

    public function all($columns = array('*'))
    {
        return $this->model->get($columns);
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        return $this->model->paginate($perPage,$columns);
    }

    public function create(array $data)
    {
        $this->model->create($data);
    }

    public function update(array $data, $id,$attribute='id')
    {
        return $this->model->where($attribute,$id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id,$columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return $this->model->where($field,'=',$value)->get($columns);
    }

    public function findFirst($field,$value,$columns=array('*')){
        return $this->model->where($field,$value)->first($columns);
    }
}