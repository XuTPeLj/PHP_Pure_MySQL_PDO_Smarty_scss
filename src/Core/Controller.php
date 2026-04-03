<?php

declare(strict_types=1);

namespace App\Core;

use Smarty\Smarty;

class Controller
{
    protected readonly Smarty $smarty;
    protected static array $config = [];

    public static function setConfig(array $config): void
    {
        self::$config = $config;
    }

    public function __construct()
    {
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir(__DIR__ . '/../../templates/');
        $this->smarty->setCompileDir(__DIR__ . '/../../var/smarty/compile/');
        $this->smarty->setCacheDir(__DIR__ . '/../../var/smarty/cache/');
        $this->smarty->setEscapeHtml(true);
    }

    protected function render(string $template, array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display($template);
    }

    public function notFound(): void
    {
        $this->render('404.tpl');
    }
}
