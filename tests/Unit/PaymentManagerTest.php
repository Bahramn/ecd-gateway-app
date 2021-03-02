<?php

namespace Tests\Unit;

use App\Models\Invoice;
use Bahramn\EcdIpg\DTOs\PaymentInitData;
use Bahramn\EcdIpg\Exceptions\PaymentGatewayException;
use Bahramn\EcdIpg\Payment\PaymentManager;
use Bahramn\EcdIpg\Payment\PaymentManagerInterface;
use Bahramn\EcdIpg\Traits\Payable;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class PaymentManagerTest extends TestCase
{
    private PaymentManager $paymentManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->paymentManager = $this->app->make(PaymentManager::class);
    }
    /**
    * @test
    */
    public function it_should_set_default_gateway_without_determining_gateway()
    {
        $payable = $this->createPayable();
        $paymentInitData = $this->makePaymentInitData($payable);
        $defaultGatewayName = config('ecd-ipg.default_gateway');

        $this->paymentManager->setPayable($payable)->readyInitialize($paymentInitData);
        $this->assertEquals($this->paymentManager->getGatewayName(), $defaultGatewayName);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_gateway_is_not_active()
    {
        $payable = $this->createPayable();
        $paymentInitData = $this->makePaymentInitData($payable);
        Config::set('ecd-ipg.gateways.ecd.active', false);

        $this->expectException(PaymentGatewayException::class);
        $this->paymentManager->setPayable($payable)->readyInitialize($paymentInitData);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_invalid_gateway_has_been_set()
    {
        $payable = $this->createPayable();
        $paymentInitData = $this->makePaymentInitData($payable);

        $this->expectException(PaymentGatewayException::class);
        $this->paymentManager->setGatewayName($this->faker->name)
            ->setPayable($payable)
            ->readyInitialize($paymentInitData);
    }

    private function makePaymentInitData(Invoice $payable): PaymentInitData
    {
        return (new PaymentInitData)
            ->setNid($this->faker->nationalId)
            ->setMobile($this->faker->mobileNumber)
            ->setDescription($this->faker->sentence)
            ->setAmount($payable->amount())
            ->setCurrency($payable->currency());
    }
}
