<?php

namespace Notihnio\Cactus;

use Notihnio\Cactus\Exception\RuntimeException;
use Notihnio\Cactus\Exception\DepedencyException;

class Cactus
{

    /**
     * @return string
     */
    private function detectOs(): string
    {
        return (PHP_OS_FAMILY === "Windows") ? "Windows" : "Unix";
    }

    /**
     * @return string
     * @throws \Notihnio\Cactus\Exception\DepedencyException
     */
    private function getOpcacheFileCachePath(): string
    {
        if (!ini_get("opcache.file_cache")) {
            throw new DepedencyException("Opcache file cache should enabled");
        }

        return ini_get("opcache.file_cache");
    }

    /**
     * @return void
     * @throws \Notihnio\Cactus\Exception\DepedencyException
     */
    private function detectIfFileCacheDirIsWritable(): void
    {
        if (!is_writable($this->getOpcacheFileCachePath())) {
            throw new DepedencyException("Opcache file folder should be writable");
        }
    }

    /**
     * @return void
     * @throws \Notihnio\Cactus\Exception\DepedencyException
     */
    private function detectOpcacheValidateTimestamps(): void
    {
        if (ini_get("opcache.validate_timestamps")) {
            throw new DepedencyException("opcache.validate_timestamps should not be enabled");
        }
    }

    /**
     * @return void
     * @throws \Notihnio\Cactus\Exception\DepedencyException
     */
    private function detectPhpConfiguration(): void
    {
        $this->detectIfFileCacheDirIsWritable();
        $this->detectOpcacheValidateTimestamps();
    }

    /**
     * @param $rootDirectory
     *
     * @return void
     */
    private function compile($rootDirectory): void
    {
        $dirContents = scandir($rootDirectory);

        $phpMimeTypes = [
            "text/php",
            "text/x-php",
            "application/php",
            "application/x-php",
            "application/x-httpd-php",
            "application/x-httpd-php-source"
        ];

       foreach ($dirContents as $dirChild) {
           $filePath = $rootDirectory . DIRECTORY_SEPARATOR . $dirChild;

           if (is_file($filePath) &&
               in_array(mime_content_type($$filePath), $phpMimeTypes, true)
           ) {
               if (!is_writable($filePath)) {
                   throw new RuntimeException("No permissions to write file {$filePath}");
               }

               opcache_compile_file($filePath);
               file_put_contents($filePath, "<?php //compiled by Cactus");
           }

           if (is_dir($filePath)) {
               if (!is_readable($filePath)) {
                   throw new RuntimeException("No permissions to read dir {$filePath}");
               }
               $this->compile($rootDirectory . DIRECTORY_SEPARATOR . $dirChild);
           }
       }
    }
}
