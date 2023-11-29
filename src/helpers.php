<?php

use dmitryrogolev\Helper;
use Illuminate\Support\Collection;

if (! function_exists('obj') && config('helper.obj.use')) {

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
    function obj($value, $class, ...$params): object|null
    {
        return Helper::obj($value, $class, ...$params);
    }

}

if (! function_exists('split') && config('helper.split.use')) {

    /**
     * Разбивает строку на коллекцию по регулярному выражению или по количеству символов.
     *
     * @param string|\Illuminate\Support\Stringable|\Closure $value Разбиваемая строка.
     * @param string|int|null $pattern Регулярное выражение или количество символов, которое должны содержать подстроки.
     * @param int|null $limit Максимальное количество элементов в коллекции.
     * @return \Illuminate\Support\Collection
     */
    function split($value, string|int $pattern = null, int $limit = null): Collection
    {
        return Helper::split($value, $pattern, $limit);
    }

}

if (! function_exists('to_array') && config('helper.to_array.use')) {

    /**
     * Приводит значение к массиву.
     * 
     * Если передать строку, то она будет разбита с помощью функции split.
     *
     * @param  mixed $value Входное значение.
     * @return array
     */
    function to_array($value): array
    {
        return Helper::toArray($value);
    }

}

if (! function_exists('to_collect') && config('helper.to_collect.use')) {

    /**
     * Приводит значение к коллекции.
     *
     * Если передать строку, то она будет разбита с помощью функции split.
     *
     * @param  mixed $value Входное значение.
     * @return \Illuminate\Support\Collection
     */
    function to_collect($value): Collection
    {
        return Helper::toCollect($value);
    }

}
