<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Article
{
    private readonly PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch();

        if (!$article) {
            return null;
        }

        $stmt = $this->pdo->prepare(
            'SELECT c.*
             FROM categories c
             INNER JOIN article_categories ac ON c.id = ac.category_id
             WHERE ac.article_id = :article_id
             ORDER BY c.name'
        );
        $stmt->execute(['article_id' => $id]);
        $article['categories'] = $stmt->fetchAll();

        return $article;
    }

    public function getByCategoryId(
        int $categoryId,
        string $sort = 'date',
        int $page = 1,
        int $perPage = 9
    ): array {
        $orderBy = match ($sort) {
            'views' => 'a.views DESC',
            default => 'a.created_at DESC',
        };

        $offset = ($page - 1) * $perPage;

        $stmt = $this->pdo->prepare(
            "SELECT a.*
             FROM articles a
             INNER JOIN article_categories ac ON a.id = ac.article_id
             WHERE ac.category_id = :category_id
             ORDER BY {$orderBy}
             LIMIT :limit OFFSET :offset"
        );
        $stmt->bindValue('category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countByCategoryId(int $categoryId): int
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(DISTINCT a.id)
             FROM articles a
             INNER JOIN article_categories ac ON a.id = ac.article_id
             WHERE ac.category_id = :category_id'
        );
        $stmt->execute(['category_id' => $categoryId]);

        return (int) $stmt->fetchColumn();
    }

    public function incrementViews(int $id): void
    {
        $stmt = $this->pdo->prepare('UPDATE articles SET views = views + 1 WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function getRelated(int $articleId, int $limit = 3): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT DISTINCT a.*
             FROM articles a
             INNER JOIN article_categories ac ON a.id = ac.article_id
             WHERE ac.category_id IN (
                 SELECT category_id FROM article_categories WHERE article_id = :article_id
             )
             AND a.id != :exclude_id
             ORDER BY a.created_at DESC
             LIMIT :limit'
        );
        $stmt->bindValue('article_id', $articleId, PDO::PARAM_INT);
        $stmt->bindValue('exclude_id', $articleId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
