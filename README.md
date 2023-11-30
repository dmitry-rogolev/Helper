# Helper 

Предоставляет функции-помощники для фреймворка Laravel.

## Содержание

- [Подключение](#подключение)
- [Использование](#использование)

    + [Доступные помощники](#доступные-помощники)

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

## Использование 

Пакет предоставляет два вида помощников: 

1. Класс `dmitryrogolev/Helper` со статическими методами-помощниками;
2. Глобальные функции-помощники (аналоги статических методов).

### Доступные помощники

- [obj](#obj)
- [object_to_array](#object_to_array)
- [object_to_array_recursive](#object_to_array_recursive)
- [split](#split)
- [to_array](#to_array)
- [to_collect](#to_collect)
- [to_stringable](#to_stringable)

#### `obj` 

`dmitryrogolev/Helper::obj`

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

#### `object_to_array`

`dmitryrogolev/Helper::objectToArray`

Приводит переданный объект к массиву.

Если передан объект, реализующий интерфейс `Illuminate\Contracts\Support\Arrayable`, будет вызван его метод `toArray`.

    $object = collect([1, 2, 3]);
    $array  = object_to_array($object); // [1, 2, 3]

Если передать объект обычного класса, будут возвращены все его публичные свойства.

    $object = new MyClass('public', 'protected', 'private');
    $array  = object_to_array($object); // ['a' => 'public']

#### `object_to_array_recursive`

`dmitryrogolev/Helper::objectToArrayRecursive`

Делает то же самое, что и помощник `object_to_array`, но дополнительно рекурсивно приводит к массиву все публичные свойства объекта.

    $sub_object = new MyClass('public', 'protected', 'private');
    $object     = new MyClass($sub_object, 'protected', 'private');
    $array      = object_to_array_recursive($object); // ['a' => ['a' => 'public']]

#### `split`

`dmitryrogolev/Helper::split`

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

#### `to_array`

`dmitryrogolev/Helper::toArray`

Пытается привести входное значение к массиву.

Объект будет приведен к массиву с помощью помощника `object_to_array`.

    $value  = new MyClass('public', 'protected', 'private');
    $result = to_array($value); // ['a' => 'public']

Любое другое значение будет приведено к массиву с помощью явного приведения `(array)`. 

    $value  = 'value';
    $result = to_array($value); // ['value']

#### `to_collect`

`dmitryrogolev/Helper::toCollect`

Делает то же самое, что и помощник `to_array`, только оборачивает возвращаемый массив в коллекцию `\Illuminate\Support\Collection`.

#### `to_stringable` 

`dmitryrogolev\Helper::toStringable`

Пытается привести переданное значение к строке `Illuminate\Support\Stringable`.

    $value  = 'string';
    $result = to_stringable($value);
    $result->toString(); // 'string'

У объектов будет сделана попытка вызвать магический метод `__toString`.

    $value  = new MyClass('string');
    $result = to_stringable($value);
    $result->toString(); // 'string'

В случае неудачного привидения переданного значения к строке, будет возвращен пустой экземпляр `Illuminate\Support\Stringable`.

    $value  = ['string'];
    $result = to_stringable($value);
    $result->toString(); // ''

## Лицензия 

Этот пакет является бесплатным программным обеспечением, распространяемым на условиях [лицензии MIT](./LICENSE).
