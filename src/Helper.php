<?php

namespace dmitryrogolev;

use Illuminate\Contracts\Support\Arrayable;
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
     * @param mixed ...$params [Не обязательный] Параметры, которые будут переданы конструктору требуемого класса.
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
     * Приводит переданный объект к массиву.
     *
     * @param object $obj
     * @return array<int, mixed>
     */
    public static function objectToArray(object $obj): array
    {
        return $obj instanceof Arrayable ? $obj->toArray() : get_object_vars($obj);
    }

    /**
     * Рекурсивно приводит объект и его публичные свойства к массиву.
     *
     * @param object $obj
     * @return array<int, mixed>
     */
    public static function objectToArrayRecursive(object $obj): array
    {
        $result = static::objectToArray($obj);

        return array_map(fn ($item) => is_object($item) ? static::objectToArray($item) : $item, $result);
    }

    /**
     * Разбивает строку на коллекцию по регулярному выражению или по количеству символов.
     *
     * @param string|\Illuminate\Support\Stringable|\Closure $value Разбиваемая строка.
     * 
     * @param string|int $pattern [Не обязательный] 
     * Регулярное выражение или количество символов, которое должны содержать подстроки.
     * 
     * @param int $limit [Не обязательный] Максимальное количество элементов в коллекции. 
     * Значение "-1" указывает на отсутствие ограничения.
     * 
     * @return \Illuminate\Support\Collection<int, string>
     */
    public static function split($value, string|int $pattern = '/(?=\p{Lu})|[,|\s_.-]+/u', int $limit = -1): Collection
    {
        return static::toStringable($value)->split($pattern, $limit)->filter()->values();
    }

    /**
     * Пытается привести входное значение к массиву.
     * 
     * @param  mixed $value Входное значение.
     * @return array<mixed, mixed>
     */
    public static function toArray($value): array
    {
        $value = value($value);

        if (is_object($value)) {
            return static::objectToArray($value);
        }

        return (array) $value;
    }

    /**
     * Пытается привести входное значение к коллекции.
     *
     * @param  mixed $value Входное значение.
     * @return \Illuminate\Support\Collection<mixed, mixed>
     */
    public static function toCollect($value): Collection
    {
        $value = value($value);

        return $value instanceof Collection ? $value : collect(static::toArray($value));
    }

    /**
     * Пытается привести переданное значение к строке "Illuminate\Support\Stringable".
     *
     * @param mixed $value
     * @return \Illuminate\Support\Stringable
     */
    public static function toStringable($value): Stringable
    {
        $value = value($value);

        if ($value instanceof Stringable) {
            return $value;
        }

        try {
            $value = (string) $value;
        } catch (\Error | \ErrorException) {
            $value = '';
        }

        return new Stringable($value);
    }
}
