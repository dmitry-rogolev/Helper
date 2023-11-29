<?php

namespace dmitryrogolev\Helper\Tests;

/**
 * Тестируем функции помощника.
 */
class HelperTest extends TestCase
{
    /**
     * Есть ли функция, возвращающий объект требуемого класса?
     *
     * @return void
     */
    public function test_obj(): void
    {
        // Передаем экземпляр требуемого класса.
        $value  = new MyClass();
        $object = obj($value, MyClass::class);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);

        // Передаем имя требуемого класса.
        $value  = MyClass::class;
        $object = obj($value, MyClass::class);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);

        // Передаем экземпляр другого класса.
        $value  = new SomeClass();
        $object = obj($value, MyClass::class);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);

        // Передаем значение, отличное от объекта.
        $value  = 'MyClass';
        $object = obj($value, MyClass::class);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);

        // Передаем в качестве требуемого класса экземпляр этого класса.
        $value  = new MyClass();
        $object = obj($value, $value);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);

        // Передаем в качестве требуемого класса значение, 
        // отличное от имени класса и объекта этого класса.
        $value  = new MyClass();
        $object = obj($value, 'MyClass');
        $this->assertNull($object);

        // Передаем параметры в конструктор требуемого класса.
        $value  = 'MyClass';
        $object = obj($value, MyClass::class, 1, 2);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);
        $this->assertEquals(1, $object->a);
        $this->assertEquals(2, $object->b);

        // Передаем функции, возвращающие значение и параметры конструктора.
        $value  = fn () => 'MyClass';
        $object = obj($value, MyClass::class, fn () => 1, fn () => 2);
        $this->assertIsObject($object);
        $this->assertInstanceOf(MyClass::class, $object);
        $this->assertEquals(1, $object->a);
        $this->assertEquals(2, $object->b);
    }

    /**
     * Есть ли функция, разбивающая строку на коллекцию по регулярному выражению или по количеству символов?
     *
     * @return void
     */
    public function test_split(): void
    {
        // Передаем строку с разделителями.
        $value  = 'it, is,my|big_big.big-string';
        $result = split($value)->toArray();
        $this->assertEquals(['it', 'is', 'my', 'big', 'big', 'big', 'string'], $result);

        // Передаем строку в виде camelCase 
        $value  = 'itIsMyBigString';
        $result = split($value)->toArray();
        $this->assertEquals(['it', 'Is', 'My', 'Big', 'String'], $result);

        // Передаем экземпляр \Illuminate\Support\Stringable.
        $value  = str('itIsMyBigString');
        $result = split($value)->toArray();
        $this->assertEquals(['it', 'Is', 'My', 'Big', 'String'], $result);

        // Передаем функцию.
        $value  = fn () => 'itIsMyBigString';
        $result = split($value)->toArray();
        $this->assertEquals(['it', 'Is', 'My', 'Big', 'String'], $result);

        // Передаем строку.
        $value  = 'Это моя большая строка.';
        $result = split($value)->toArray();
        $this->assertEquals(['Это', 'моя', 'большая', 'строка'], $result);

        // Передаем паттерн.
        $value  = 'It is my string.';
        $result = split($value, '/[\s]+/')->toArray();
        $this->assertEquals(['It', 'is', 'my', 'string.'], $result);

        // Передаем количество символов, которое должно содержаться в подстроке.
        $value  = 'It is my string.';
        $result = split($value, 3)->toArray();
        $this->assertEquals(['It ', 'is ', 'my ', 'str', 'ing', '.'], $result);

        // Передаем предел количества подстрок.
        $value  = 'It is my string.';
        $result = split($value, '/[\s]+/', 3)->toArray();
        $this->assertEquals(['It', 'is', 'my string.'], $result);
    }

    /**
     * Есть ли функция, приводящее значение к массиву?
     *
     * @return void
     */
    public function test_to_array(): void
    {
        // Передаем значение, отличное от массива.
        $value  = 'value';
        $result = to_array($value);
        $this->assertEquals(['value'], $result);

        // Передаем коллекцию.
        $value  = collect(['it', 'is', 'my', 'string']);
        $result = to_array($value);
        $this->assertEquals(['it', 'is', 'my', 'string'], $result);

        // Передаем массив.
        $value  = ['it', ['is', 'my'], 'string'];
        $result = to_array($value);
        $this->assertEquals(['it', 'is', 'my', 'string'], $result);

        // Передаем строку с разделителями.
        $value  = 'it_is_my_string';
        $result = to_array($value);
        $this->assertEquals(['it', 'is', 'my', 'string'], $result);

        // Передаем строку в стиле CamelCase.
        $value  = 'ItIsMyString';
        $result = to_array($value);
        $this->assertEquals(['It', 'Is', 'My', 'String'], $result);

        // Передаем коллекцию строк с разделителями.
        $value  = collect(['it,is', [['my big', 'big-big'], 'big|big', 'big, big'], [['big_big'], 'BigBig', 'big.string']]);
        $result = to_array($value);
        $this->assertEquals(['it', 'is', 'my', 'big', 'big', 'big', 'big', 'big', 'big', 'big', 'big', 'big', 'Big', 'Big', 'big', 'string'], $result);

        // Передаем функцию.
        $value  = fn () => 'It Is, My| String';
        $result = to_array($value);
        $this->assertEquals(['It', 'Is', 'My', 'String'], $result);
    }

    /**
     * Есть ли функция, приводящее значение к коллекции?
     *
     * @return void
     */
    public function test_to_collect(): void
    {
        // Передаем значение, отличное от массива.
        $value  = 'value';
        $result = to_collect($value)->toArray();
        $this->assertEquals(['value'], $result);

        // Передаем коллекцию.
        $value  = collect(['it', 'is', 'my', 'string']);
        $result = to_collect($value)->toArray();
        $this->assertEquals(['it', 'is', 'my', 'string'], $result);

        // Передаем массив.
        $value  = ['it', 'is', 'my', 'string'];
        $result = to_collect($value)->toArray();
        $this->assertEquals(['it', 'is', 'my', 'string'], $result);

        // Передаем строку с разделителями.
        $value  = 'it_is_my_string';
        $result = to_collect($value)->toArray();
        $this->assertEquals(['it', 'is', 'my', 'string'], $result);

        // Передаем строку в стиле CamelCase.
        $value  = 'ItIsMyString';
        $result = to_collect($value)->toArray();
        $this->assertEquals(['It', 'Is', 'My', 'String'], $result);

        // Передаем коллекцию строк с разделителями.
        $value  = collect(['it,is', [['my big', 'big-big'], 'big|big', 'big, big'], [['big_big'], 'BigBig', 'big.string']]);
        $result = to_collect($value)->toArray();
        $this->assertEquals(['it', 'is', 'my', 'big', 'big', 'big', 'big', 'big', 'big', 'big', 'big', 'big', 'Big', 'Big', 'big', 'string'], $result);

        // Передаем функцию.
        $value  = fn () => 'It Is, My| String';
        $result = to_collect($value)->toArray();
        $this->assertEquals(['It', 'Is', 'My', 'String'], $result);
    }
}

class MyClass
{
    public $a;

    public $b;

    public function __construct($a = null, $b = null)
    {
        $this->a = $a;
        $this->b = $b;
    }
}

class SomeClass
{

}
