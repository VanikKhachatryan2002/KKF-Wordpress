<?php

namespace KKF\Managers;

abstract class BaseManager
{
    public static $instances = [];

    public static function init()
    {
        new static();
    }

    public function __construct()
    {
        $this->afterConstruct();
        $this->addActions();
        $this->addFilters();
        $this->removeActions();
        $this->addShortCodes();
        $this->addOptions();
    }

    final public static function get_instance() {
        $class = get_called_class();

        if ( ! isset( $instances[ $class ] ) ) {
            self::$instances[ $class ] = new $class();
        }

        return self::$instances[ $class ];
    }

    protected function addActions(): void
    {
    }

    protected function addFilters(): void
    {
    }

    protected function addShortCodes(): void
    {
    }

    protected function removeActions(): void
    {
    }

    protected function addOptions(): void
    {
    }

    public function afterConstruct(): void
    {
    }

    public function dump(...$vars)
    {
        echo "<pre>";
        var_dump(...$vars);
        echo "</pre>";
    }
}