<?php


namespace App\Traits;


trait AbstractPolicy
{
    protected $model;

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    public function read($guard): bool
    {
        return ($guard && $guard->hasRead($this->model));
    }

    public function write($guard): bool
    {
        return ($guard && $guard->hasWrite($this->model));
    }
}
