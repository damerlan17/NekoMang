<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    public function createApplication()
    {
        $app = parent::createApplication();

        if (!$app->environment('testing')) {
            throw new RuntimeException(
                'Тестирование разрешено только в окружении testing.'
            );
        }

        if (config('database.default') !== 'mysql') {
            throw new RuntimeException(
                'Для тестирования необходимо подключение MySQL.'
            );
        }

        $database = DB::selectOne(
            'SELECT DATABASE() AS db'
        )->db;

        if ($database !== 'nekomang_testing') {
            throw new RuntimeException(
                'Тестирование остановлено: выбрана неправильная база данных.'
            );
        }

        return $app;
    }
}
