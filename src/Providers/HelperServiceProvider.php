<?php

namespace dmitryrogolev\Helper\Providers;

use dmitryrogolev\Helper\Console\Commands\InstallCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Поставщик функционала ролей для моделей.
 */
class HelperServiceProvider extends ServiceProvider
{
    /**
     * Имя тега пакета.
     *
     * @var string
     */
    private string $packageTag = 'helper';

    /**
     * Регистрация любых служб пакета.
     * 
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfig();
        $this->registerFiles();
        $this->publishFiles();
        $this->registerCommands();
    }

    /**
     * Загрузка любых служб пакета.
     * 
     * @return void
     */
    public function boot(): void
    {

    }

    /**
     * Объединяем конфигурацию пакета с конфигурацией приложения.
     *
     * @return void
     */
    private function mergeConfig(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/helper.php', 'helper');
    }

    /**
     * Подключаем файлы.
     *
     * @return void
     */
    private function registerFiles(): void
    {
        if (config('helper.uses.functions')) {
            require_once __DIR__ . '/../helpers.php';
        }
    }

    /**
     * Публикуем файлы пакета.
     *
     * @return void
     */
    private function publishFiles(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/helper.php' => config_path('helper.php'),
        ], $this->packageTag . '-config');

        $this->publishes([
            __DIR__ . '/../../config/helper.php' => config_path('helper.php'),
        ], $this->packageTag);
    }

    /**
     * Регистрируем команды.
     *
     * @return void
     */
    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}
