# Helper 

Предоставляет функции-помощники для фреймворка Laravel.

## Содержание

- [Подключение](#подключение)
- [Установка](#установка)
- [Использование](#использование)

    + [Доступные помощники](#доступные-помощники)

- [Конфигурация](#конфигурация)
- [Лицензия](#лицензия)

## Подключение 

Добавьте ссылку на репозиторий в файл `composer.json`.

    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:dmitry-rogolev/Helper.git"
        }
    ]

Подключите пакет с помощью команды: 

    composer require dmitryrogolev/helper

## Установка 

Опубликуйте файл конфигурации с помощью команды.

    php artisan helper:install 

## Использование 

Пакет предоставляет два вида помощников: 

1. Класс `dmitryrogolev/Helper` со статическими методами-помощниками;
2. Глобальные функции-помощники (аналоги статических методов).

### Доступные помощники

- [obj](#obj-и-helperobj)
- [split](#split-и-helpersplit)
- [to_array](#to_array-и-helpertoarray)
- [to_collect](#to_collect-и-helpertocollect)

#### `obj` и `Helper::obj`

Возвращает объект требуемого класса.

Функция принимает первым параметром любое значение, которое нужно обработать, 
а вторым имя класса, экземпляр которого нужно получить.

Если передать экземпляр требуемого класса, то он вернется без изменения. 

    $value  = new MyClass();
    $my_class = obj($value, MyClass::class); // $my_class === $value

Если передать значение любого другого типа, будет возвращен экземпляр того класса, имя которого было передано вторым параметром. 

    $value  = new SomeClass();
    $my_class = obj($value, MyClass::class); // $my_class instanceof MyClass

Также можно передать любое количество параметров в конструктор создаваемого экземпляра класса. Просто перечислите их после второго параметра.

    $value  = 'MyClass';
    $my_class = obj($value, MyClass::class, 1, 2, 'my_argument');

#### `split` и `Helper::split`

Разбивает строку на коллекцию по регулярному выражению или по количеству символов в подстроке.

По умолчанию данная функция развивает строку по следующим символам: `,|_.-`, а также пробельным символам и заглавным буквам.

    $value  = 'it, is|my_big.big-big big BigString';
    $result = split($value)->toArray(); 
    // $result = ['it', 'is', 'my', 'big', 'big', 'big', 'big', 'Big', 'String']

Вторым параметром вы можете передать паттерн, по которому нужно разбить строку.

    $value = 'It is my string.';
    $result = split($value, '/[\s]+/')->toArray(); // Разбиваем по пробельным символам.
    // $result === ['It', 'is', 'my', 'string.'];

Также вторым параметром вы можете передать количество символов, которое должно содержаться в подстроке.

    $value = 'It is my string.';
    $result = split($value, 3)->toArray(); 
    // $result === ['It ', 'is ', 'my ', 'str', 'ing', '.'];

Третьим параметром вы можете передать предел количества подстрок. Значение "-1" указывает на отсутствие ограничений.

    $value  = 'It is my string.';
    $result = split($value, '/[\s]+/', 3)->toArray(); // Разбиваем по пробельным символам.
    // $result === ['It', 'is', 'my string.'];

#### `to_array` и `Helper::toArray`

Приводит значение к массиву.

Если передать значение, отличное от массива, то это значение будет обёрнуто в массив.

    $value  = 'value';
    $result = to_array($value); // ['value']

Если передать коллекцию `\Illuminate\Support\Collection` или массив, то вернется массив, при чем все вложенные массивы будут свернуты.

    $value  = ['it', ['is', 'my'], 'string'];
    $result = to_array($value); // ['it', 'is', 'my', 'string']

Если передать строку, то она будет разбита с помощью помощника `split`, также как и все вложенные в массив строки будут разбиты.

    $value  = 'it_is_my_string';
    $result = to_array($value); // ['it', 'is', 'my', 'string']

#### `to_collect` и `Helper::toCollect`

Делает то же самое, что и помощник `to_array`, только оборачивает возвращаемый массив в коллекцию `\Illuminate\Support\Collection`.

## Конфигурация

Из-за возможных конфликтов имен в глобальной области видимости, есть возможность полного отключения регистрации глобальных помощников, а также отключения отдельно взятых функций в файле конфига.

Если вы опубликовали файл конфигурации, то он будет находиться в папке `config` под именем `helper.php` в корне вашего проекта. Откройте его и ознакомьтесь более подробно со всеми параметрами конфигурации.

Также вы можете указать конфигурацию в своем файле `.env`.

    HELPER_OBJ_USE=true
    HELPER_SPLIT_USE=true
    HELPER_SPLIT_PATTERN="/(?=\p{Lu})|[,|\s_.-]+/u"
    HELPER_SPLIT_LIMIT=-1
    HELPER_TO_ARRAY_USE=true
    HELPER_TO_COLLECT_USE=true
    HELPER_USES_FUNCTIONS=true

## Лицензия 

Этот пакет является бесплатным программным обеспечением, распространяемым на условиях [лицензии MIT](./LICENSE).