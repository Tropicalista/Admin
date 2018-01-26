<?php

namespace Tropicalista\Admin\Tests;

use Tropicalista\Admin\Facades\Admin;
use Tropicalista\Admin\ServiceProvider;
use Orchestra\Testbench\TestCase;

class AdminTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'admin' => Admin::class,
        ];
    }

    public function testExample()
    {
        assertEquals(1, 1);
    }
}
