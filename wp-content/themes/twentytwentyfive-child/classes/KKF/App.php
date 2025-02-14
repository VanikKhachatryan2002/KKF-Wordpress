<?php

namespace KKF;

use KKF\Managers\HooksManager;
use KKF\Managers\ShortcodeManager;
use KKF\Managers\AssetsManager;
use KKF\Managers\ACF;

final class App
{
    private static ?App $INSTANCE = null;

    public function __wakeup()
    {
        throw new \Error("Cannot unserialize singleton");
    }

    public static function getInstance(): App
    {
        if (static::$INSTANCE === null) {
            static::$INSTANCE = new static();
        }

        return static::$INSTANCE;
    }

    public function initialize(): void
    {
        $this->initializeManagers();
    }

    private function initializeManagers(): void
    {
        HooksManager::init();
        ShortcodeManager::init();
        AssetsManager::init();
        ACF::init();
    }
}
