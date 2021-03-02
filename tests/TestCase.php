<?php

namespace Tests;

use App\Models\Invoice;
use Database\Factories\InvoiceFactory;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    /**
     * @var Generator|IranCustomFakerProvider
     */
    protected Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();

    }

    protected function createPayable(): Invoice
    {
        return InvoiceFactory::new()->statusNew()->create();
    }

    private function setUpFaker()
    {
        $this->faker = Factory::create();
        $this->faker->addProvider(new IranCustomFakerProvider($this->faker));
    }


}
