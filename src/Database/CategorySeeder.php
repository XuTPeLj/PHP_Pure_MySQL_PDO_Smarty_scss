<?php

declare(strict_types=1);

namespace App\Database;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = $this->getData();

        $stmt = $this->pdo->prepare(
            'INSERT INTO categories (name, description) VALUES (:name, :description)'
        );

        foreach ($data as $category) {
            $stmt->execute([
                'name' => $category['name'],
                'description' => $category['description'],
            ]);
        }

        echo "Created " . count($data) . " categories.\n";
    }

    /** @return list<array{name: string, description: string}> */
    private function getData(): array
    {
        return [
            [
                'name' => 'Технологии',
                'description' => 'Новости и обзоры из мира технологий, гаджетов и инноваций',
            ],
            [
                'name' => 'Программирование',
                'description' => 'Статьи о языках программирования, фреймворках и лучших практиках разработки',
            ],
            [
                'name' => 'Дизайн',
                'description' => 'Тренды и советы в веб-дизайне, UX/UI и визуальном оформлении',
            ],
            [
                'name' => 'Наука',
                'description' => 'Открытия, исследования и интересные факты из мира науки',
            ],
            [
                'name' => 'Образование',
                'description' => 'Курсы, методики обучения и советы для саморазвития',
            ],
        ];
    }
}
