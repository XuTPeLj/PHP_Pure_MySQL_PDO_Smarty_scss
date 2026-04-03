<?php

declare(strict_types=1);

namespace App\Database;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        echo "Starting database seeding...\n";

        $this->cleanTables();

        try {
            $this->pdo->beginTransaction();

            (new CategorySeeder())->run();
            (new ArticleSeeder())->run();

            $this->pdo->commit();
            echo "Seeding completed successfully.\n";
        } catch (\Throwable $e) {
            $this->pdo->rollBack();
            echo "Seeding failed: {$e->getMessage()}\n";
            throw $e;
        }
    }

    private function cleanTables(): void
    {
        $this->truncate('article_categories');
        $this->truncate('articles');
        $this->truncate('categories');
        echo "Tables cleared.\n";
    }
}
