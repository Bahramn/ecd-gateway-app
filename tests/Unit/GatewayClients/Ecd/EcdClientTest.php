<?php

namespace Tests\Unit\GatewayClients\Ecd;

use Bahramn\EcdIpg\DTOs\GatewayConfigData;
use Bahramn\EcdIpg\DTOs\PaymentInitData;
use Bahramn\EcdIpg\Exceptions\InvalidApiResponseException;
use Bahramn\EcdIpg\Gateways\Ecd\DTOs\EcdConfirmResponseData;
use Bahramn\EcdIpg\Gateways\Ecd\DTOs\EcdInitializeRequestData;
use Bahramn\EcdIpg\Gateways\Ecd\DTOs\EcdInitializeResponseData;
use Bahramn\EcdIpg\Gateways\Ecd\DTOs\EcdReverseResponseData;
use Bahramn\EcdIpg\Gateways\Ecd\DTOs\EcdTransactionsParamsData;
use Bahramn\EcdIpg\Gateways\Ecd\EcdClient;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;

/**
 * @package Tests\Unit\GatewayClients\Ecd
 */
class EcdClientTest extends TestCase
{
    /**
     * @test
     * @throws InvalidApiResponseException|BindingResolutionException
     */
    public function it_should_have_success_response_with_token_in_initial_payment_request()
    {
        $client = $this->app->make(EcdClient::class, ['handler' => new EcdMockHandler()]);
        $data = (new EcdInitializeRequestData)
            ->setConfig($this->getEcdGatewayConfigData()->attributes)
            ->setInitPaymentData($this->makeInitPaymentData())
            ->make();

        $initialResponse = $client->initialPayment($data);

        $this->assertInstanceOf(EcdInitializeResponseData::class, $initialResponse);
        $this->assertEquals(true, $initialResponse->isSuccess());
        $this->assertNotEmpty($initialResponse->getToken());
        $this->assertIsString($initialResponse->getToken());
    }

    /**
     * @test
     * @throws InvalidApiResponseException|BindingResolutionException
     */
    public function it_should_not_be_success_in_initial_request_with_invalid_data()
    {
        $client = $this->app->make(EcdClient::class, ['handler' => new EcdMockHandler()]);
        $initPaymentData = $this->makeInitPaymentData();
        $initPaymentData->setDescription('error');
        $data = (new EcdInitializeRequestData)
            ->setConfig($this->getEcdGatewayConfigData()->attributes)
            ->setInitPaymentData($initPaymentData)
            ->make();

        $initialResponse = $client->initialPayment($data);

        $this->assertInstanceOf(EcdInitializeResponseData::class, $initialResponse);
        $this->assertFalse($initialResponse->isSuccess());
        $this->assertEquals(__('ecd-ipg::messages.ecd_error_codes.101'), $initialResponse->getMessage());
    }

    /**
     * @test
     * @throws BindingResolutionException
     */
    public function it_should_throw_invalid_api_exception_when_getting_invalid_response_in_initial_payment_request()
    {
        $client = $this->app->make(EcdClient::class, ['handler' => new EcdMockHandler()]);
        $initPaymentData = $this->makeInitPaymentData();
        $initPaymentData->setDescription('invalid');
        $data = (new EcdInitializeRequestData)
            ->setConfig($this->getEcdGatewayConfigData()->attributes)
            ->setInitPaymentData($initPaymentData)
            ->make();

        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage("Invalid response received from ECD-Gateway API");
        $client->initialPayment($data);
    }

    /**
     * @test
     */
    public function it_should_get_success_response_in_confirm_request()
    {
        $token = '8F8D4271609BDCD3B7B67F4BC45419A6076E9D75';
        $paymentUuid = $this->faker->uuid;
        $client = $this->app->make(EcdClient::class, ['handler' => new EcdMockHandler()]);

        $confirmData = $client->confirm($token, $paymentUuid);

        $this->assertInstanceOf(EcdConfirmResponseData::class, $confirmData);
        $this->assertTrue($confirmData->isConfirmed());
        $this->assertEquals(__('ecd-ipg::messages.success'), $confirmData->getMessage());
    }

