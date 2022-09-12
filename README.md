# PHP Cactus 🌵

Protect your PHP code from being stolen. Deploy with no fear of not owning servers. This library compiles your PHP code to opcodes and removes code from all php files included in your project. All produced opcode files are saved on the server's filesystem and used by OPcache.

**Before**

index.php

    <?php
    use Illuminate\Contracts\Http\Kernel;
    use Illuminate\Http\Request;
    define('LARAVEL_START', microtime(true));

**After**

index.php

    <?php
    //compiled by Cactus

index.php.bin

    OPCACHEaa076b0e7a9c60b4d014e9d46754d5ffòËE"=h"`ÿ†8˛ˇˇˇÄ˛ˇˇˇÄˇˇˇˇw—∑e9YÅ©—!a°°¡!QÅÅ°°¡¡Jp=y
    PAJ`=y
    PAë†Å]†`uêÅJ`=◊P†_†PAë†ÅÈ†@+¸PIÙ"IÙ†/I⁄`†/‚`1pz
    
    P1tG†1<⁄p†	1‚p(3pÁ
    84qG∞4<€ê∞†4/†P4tG†4<”†H5pG†5<⁄Ä†3‚pX7püêP7BüÄ`7BF7<Kˇˇˇˇ8>V∆èMi…˝8é/laravel/public/index.phpÈ1QyV∆èMi…˝8é/laravel/public/index.phpVpJÄ¯RÄdefineVYZ€∂
    ¨≥î
    LARAVEL_STARTVÆó‰H—wÉ	microtimeVÑÀTñuä¿file_existsVΩP∂äÔÓSø4/laravel/public/../storage/framework/maintenance.phpVo~†∑”5∂&/laravel/public/../vendor/autoload.phpV'†ﬁeE^Ô$/laravel/public/../bootstrap/app.phpV£ö|ÄmakeVﬂ.`ôå¥öê Illuminate\Contracts\Http\KernelVqÿêSÄhandle!V⁄ó≤:·†q”Illuminate\Http\RequestV:¥ˇi?⁄ﬂilluminate\http\requestV9÷ı≤±–ÄcaptureVO€ù|ÄsendVÓ ‘=—ŸwÉ	terminateVhÏ1\

## Useful Notes

- **Your php files content will be replaced!!!!!!!** Be sure **you have
  copies** on your development machine

- If you want to update a file after compilation. Replace the existing
  (empty file) with the updated one, and run PHP cactus again

- The opcodes should be served by the same interpreter which has created them.
- A good idea is to create docker images with your compiled app. Your could update your app by updating your docker image version

## Install

Using Composer
```
composer require notihnio/php-cactus:^1.0
```

Add to your php.ini configuration

    opcache.enable=1  
    opcache.enable_cli=1  
    opcache.validate_timestamps=0  
    opcache.file_cache = "Enter here the path where the opcodes will be saved"

## Run php Cactus

    YourProjectRootDir/vendor/bin/cactus

Run php Cactus without any prompt (Force mode for your deployment process)

    YourProjectRootDir/vendor/bin/cactus --noPrompt



