<?php

namespace App\Models;

use App\Internal\Model;
use App\Internal\Repository;

class User extends Model
{
    /** 
     * Model-associated database table
     * 
     * @return string
    */
    public static function table(): string
    {
        return 'users';
    }

    /** 
     * Model associated database table's primary key 
     * 
     * @return string
    */
    public static function primary(): string
    {
        return 'id';
    }

    /** 
     * Rules for model validation
     * 
     * @return array
    */
    public function rules(): array
    {
        return [];
    }

    /**
     * @param string $name 
     * 
     * @return array 
     */
    public function getByName(string $name): array
    {
        $query = sprintf(
            "SELECT
                `users`.`id`,
                `users`.`name`,
                `users`.`password`
            FROM
                `users`
            WHERE `users`.`name` = '%s'
        ", $name);

        return $this->repository->select($query, fetch: Repository::FETCH_ONE);
    }

    /**
     * @param int $id 
     * 
     * @return array 
     */
    public function getById(int $id): array
    {
        $query = sprintf(
            "SELECT
                `users`.`id`,
                `users`.`name`,
                `users`.`password`
            FROM
                `users`
            WHERE `users`.`id` = %d
        ", $id);

        return $this->repository->select($query, fetch: Repository::FETCH_ONE);
    }
}