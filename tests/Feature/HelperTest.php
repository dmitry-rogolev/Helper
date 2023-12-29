<?php

namespace dmitryrogolev\Helper\Tests;

use Illuminate\Support\Stringable;

/**
 * Тестируем функции помощника.
 */
class HelperTest extends TestCase
{
    /**
     * Есть ли функция, возвращающий объект требуемого класса?
     */
    public function test_obj(): void
    {
        // Передаем экземпляр требуемого класса.
        $value = new MyClass();
        $object = obj($value, MyClass::class);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);

        // Передаем имя требуемого класса.
        $value = MyClass::class;
        $object = obj($value, MyClass::class);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);

        // Передаем экземпляр другого класса.
        $value = new SomeClass();
        $object = obj($value, MyClass::class);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);

        // Передаем значение, отличное от объекта.
        $value = 'MyClass';
        $object = obj($value, MyClass::class);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);

        // Передаем в качестве требуемого класса экземпляр этого класса.
        $value = new MyClass();
        $object = obj($value, $value);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);

        // Передаем в качестве требуемого класса значение,
        // отличное от имени класса и объекта этого класса.
        $value = new MyClass();
        $object = obj($value, 'MyClass');
        $this->assertNull($object);

        // Передаем параметры в конструктор требуемого класса.
        $value = 'MyClass';
        $object = obj($value, MyClass::class, 1, 2);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);
        $this->assertEquals(1, $object->getA());
        $this->assertEquals(2, $object->getB());

        // Передаем функции, возвращающие значение и параметры конструктора.
        $value = fn () => 'MyClass';
        $object = obj($value, MyClass::class, fn () => 1, fn () => 2);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);
        $this->assertEquals(1, $object->getA());
        $this->assertEquals(2, $object->getB());
    }

    /**
     * Есть ли функция, приводящая объект к массиву?
     */
    public function test_object_to_array(): void
    {
        // Передаем объект обычного класса.
        $object = new MyClass('public', 'protected', 'private');
        $array = object_to_array($object);
        $this->assertEquals(['a' => 'public'], $array);

        // Передаем объект класса, реализующий интерфейс "Illuminate\Contracts\Support\Arrayable".
        $object = collect([1, 2, 3]);
        $array = object_to_array($object);
        $this->assertEquals([1, 2, 3], $array);
    }

    /**
     * Есть ли функция, рекурсивно приводящая объект и его публичные свойства к массиву?
     */
    public function test_object_to_array_recursive(): void
    {
        // Передаем объект обычного класса.
        $object = new MyClass('public', 'protected', 'private');
        $array = object_to_array_recursive($object);
        $this->assertEquals(['a' => 'public'], $array);

        // Передаем объект класса, реализующий интерфейс "Illuminate\Contracts\Support\Arrayable".
        $object = collect([1, 2, 3]);
        $array = object_to_array_recursive($object);
        $this->assertEquals([1, 2, 3], $array);

        // Передаем объект, имеющий вложенные объекты.
        $sub_object = new MyClass('public', 'protected', 'private');
        $object = new MyClass($sub_object, 'protected', 'private');
        $array = object_to_array_recursive($object);
        $this->assertEquals(['a' => ['a' => 'public']], $array);
    }

    /**
     * Есть ли функция, разбивающая строку на коллекцию по регулярному выражению или по количеству символов?
     */
    public function test_split(): void
    {
        // Передаем строку с разделителями.
        $value = 'it, is,my|big_big.big-string';
        $result = split($value)->toArray();
        $this->assertEquals(['it', 'is', 'my', 'big', 'big', 'big', 'string'], $result);

        // Передаем строку в виде camelCase
        $value = 'itIsMyBigString';
        $result = split($value)->toArray();
        $this->assertEquals(['it', 'Is', 'My', 'Big', 'String'], $result);

        // Передаем экземпляр \Illuminate\Support\Stringable.
        $value = str('itIsMyBigString');
        $result = split($value)->toArray();
        $this->assertEquals(['it', 'Is', 'My', 'Big', 'String'], $result);

        // Передаем функцию.
        $value = fn () => 'itIsMyBigString';
        $result = split($value)->toArray();
        $this->assertEquals(['it', 'Is', 'My', 'Big', 'String'], $result);

        // Передаем строку.
        $value = 'Это моя большая строка.';
        $result = split($value)->toArray();
        $this->assertEquals(['Это', 'моя', 'большая', 'строка'], $result);

        // Передаем паттерн.
        $value = 'It is my string.';
        $result = split($value, '/[\s]+/')->toArray();
        $this->assertEquals(['It', 'is', 'my', 'string.'], $result);

        // Передаем количество символов, которое должно содержаться в подстроке.
        $value = 'It is my string.';
        $result = split($value, 3)->toArray();
        $this->assertEquals(['It ', 'is ', 'my ', 'str', 'ing', '.'], $result);

        // Передаем предел количества подстрок.
        $value = 'It is my string.';
        $result = split($value, '/[\s]+/', 3)->toArray();
        $this->assertEquals(['It', 'is', 'my string.'], $result);
    }

    /**
     * Есть ли функция, приводящее значение к массиву?
     */
    public function test_to_array(): void
    {
        // Передаем объект.
        $value = new MyClass('public', 'protected', 'private');
        $result = to_array($value);
        $this->assertEquals(['a' => 'public'], $result);

        // Передаем значение, отличное от массива и объекта.
        $value = 'value';
        $result = to_array($value);
        $this->assertEquals(['value'], $result);

        // Передаем коллекцию.
        $value = collect(['it', 'is', 'my', 'string']);
        $result = to_array($value);
        $this->assertEquals(['it', 'is', 'my', 'string'], $result);

        // Передаем массив.
        $value = ['it', 'is', 'my', 'string'];
        $result = to_array($value);
        $this->assertEquals(['it', 'is', 'my', 'string'], $result);

        // Передаем функцию.
        $value = fn () => ['it', 'is', 'my', 'string'];
        $result = to_array($value);
        $this->assertEquals(['it', 'is', 'my', 'string'], $result);
    }

    /**
     * Есть ли функция, приводящее значение к коллекции?
     */
    public function test_to_collect(): void
    {
        // Передаем объект.
        $value = new MyClass('public', 'protected', 'private');
        $result = to_collect($value)->toArray();
        $this->assertEquals(['a' => 'public'], $result);

        // Передаем значение, отличное от массива и объекта.
        $value = 'value';
        $result = to_collect($value)->toArray();
        $this->assertEquals(['value'], $result);

        // Передаем коллекцию.
        $value = collect(['it', 'is', 'my', 'string']);
        $result = to_collect($value)->toArray();
        $this->assertEquals(['it', 'is', 'my', 'string'], $result);

        // Передаем массив.
        $value = ['it', 'is', 'my', 'string'];
        $result = to_collect($value)->toArray();
        $this->assertEquals(['it', 'is', 'my', 'string'], $result);

        // Передаем функцию.
        $value = fn () => ['it', 'is', 'my', 'string'];
        $result = to_collect($value)->toArray();
        $this->assertEquals(['it', 'is', 'my', 'string'], $result);
    }

    /**
     * Если ли функция, приводящая значение к строке "Illuminate\Support\Stringable"?
     */
    public function test_to_stringable(): void
    {
        // Передаем строку.
        $value = 'string';
        $result = to_stringable($value);
        $this->assertInstanceOf(Stringable::class, $result);
        $this->assertEquals('string', $result->toString());

        // Передаем "Illuminate\Support\Stringable".
        $value = str('string');
        $result = to_stringable($value);
        $this->assertInstanceOf(Stringable::class, $result);
        $this->assertEquals('string', $result->toString());

        // Передаем объект, имеющий магический метод __toString
        $value = new MyClass('string');
        $result = to_stringable($value);
        $this->assertInstanceOf(Stringable::class, $result);
        $this->assertEquals('string', $result->toString());

        // Передаем объект, не имеющий магического метода __toString
        $value = new SomeClass();
        $result = to_stringable($value);
        $this->assertInstanceOf(Stringable::class, $result);
        $this->assertEquals('', $result->toString());

        // Передаем массив
        $value = ['string'];
        $result = to_stringable($value);
        $this->assertInstanceOf(Stringable::class, $result);
        $this->assertEquals('', $result->toString());
    }
}

class MyClass
{
    public $a;

    protected $b;

    private $c;

    public function __construct($a = null, $b = null, $c = null)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }

    public function getA()
    {
        return $this->a;
    }

    public function getB()
    {
        return $this->b;
    }

    public function getC()
    {
        return $this->c;
    }

    public function __toString(): string
    {
        return $this->a;
    }
}

class SomeClass
{
}
