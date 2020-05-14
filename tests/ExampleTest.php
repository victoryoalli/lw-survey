<?php

namespace VictorYoalli\LwSurvey\Tests;

use Orchestra\Testbench\TestCase;
use VictorYoalli\LwSurvey\LwSurveyServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LwSurveyServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
