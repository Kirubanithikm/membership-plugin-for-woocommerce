<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit36f5a9420196a25ffc1ba02fdf285a8e
{
    public static $files = array (
        '45a16669595eb3c0a9e2994e57fc3188' => __DIR__ . '/..' . '/yahnis-elsts/plugin-update-checker/load-v5p3.php',
    );

    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MPW\\App\\' => 8,
            'MPW\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MPW\\App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'MPW\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit36f5a9420196a25ffc1ba02fdf285a8e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit36f5a9420196a25ffc1ba02fdf285a8e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit36f5a9420196a25ffc1ba02fdf285a8e::$classMap;

        }, null, ClassLoader::class);
    }
}
