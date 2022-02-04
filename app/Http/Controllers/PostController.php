<?php

namespace App\Http\Controllers;

use App\Internal\Controller;
use App\Internal\Request;
use App\Internal\Response;
use App\Models\Category;
use App\Models\Post;

final class PostController extends Controller
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

        return $this->render('pages/posts/index', compact('posts'));
    }

    /**
     * @param Request $request 
     * 
     * @return string 
     */
    public function show(Request $request): string
    {
        $postsModel = new Post;
        $categoryModel = new Category;

        $post = $postsModel->getOne($request->getParam('id'));
        $post['categories'] = $categoryModel->getForPost($request->getParam('id'));

        return $this->render('pages/posts/show', compact('post'));
    }

    /**
     *  @return string
    */
    public function create(): string
    {
        $categoryModel = new Category;
        $categories = $categoryModel->getAll();

        return $this->render('pages/posts/create', compact('categories'));
    }

    /**
     * @param Request $request 
     * 
     * @return string 
     */
    public function store(Request $request, Response $response): string
    {
        $postModel = new Post;
        
        $postModel->save($request->getBody());

        app()->session->setFlash('success', 'New post successfully created');
        $response->redirect('/dashboard', 302);
    }

    /**
     * @param Request $request 
     * 
     * @return string 
     */
    public function edit(Request $request): string
    {
        $postModel = new Post;
        $categoryModel = new Category;

        $post = $postModel->getOne($request->getParam('id'));
        $categories = $categoryModel->getAll();

        return $this->render('pages/posts/edit', compact('post', 'categories'));
    }

    /**
     * @param Request $request 
     * 
     * @return string 
     */
    public function destroy(Request $request, Response $response): string
    {
        $postModel = new Post;
        $postModel->deleteById($request->getParam('id'));

        app()->session->setFlash('success', "Post was successfully deleted");
        $response->redirect('/dashboard', 302);
    }

    /**
     * TODO
     * 
     * @param Request $request 
     * 
     * @return string 
     */
    public function update(Request $request, Response $response): string
    {
        // $postModel = new Post;

        // $postModel->update([...['id' => $request->getParam('id')], ...$request->getBody()]);

        // app()->session->setFlash('success', 'Post was successfully updated');
        // $response->redirect('/dashboard', 302);
    }
}