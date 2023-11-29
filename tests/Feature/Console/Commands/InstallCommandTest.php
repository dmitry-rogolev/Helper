<?php

namespace dmitryrogolev\Helper\Tests\Feature\Console\Commands;

use dmitryrogolev\Helper\Tests\TestCase;

/**
 * Тестируем команду установки пакета "Is".
 */
class InstallCommandTest extends TestCase
{
    /**
     * Запускается ли команда?
     *
     * @return void
     */
    public function test_run(): void
    {
        $this->artisan('helper:install')->assertOk();
        $this->artisan('helper:install --config')->assertOk();
    }
}
