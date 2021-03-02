<?php

namespace Bahramn\EcdIpg\Http\Controllers;

use App\Http\Controllers\Controller;
use Bahramn\EcdIpg\Exceptions\PaymentConfirmationFailedException;
use Bahramn\EcdIpg\Exceptions\PaymentGatewayException;
use Bahramn\EcdIpg\Exceptions\TransactionHasBeenAlreadyFailedException;
use Bahramn\EcdIpg\Exceptions\TransactionHasBeenAlreadyPaidException;
use Bahramn\EcdIpg\Payment\PaymentManagerInterface;
use Illuminate\Http\Request;

/**
 * @package Bahramn\EcdIpg\Http\Controller
 */
class TransactionCallbackController extends Controller
{

    private PaymentManagerInterface $paymentManager;

    public function __construct(PaymentManagerInterface $paymentManager)
    {
        $this->paymentManager = $paymentManager;
    }

    public function __invoke(string $gateway, Request $request)
    {
        try {
            $transaction = $this->paymentManager
                ->setGatewayName($gateway)
                ->readyConfirmation($request->input('transaction_id'))
                ->confirm();

        } catch (PaymentConfirmationFailedException $e) {

        } catch (PaymentGatewayException $e) {

        } catch (TransactionHasBeenAlreadyFailedException $e) {

        } catch (TransactionHasBeenAlreadyPaidException $e) {

        }

        return redirect(config('ecd-ipg.after_payment.success_redirect_url'), [
            config('ecd-ipg.after_payment.transaction_uuid_param_name') => $transaction->uuid
        ]);
    }
}
