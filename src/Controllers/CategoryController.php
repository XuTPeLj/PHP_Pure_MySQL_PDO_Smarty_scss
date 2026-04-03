<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;
use App\Models\Article;

class CategoryController extends Controller
{
    public function show(int $id): void
    {
        $categoryModel = new Category();
        $articleModel = new Article();

        $category = $categoryModel->getById($id);

        if (!$category) {
            http_response_code(404);
            $this->notFound();
            return;
        }

        $perPage = self::$config['app']['per_page'] ?? 9;

        $sort = $_GET['sort'] ?? 'date';
        $sort = in_array($sort, ['date', 'views'], true) ? $sort : 'date';

        $page = max(1, (int) ($_GET['page'] ?? 1));

        $articles = $articleModel->getByCategoryId($id, $sort, $page, $perPage);
        $totalArticles = $articleModel->countByCategoryId($id);
        $totalPages = (int) ceil($totalArticles / $perPage);

        $this->render('category.tpl', [
            'category' => $category,
            'articles' => $articles,
            'sort' => $sort,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'pageTitle' => $category['name'],
        ]);
    }
}
