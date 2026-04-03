<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Article;

class ArticleController extends Controller
{
    public function show(int $id): void
    {
        $articleModel = new Article();

        $article = $articleModel->getById($id);

        if (!$article) {
            http_response_code(404);
            $this->notFound();
            return;
        }

        $articleModel->incrementViews($id);
        $article['views'] = (int) $article['views'] + 1;

        $related = $articleModel->getRelated($id, 3);

        $this->render('article.tpl', [
            'article' => $article,
            'related' => $related,
            'pageTitle' => $article['title'],
        ]);
    }
}
