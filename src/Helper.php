<?php

namespace dmitryrogolev;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

/**
 * Сборник функций-помощников.
 */
class Helper
{
    /**
     * Возвращает объект класса, если переданное значение не является экземпляром данного класса. 
     * 
     * Возвращает null, если $class не является экземпляром или именем класса.
     *
     * @param mixed $value Входящее значение.
     * @param string|object $class Имя класса, экземпляр которого нужно получить.
     * @param mixed ...$params Параметры, которые будут переданы конструктору требуемого класса.
     * @return object|null 
     */
    public static function obj($value, $class, ...$params): object|null
    {
        $value = value($value);

        if (is_object($class)) {
            $class = $class::class;
        }

        if (! is_string($class) || ! class_exists($class)) {
            return null;
        }

        if ($value instanceof $class) {
            return $value;
        }

        $params = array_map(fn ($item) => value($item), $params);

        return new $class(...$params);
    }

    /**
     * Разбивает строку на коллекцию по регулярному выражению или по количеству символов.
     *
     * @param string|\Illuminate\Support\Stringable|\Closure $value Разбиваемая строка.
     * @param string|int|null $pattern Регулярное выражение или количество символов, которое должны содержать подстроки.
     * @param int|null $limit Максимальное количество элементов в коллекции.
     * @return \Illuminate\Support\Collection
     */
    public static function split($value, string|int $pattern = null, int $limit = null): Collection
    {
        return static::obj($value, Stringable::class, $value)
            ->split(
                ! is_null($pattern) ? $pattern : config('helper.split.pattern'),
                ! is_null($limit) ? $limit : config('helper.split.limit'),
            )->filter()->values();
    }

    /**
     * Приводит значение к массиву.
     * 
     * Если передать строку, то она будет разбита с помощью функции split.
     *
     * @param  mixed $value Входное значение.
     * @return array
     */
    public static function toArray($value): array
    {
        $value = value($value);

        if (is_string($value) || $value instanceof Stringable) {
            $value = static::split($value);
        }

        $value = Arr::flatten(Arr::wrap($value));

        foreach ($value as $k => $v) {
            if (is_string($v) || $v instanceof Stringable) {
                $value[$k] = static::split($v)->toArray();
            }
        }

        return Arr::flatten($value);
    }

    /**
     * Приводит значение к коллекции.
     *
     * Если передать строку, то она будет разбита с помощью функции split.
     *
     * @param  mixed $value Входное значение.
     * @return \Illuminate\Support\Collection
     */
    public static function toCollect($value): Collection
    {
        return collect(static::toArray($value));
    }
}
