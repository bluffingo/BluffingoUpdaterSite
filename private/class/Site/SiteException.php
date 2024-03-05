<?php

namespace Site;

use JetBrains\PhpStorm\NoReturn;
use ReturnTypeWillChange;

/**
 * Site exceptions.
 *
 * @since Site 1.0
 */
class SiteException extends \Exception
{
    public function __construct($message, $code = 500, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
    
    #[ReturnTypeWillChange] public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    /**
     * Display custom page for exceptions instead of using the frontend.
     *
     * @since Site 1.0
     *
     * @return void
     */
    #[NoReturn] public function page(): void
    {
        $errorMsg = sprintf('<b>%s</b> (line %s in %s)', $this->getMessage(), $this->getLine(), $this->getFile());

        http_response_code(500);
        echo "<body bgcolor='black' text='orange'>";
        echo "<h1>Exception</h1>";
        echo "<p>" . $errorMsg . "</p>";
        echo "</body>";
        die();
    }
}