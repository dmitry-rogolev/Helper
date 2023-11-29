<?php

namespace dmitryrogolev\Helper\Console\Commands;

use Illuminate\Console\Command;

/**
 * Команда установки пакета "Helper", предоставляющего функции-помощников.
 */
class InstallCommand extends Command
{
    /**
     * Имя и сигнатура консольной команды.
     *
     * @var string
     */
    protected $signature = 'helper:install 
                                {--config}';

    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = 'Installs the "Helper" package that provides helper functions for the Laravel framework.';

    /**
     * Выполнить консольную команду.
     *
     * @return mixed
     */
    public function handle()
    {
        $tag = 'helper';

        if ($this->option('config')) {
            $tag .= '-config';
        }

        $this->call('vendor:publish', [
            '--tag' => $tag,
        ]);
    }
}