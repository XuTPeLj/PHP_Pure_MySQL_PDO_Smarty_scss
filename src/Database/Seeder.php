<?php

declare(strict_types=1);

namespace App\Database;

use App\Core\Database;
use PDO;

abstract class Seeder
{
    protected readonly PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    abstract public function run(): void;

    protected function truncate(string $table): void
    {
        if (!preg_match('/^[a-z_]+$/', $table)) {
            throw new \InvalidArgumentException("Invalid table name: {$table}");
        }

        $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        try {
            $this->pdo->exec("TRUNCATE TABLE `{$table}`");
        } finally {
            $this->pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
        }
    }
}
