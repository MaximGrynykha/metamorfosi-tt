<?php

namespace App\Internal;

abstract class Model
{
    /**
     * @var Repository
     */
    protected readonly Repository $repository;

    /**
     * @var Validator
     */
    protected readonly Validator $validator;

    /**
     *  @return void
    */
    public function __construct()
    {    
        $this->repository = new Repository(app()->database);
        $this->validator = new Validator($this->repository);
    }

    /**
     * @param array $data 
     * 
     * @return void 
     */
    public function load(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /** 
     * @return bool
    */
    public function validate(): bool
    {
        return $this->validator->validate($this);
    }

    /** 
     * List of fillable attributes
     * 
     * @return array
    */
    // abstract public function attributes(): array;

    /** 
     * Human readable model properties
     * 
     * @return array
    */
    // abstract public function labels(): array;

    /** 
     * Rules for model validation
     * 
     * @return array
    */
    // abstract public function rules(): array;

    /** 
     * Model-associated database table
     * 
     * @return string
    */
    // abstract public static function table(): string;

    /** 
     * Model associated database table's primary key 
     * 
     * @return string
    */
    // abstract public static function primary(): string;
}