<?php

namespace Notihnio\Cactus;

use \ErrorException;

/**
 * ErrorHandler that can be used to catch internal PHP errors
 * and convert to an ErrorException instance.
 */
class CactusErrorHandler
{
    /**
     * Active stack
     *
     * @var array
     */
    protected static array $stack = [];

    /**
     * Check if this error handler is active
     *
     * @return bool
     */
    public static function started(): bool
    {
        return (bool) static::getNestedLevel();
    }

    /**
     * Get the current nested level
     *
     * @return int
     */
    public static function getNestedLevel(): int
    {
        return count(static::$stack);
    }

    /**
     * Starting the error handler
     *
     * @param int $errorLevel
     */
    public static function start(int $errorLevel = \E_WARNING): void
    {
        ini_set('display_errors', 0);
        if (!static::$stack) {
            set_error_handler([static::class, 'addError'], $errorLevel);
        }

        static::$stack[] = null;
    }

    /**
     * Stopping the error handler
     *
     * @param bool $throw Throw the ErrorException if any
     *
     * @return null|ErrorException
     */
    public static function stop(bool $throw = false) : null|ErrorException
    {
        $errorException = null;

        if (static::$stack) {
            $errorException = array_pop(static::$stack);

            if (!static::$stack) {
                restore_error_handler();
            }

            if ($errorException && $throw) {
                throw $errorException;
            }
        }
        ini_set('display_errors', 1);
        return $errorException;
    }

    /**
     * Stop all active handler
     *
     * @return void
     */
    public static function clean(): void
    {
        if (static::$stack) {
            restore_error_handler();
        }

        static::$stack = array();
    }

    /**
     * Add an error to the stack
     *
     * @param int    $errno
     * @param string $errstr
     * @param string $errfile
     * @param int    $errline
     *
     * @return void
     */
    public static function addError(int $errno, string $errstr = '', string $errfile = '', int $errline = 0): void
    {
        $stack = & static::$stack[count(static::$stack) - 1];
        $stack = new ErrorException($errstr, 0, $errno, $errfile, $errline, $stack);
    }
}
