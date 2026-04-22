<?php
class HomeController
{   

    private function render($view, $data = [])
    {
        extract($data); // makes variables available in view
        ob_start();
        require __DIR__ . '/../views/' . $view . '.php';
        $content = ob_get_clean();
        // Include layout
        require __DIR__ . '/../views/layouts/main.php';
    }

    public function index()
    {
        $this->render('home', [
            'pageTitle' => 'Home'
        ]);
    }
}