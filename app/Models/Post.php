<?php

namespace App\Models;

use App\Internal\Model;
use App\Internal\Repository;

class Post extends Model
{
    /** 
     * Model-associated database table
     * 
     * @return string
    */
    public static function table(): string
    {
        return 'posts';
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
     * @param array $attrs 
     * 
     * @return int 
     */
    public function save(array $attrs): int
    {
        $post_id = $this->repository->insert('posts', [
            'title' => $attrs['title'],
            'content' => $attrs['content']
        ]);

        return $this->repository->insert('category_post', [
            'category_id' => $attrs['category'],
            'post_id' => $post_id
        ]);
    }

    /**
     * TODO
     * 
     * @param array $attrs
     * 
     * @return int 
     */
    // public function update(array $attrs): int
    // {
    //     $post_id = $this->repository->update('posts', [
    //         'title' => $attrs['title'],
    //         'content' => $attrs['content']
    //     ], sprintf('id = %s', $attrs['id']));

    //     return $this->repository->insert('category_post', [
    //         'category_id' => $attrs['category'],
    //         'post_id' => $post_id
    //     ]);
    // }

    /** 
     * @return array
    */
    public function getAll(): array
    {
        $query = sprintf(
            "SELECT
                `posts`.`id`,
                `posts`.`title`,
                `posts`.`content`,
                `posts`.`created_at`
            FROM
                `posts`
            ORDER BY `posts`.`created_at` DESC
        ");

        return $this->repository->select($query);
    }

    /**
     * @param int $id 
     * 
     * @return array 
     */
    public function getOne(int $id): array
    {
        $query = sprintf(
            "SELECT
                `posts`.`id`,
                `posts`.`title`,
                `posts`.`content`,
                `posts`.`created_at`
            FROM
                `posts`
            WHERE `posts`.`id` = %d
        ", $id);

        return $this->repository->select($query, fetch: Repository::FETCH_ONE);
    }

    /**
     * @param int $id 
     * 
     * @return bool 
     */
    public function deleteById(int $id): bool
    {
        return $this->repository->delete('posts', sprintf("`posts`.`id` = %s", $id));
    }
}