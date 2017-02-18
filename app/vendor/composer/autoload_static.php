<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit888cfa2681606c9650207a4e01f867d7
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SpotifyWebAPI\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SpotifyWebAPI\\' => 
        array (
            0 => __DIR__ . '/..' . '/jwilsson/spotify-web-api-php/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit888cfa2681606c9650207a4e01f867d7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit888cfa2681606c9650207a4e01f867d7::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
