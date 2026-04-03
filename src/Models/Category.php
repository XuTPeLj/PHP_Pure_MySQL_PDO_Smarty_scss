<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class Category
{
    private readonly PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM categories ORDER BY name');
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    /**
     * Categories that have at least one article, with latest 3 articles each.
     */
    public function getWithArticles(): array
    {
        $stmt = $this->pdo->query(
            'SELECT DISTINCT c.*
             FROM categories c
             INNER JOIN article_categories ac ON c.id = ac.category_id
             ORDER BY c.name'
        );
        $categories = $stmt->fetchAll();

        foreach ($categories as &$category) {
            $category['articles'] = $this->getLatestArticles((int) $category['id']);
        }

        return $categories;
    }

    public function getLatestArticles(int $categoryId, int $limit = 3): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT a.*
             FROM articles a
             INNER JOIN article_categories ac ON a.id = ac.article_id
             WHERE ac.category_id = :category_id
             ORDER BY a.created_at DESC
             LIMIT :limit'
        );
        $stmt->bindValue('category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
