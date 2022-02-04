<?php

namespace App\Http\Controllers;

use App\Internal\Controller;
use App\Models\Category;
use App\Models\Post;

final class DashboardController extends Controller
{
    /**
     * @return string 
    */
    public function index(): string
    {
        $postsModel = new Post;
        $categoryModel = new Category;

        $posts = [];

        foreach ($postsModel->getAll() as $post) {
            $posts[] = [
                'id' => $post['id'],
                'title' => $post['title'],
                'preview' => (static function(string $content, int $length = 0): string {
                    if (! $length) return $content;

                    $preview = mb_substr($content, 0, $length, 'UTF-8');
                    $preview = array_splice(preg_split('/\s/', $preview), 0, -1);

                    return implode(' ', $preview) . '...';
                })($post['content'], 250),
                'published' => $post['created_at'],
                'categories' => $categoryModel->getForPost($post['id'])
            ];
        }

        return $this->render('pages/dashboard', compact('posts'));
    }
}