<?php

// Preload configuration for OPcache optimization
// This file is loaded by OPcache to improve performance

// Check for production container preload file
if (file_exists(dirname(__DIR__).'/var/cache/prod/App_KernelProdContainer.preload.php')) {
    require dirname(__DIR__).'/var/cache/prod/App_KernelProdContainer.preload.php';
}

// Check for development container preload file
if (file_exists(dirname(__DIR__).'/var/cache/dev/App_KernelDevDebugContainer.preload.php')) {
    require dirname(__DIR__).'/var/cache/dev/App_KernelDevDebugContainer.preload.php';
}

// Preload commonly used Symfony components
if (function_exists('opcache_compile_file')) {
    $vendorDir = dirname(__DIR__) . '/vendor';
    
    // Core Symfony components
    $coreFiles = [
        '/symfony/http-kernel/HttpKernel.php',
        '/symfony/http-foundation/Request.php',
        '/symfony/http-foundation/Response.php',
        '/symfony/routing/Router.php',
        '/symfony/dependency-injection/Container.php',
        '/symfony/event-dispatcher/EventDispatcher.php',
        '/doctrine/orm/lib/Doctrine/ORM/EntityManager.php',
        '/twig/twig/src/Environment.php',
    ];
    
    foreach ($coreFiles as $file) {
        $fullPath = $vendorDir . $file;
        if (file_exists($fullPath)) {
            opcache_compile_file($fullPath);
        }
    }
    
    // Preload application source files
    $srcDir = dirname(__DIR__) . '/src';
    if (is_dir($srcDir)) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($srcDir, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->getExtension() === 'php') {
                opcache_compile_file($file->getPathname());
            }
        }
    }
}
