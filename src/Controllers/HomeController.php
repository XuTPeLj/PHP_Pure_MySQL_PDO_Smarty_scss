<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;

class HomeController extends Controller
{
    public function index(): void
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getWithArticles();

        $this->render('home.tpl', [
            'categories' => $categories,
            'pageTitle' => 'Главная',
        ]);
    }
}
