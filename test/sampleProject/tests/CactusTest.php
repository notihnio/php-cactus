<?php

namespace Tests;

use \PHPUnit\Framework\TestCase;

final class CactusTest extends TestCase
{
    public function testCheckCompiledFiles(): void
    {
        $phpFileContents = file_get_contents(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."shouldBeCompiled.php");
        $txtFileContents = file_get_contents(__DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."shouldNotBeCompiled.txt");

        $this->assertTrue(str_contains($phpFileContents, "Cactus"));
        $this->assertTrue(str_contains($txtFileContents, "txt file"));
    }
}
