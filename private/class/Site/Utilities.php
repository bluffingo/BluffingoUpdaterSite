<?php

namespace Site;

class Utilities
{
    #[NoReturn] public static function redirect($url, ...$args) {
        header('Location: '.sprintf($url, ...$args));
        die();
    }

    #[NoReturn] public static function redirectPerma($url, ...$args) {
        header('Location: '.sprintf($url, ...$args), true, 301);
        die();
    }
}