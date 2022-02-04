<?php

namespace App\Models;

use App\Internal\Model;

class Category extends Model
{
    /** 
     * Model-associated database table
     * 
     * @return string
    */
    public static function table(): string
    {
        return 'categories';
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
     * @return array
    */
    public function getAll(): array
    {
        $query = sprintf(
            "SELECT
                `categories`.`id`,
                `categories`.`name`
            FROM
                `categories`
        ");

        return $this->repository->select($query);
    }

    /**
     * @param int $post_id
     *  
     * @return array 
     */
    public function getForPost(int $post_id): array
    {
        $query = sprintf(
            "SELECT
                `categories`.`id`,
                `categories`.`name`
            FROM 
                `categories`
                LEFT JOIN `category_post` ON `categories`.`id` = `category_post`.`category_id`
            WHERE
                `category_post`.`post_id` = %d
        ", $post_id);

        return $this->repository->select($query);
    }
}