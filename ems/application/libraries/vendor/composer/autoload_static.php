<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6a7e3b8a4e628fc09284ced6ccfcd4d9
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Libern\\QRCodeReader\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Libern\\QRCodeReader\\' => 
        array (
            0 => __DIR__ . '/..' . '/libern/qr-code-reader/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6a7e3b8a4e628fc09284ced6ccfcd4d9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6a7e3b8a4e628fc09284ced6ccfcd4d9::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
