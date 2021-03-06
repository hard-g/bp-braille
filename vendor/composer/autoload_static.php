<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf9d13241df539d9273dd1434587ed13f
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'HardG\\BpBraille\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'HardG\\BpBraille\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'HardG\\BpBraille\\Groups\\Ajax' => __DIR__ . '/../..' . '/src/Groups/Ajax.php',
        'HardG\\BpBraille\\Groups\\Settings' => __DIR__ . '/../..' . '/src/Groups/Settings.php',
        'HardG\\BpBraille\\Groups\\Template' => __DIR__ . '/../..' . '/src/Groups/Template.php',
        'HardG\\BpBraille\\Messages\\Ajax' => __DIR__ . '/../..' . '/src/Messages/Ajax.php',
        'HardG\\BpBraille\\Messages\\Settings' => __DIR__ . '/../..' . '/src/Messages/Settings.php',
        'HardG\\BpBraille\\Messages\\Template' => __DIR__ . '/../..' . '/src/Messages/Template.php',
        'HardG\\BpBraille\\Plugin' => __DIR__ . '/../..' . '/src/Plugin.php',
        'HardG\\BpBraille\\Registerable' => __DIR__ . '/../..' . '/src/Registerable.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf9d13241df539d9273dd1434587ed13f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf9d13241df539d9273dd1434587ed13f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf9d13241df539d9273dd1434587ed13f::$classMap;

        }, null, ClassLoader::class);
    }
}
