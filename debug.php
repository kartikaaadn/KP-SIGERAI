<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

try {
    require __DIR__ . '/vendor/autoload.php';
    $app = require __DIR__ . '/bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $request = Illuminate\Http\Request::create('/', 'GET');
    $response = $kernel->handle($request);

    echo "HTTP STATUS: " . $response->getStatusCode() . PHP_EOL;

    if ($response->getStatusCode() >= 500) {
        echo "---- RESPONSE CONTENT ----" . PHP_EOL;
        echo $response->getContent() . PHP_EOL;
        echo "--------------------------" . PHP_EOL;
    }
} catch (Throwable $e) {
    echo "CLASS: " . get_class($e) . PHP_EOL;
    echo "MESSAGE: " . $e->getMessage() . PHP_EOL;
    echo "FILE: " . $e->getFile() . PHP_EOL;
    echo "LINE: " . $e->getLine() . PHP_EOL;
}