    /**
     * @test
     */
    public function it_should_throw_exception_by_invalid_response_in_confirm_request()
    {
        $token = 'invalid';
        $paymentUuid = $this->faker->uuid;
        $client = $this->app->make(EcdClient::class, ['handler' => new EcdMockHandler()]);

        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage("Invalid response received from ECD-Gateway API");

        $client->confirm($token, $paymentUuid);
    }

    /**
     * @test
     */
    public function it_should_not_confirmed_when_unknown_token_requested_in_confirm_response()
    {
        $token = 'error';
        $paymentUuid = $this->faker->uuid;
        $client = $this->app->make(EcdClient::class, ['handler' => new EcdMockHandler()]);

        $result = $client->confirm($token, $paymentUuid);

        $this->assertFalse($result->isConfirmed());
        $this->assertEquals(__('ecd-ipg::messages.ecd_error_codes.111'), $result->getMessage());
    }

    /**
     * @test
     */
    public function it_should_have_success_response_with_valid_token_in_revere_request()
    {
        $token = '8F8D4271609BDCD3B7B67F4BC45419A6076E9D75';
        $paymentUuid = $this->faker->uuid;
        $client = $this->app->make(EcdClient::class, ['handler' => new EcdMockHandler()]);

        $result = $client->reverse($token, $paymentUuid);

        $this->assertInstanceOf(EcdReverseResponseData::class, $result);
        $this->assertTrue($result->hasReversed());
        $this->assertEquals(__('ecd-ipg::messages.reversed'), $result->getMessage());
    }

    /**
     * @test
     */
    public function it_should_has_not_revered_with_invalid_token_in_reverse_request()
    {
        $token = 'error';
        $paymentUuid = $this->faker->uuid;
        $client = $this->app->make(EcdClient::class, ['handler' => new EcdMockHandler()]);

        $result = $client->reverse($token, $paymentUuid);

        $this->assertInstanceOf(EcdReverseResponseData::class, $result);
        $this->assertFalse($result->hasReversed());
        $this->assertEquals(__('ecd-ipg::messages.ecd_error_codes.113'), $result->getMessage());
    }

    /**
     * @test
     */
    public function it_should_throw_exception_by_invalid_response_in_reveres_request()
    {
        $token = 'invalid';
        $paymentUuid = $this->faker->uuid;
        $client = $this->app->make(EcdClient::class, ['handler' => new EcdMockHandler()]);

        $this->expectException(InvalidApiResponseException::class);
        $this->expectExceptionMessage("Invalid response received from ECD-Gateway API");

        $client->reverse($token, $paymentUuid);
    }

    /**
     * @test
     */
    public function it_should_make_proper_params_for_get_transactions()
    {
        $client = $this->app->make(EcdClient::class, ['handler' => new EcdMockHandler()]);

        $data = new EcdTransactionsParamsData();

        $client->transactions($data);
        $this->assertArrayHasKey('TerminalNumber', $data->getParams());
        $this->assertArrayHasKey('Key', $data->getParams());


    }


//    /**
//     * @test
//     */
//    public function it_should_create_callback_data_object_by_request()
//    {
//        $json = file_get_contents(__DIR__ . '/responses/callback-request-success.json');
//        request()->request->add(json_decode($json, true));
//
//    }

    private function getEcdGatewayConfigData(): GatewayConfigData
    {
        return new GatewayConfigData(config('ecd-ipg.gateways.ecd'));
    }

    private function makeInitPaymentData(): PaymentInitData
    {
        return (new PaymentInitData)
            ->setUniqueId($this->faker->uuid)
            ->setNid($this->faker->nationalId)
            ->setAmount($this->faker->randomNumber())
            ->setMobile($this->faker->mobileNumber)
            ->setCurrency($this->faker->currencyCode)
            ->setDescription($this->faker->sentence);
    }
}
