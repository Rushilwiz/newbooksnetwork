<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit78064882bd0b2267c039a9690591a17f
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit78064882bd0b2267c039a9690591a17f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit78064882bd0b2267c039a9690591a17f::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
