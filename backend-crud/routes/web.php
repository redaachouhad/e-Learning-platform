<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});


Route::get('/test-mail', function () {
    Mail::raw('This is a test email.', function ($message) {
        $message->to('test@example.com')
            ->subject('Test Mail from Laravel');
    });

    return 'Mail sent!';
});
require __DIR__ . '/auth.php';
