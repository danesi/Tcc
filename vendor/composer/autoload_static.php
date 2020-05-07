<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit59fcd40b31d0e6fcd552e1a8e4046995
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit59fcd40b31d0e6fcd552e1a8e4046995::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit59fcd40b31d0e6fcd552e1a8e4046995::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}