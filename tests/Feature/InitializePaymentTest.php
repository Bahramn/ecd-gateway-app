<?php

namespace Tests\Feature;

use Bahramn\EcdIpg\DTOs\PaymentInitData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InitializePaymentTest extends TestCase
{
    /**
     * @test
     */
    public function create_payment_initialize_data_from_payable()
    {
        $payable = $this->createPayable();
        $mobile = $this->faker->mobileNumber;
        $nid = $this->faker->nationalId;
        $description = $this->faker->sentence;

        $initPaymentData = (new PaymentInitData)
            ->setNid($nid)
            ->setMobile($mobile)
            ->setDescription($description)
            ->setAmount($payable->amount())
            ->setCurrency($payable->currency());

        $this->assertEquals($nid, $initPaymentData->getNid());
        $this->assertEquals($mobile, $initPaymentData->getMobile());
        $this->assertEquals($description, $initPaymentData->getDescription());
        $this->assertEquals($payable->amount(), $initPaymentData->getAmount());
        $this->assertEquals($payable->currency(), $initPaymentData->getCurrency());
    }


}
