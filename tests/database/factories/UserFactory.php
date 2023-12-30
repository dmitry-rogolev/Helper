<?php

namespace dmitryrogolev\Helper\Tests\Database\Factories;

use dmitryrogolev\Helper\Tests\Models\User;
use Orchestra\Testbench\Factories\UserFactory as TestbenchUserFactory;

class UserFactory extends TestbenchUserFactory
{
    /**
     * Имя модели.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model|TModel>
     */
    protected $model = User::class;
}
