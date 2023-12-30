<?php

namespace dmitryrogolev\Helper\Tests\Models;

use dmitryrogolev\Helper\Tests\Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;

class User extends Model
{
    use HasFactory;

    /**
     * Атрибуты, для которых НЕ разрешено массовое присвоение значений.
     *
     * @var array<string>
     */
    protected $guarded = [];

    /**
     * Создайте новый экземпляр фабрики для модели.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
