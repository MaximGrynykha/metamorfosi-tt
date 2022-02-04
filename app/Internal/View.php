<?php

namespace App\Internal;

class View
{
    public const MAIN_LAYOUT = 'main';
    public string $title = '';

    /**
     * @param string $view 
     * @param array $params 
     * 
     * @return string
     */
    public function renderView(string $view, array $params = []): string
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        
        return (string) str_replace('{{ content }}', $viewContent, $layoutContent);
    }

    /**
     * @return string
    */
    protected function layoutContent(): string
    {
        /** @var \App\Internal\Controller $controller  */
        $controller = app()->controller ?? null;
        $layout = ($controller) ? $controller->layout : View::MAIN_LAYOUT;

        ob_start();
        require_once path()->to("/Views/layouts/{$layout}.html.php");
        return ob_get_clean();
    }

    /**
     * @param string $view 
     * @param array $params 
     * 
     * @return string
     */
    protected function renderOnlyView(string $view, array $params = []): string
    {
        ob_start();
        extract($params);
        require_once path()->to("/Views/$view.html.php");
        return ob_get_clean();
    }
}