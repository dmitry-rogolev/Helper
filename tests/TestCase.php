<?php

namespace dmitryrogolev\Helper\Tests;

use dmitryrogolev\Helper\Providers\HelperServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Получить поставщиков пакета.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            HelperServiceProvider::class,
        ];
    }
}
