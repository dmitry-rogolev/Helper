<?php 

namespace dmitryrogolev\Testing\Concerns;

use Illuminate\Support\Facades\DB;

trait InteractsWithDatabase 
{
    use \Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;

    /**
     * Количество выполненных запросов к БД.
     */
    protected int $queryExecutedCount = 0;

    /**
     * SQL-запросы, отправленные на выполнение.
     *
     * @var array<int, string>
     */
    protected array $queries;

    /**
     * Зарегистрировать слушатель событий выполнения SQL-запросов.
     *
     * @return void
     */
    protected function registerQueryListener(): void 
    {
        DB::listen(function ($query) {
            $this->queryExecutedCount++;
            $this->queries[] = $query->sql;
        });
    }

    /**
     * Сбросить количество выполненных запросов к БД.
     */
    protected function resetQueryExecutedCount(): void
    {
        $this->queryExecutedCount = 0;
    }

    /**
     * Сбрасывает список SQL-запросов, отправленных на выполнение.
     */
    protected function resetQueries(): void
    {
        $this->queries = [];
    }

    /**
     * Подтвердить количество выполненных запросов к БД.
     */
    protected function assertQueryExecutedCount(int $expectedCount, ?string $message = ''): void
    {
        $this->assertEquals($expectedCount, $this->queryExecutedCount, $message);
    }
}