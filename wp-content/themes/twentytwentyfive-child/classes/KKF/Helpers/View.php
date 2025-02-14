<?php

namespace KKF\Helpers;

abstract class View
{
    public const TEMPLATE_DIR = THEME_TEMPLATES . '/';

    public static function render(string $templatePath, $data = []): string
    {
        ob_start();
        include self::TEMPLATE_DIR . $templatePath;
        return ob_get_clean();
    }
}
