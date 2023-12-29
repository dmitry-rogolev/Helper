<?php

use dmitryrogolev\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

if (! function_exists('obj')) {
    /**
     * Возвращает объект класса, если переданное значение не является экземпляром данного класса.
     *
     * Возвращает null, если $class не является экземпляром или именем класса.
     *
     * @param  mixed  $value Входящее значение.
     * @param  string|object  $class Имя класса, экземпляр которого нужно получить.
     * @param  mixed  ...$params Параметры, которые будут переданы конструктору требуемого класса.
     */
    function obj(mixed $value, string|object $class, mixed ...$params): ?object
    {
        return Helper::obj($value, $class, ...$params);
    }
}

if (! function_exists('object_to_array')) {
    /**
     * Приводит переданный объект к массиву.
     *
     * @return array<int, mixed>
     */
    function object_to_array(object $obj): array
    {
        return Helper::objectToArray($obj);
    }
}

if (! function_exists('object_to_array_recursive')) {
    /**
     * Рекурсивно приводит объект и его публичные свойства к массиву.
     *
     * @return array<int, mixed>
     */
    function object_to_array_recursive(object $obj): array
    {
        return Helper::objectToArrayRecursive($obj);
    }
}

if (! function_exists('split')) {
    /**
     * Разбивает строку на коллекцию по регулярному выражению или по количеству символов.
     *
     * @param  string|\Illuminate\Support\Stringable|\Closure  $value Разбиваемая строка.
     * @param  string|int  $pattern [Не обязательный]
     * Регулярное выражение или количество символов, которое должны содержать подстроки.
     * @param  int  $limit [Не обязательный] Максимальное количество элементов в коллекции.
     * Значение "-1" указывает на отсутствие ограничения.
     */
    function split(mixed $value, string|int $pattern = '/(?=\p{Lu})|[,|\s_.-]+/u', int $limit = -1): Collection
    {
        return Helper::split($value, $pattern, $limit);
    }
}

if (! function_exists('to_array')) {
    /**
     * Пытается привести входное значение к массиву.
     *
     * @param  mixed  $value Входное значение.
     * @return array<mixed, mixed>
     */
    function to_array(mixed $value): array
    {
        return Helper::toArray($value);
    }
}

if (! function_exists('to_collect')) {
    /**
     * Пытается привести входное значение к коллекции.
     *
     * @param  mixed  $value Входное значение.
     * @return \Illuminate\Support\Collection<mixed, mixed>
     */
    function to_collect(mixed $value): Collection
    {
        return Helper::toCollect($value);
    }
}

if (! function_exists('to_stringable')) {
    /**
     * Пытается привести переданное значение к строке "Illuminate\Support\Stringable".
     */
    function to_stringable(mixed $value): Stringable
    {
        return Helper::toStringable($value);
    }
}

if (! function_exists('is_id')) {
    /**
     * Проверяет, является ли переданное значение идентификатором.
     */
    function is_id(mixed $value): bool
    {
        return Helper::isId($value);
    }
}

if (! function_exists('generate')) {
    /**
     * Возвращает сгенерированную с помощью фабрики модель.
     */
    function generate(string $class, array|int|bool|null $count = null, array|bool $state = [], bool $create = true): Model|EloquentCollection
    {
        return Helper::generate($class, $count, $state, $create);
    }
}

if (! function_exists('to_flatten_array')) {
    /**
     * Приводит переданное значение в выравненному массиву.
     *
     * @return array<int, mixed>
     */
    function to_flatten_array(mixed $value): array
    {
        return Helper::toFlattenArray($value);
    }
}
