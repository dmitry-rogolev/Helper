<?php

namespace dmitryrogolev\Helper\Tests;

use dmitryrogolev\Testing\Concerns\InteractsWithDatabase;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use InteractsWithDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->registerListeners();
    }

    /**
     * Зарегистрировать слушатели событий.
     */
    protected function registerListeners(): void
    {
        $this->registerQueryListener();
    }
}
