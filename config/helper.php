<?php

/**
 * Конфигурация Helper
 * 
 * @version 0.0.1
 * @author Роголев Дмитрий <work.drogolev@internet.ru>
 * @license MIT
 */

return [

    /**
     * * Функция obj.
     * 
     * Возвращает объект класса, если переданное значение не является экземпляром данного класса. 
     * 
     * Возвращает null, если $class не является экземпляром или именем класса.
     *
     * @param mixed $value Входящее значение.
     * @param string|object $class Имя класса, экземпляр которого нужно получить.
     * @param mixed ...$params Параметры, которые будут переданы конструктору требуемого класса.
     * @return object|null 
     */
    'obj'        => [
        /**
         * * Регистрировать ли функцию?
         * 
         * Если флаг config('helper.uses.functions') === false, данный флаг игнорируется.
         */
        'use' => (bool) env('HELPER_OBJ_USE', true),
    ],

    /**
     * * Функция split.
     * 
     * Разбивает строку на коллекцию по регулярному выражению или по количеству символов.
     *
     * @param string|\Illuminate\Support\Stringable|\Closure $value Разбиваемая строка.
     * @param string|int|null $pattern Регулярное выражение или количество символов, которое должны содержать подстроки.
     * @param int|null $limit Максимальное количество элементов в коллекции.
     * @return \Illuminate\Support\Collection
     */
    'split'      => [
        /**
         * * Регистрировать ли функцию?
         * 
         * Если флаг config('helper.uses.functions') === false, данный флаг игнорируется.
         */
        'use'     => (bool) env('HELPER_SPLIT_USE', true),

        /**
         * * Регулярное выражение или количество символов, которое должны содержать подстроки.
         * 
         * @param string|int|null $pattern
         */
        'pattern' => env('HELPER_SPLIT_PATTERN', '/(?=\p{Lu})|[,|\s_.-]+/u'),

        /**
         * * Максимальное количество элементов в коллекции.
         * 
         * Значение "-1" указывает на отсутствие ограничения.
         * 
         * @param int|null $limit
         */
        'limit'   => (int) env('HELPER_SPLIT_LIMIT', -1),
    ],

    /**
     * * Функция to_array.
     * 
     * Приводит значение к массиву.
     * 
     * Если передать строку, то она будет разбита с помощью функции split.
     *
     * @param  mixed $value Входное значение.
     * @return array
     */
    'to_array'   => [
        /**
         * * Регистрировать ли функцию?
         * 
         * Если флаг config('helper.uses.functions') === false, данный флаг игнорируется.
         */
        'use' => (bool) env('HELPER_TO_ARRAY_USE', true),
    ],

    /**
     * * Функция to_collect.
     * 
     * Приводит значение к коллекции.
     *
     * Если передать строку, то она будет разбита с помощью функции split.
     *
     * @param  mixed $value Входное значение.
     * @return \Illuminate\Support\Collection
     */
    'to_collect' => [
        /**
         * * Регистрировать ли функцию?
         * 
         * Если флаг config('helper.uses.functions') === false, данный флаг игнорируется.
         */
        'use' => (bool) env('HELPER_TO_COLLECT_USE', true),
    ],

    /**
     * * Флаги. 
     */
    'uses'       => [
        /**
         * * Регистрировать ли функции-помощники?
         */
        'functions' => (bool) env('HELPER_USES_FUNCTIONS', false),
    ],
];
