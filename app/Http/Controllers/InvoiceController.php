<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Bahramn\EcdIpg\DTOs\InitPaymentData;
use Bahramn\EcdIpg\DTOs\PaymentInitData;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Bahramn\EcdIpg\Payment\PaymentManagerInterface;
use Bahramn\EcdIpg\Exceptions\PaymentInitializeFailedException;

class InvoiceController extends Controller
{
    private PaymentManagerInterface $paymentManager;

    public function __construct(PaymentManagerInterface $paymentManager)
    {
        $this->paymentManager = $paymentManager;
    }

    /**
     * @param Request $request
     * @return Response|View|mixed
     */
    public function store(Request $request)
    {
        $invoice = $this->createInvoice($request);
        try {
            $initPaymentData = (new PaymentInitData)
                ->setAmount($invoice->amount())
                ->setDescription("Test payment")
                ->setCurrency($invoice->currency())
                ->setMobile($request->input('mobile'))
                ->setNid($request->input('nid'));

            return $this->paymentManager->setPayable($invoice)
                ->readyInitialize($initPaymentData)
                ->initialize()
                ->getResponse();
        } catch (PaymentInitializeFailedException $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * @param Request $request
     * @return Invoice
     */
    private function createInvoice(Request $request): Invoice
    {
        return Invoice::create([
            'total_amount' => $request->input('total_amount') ?? 10000,
            'status' => Invoice::STATUS_PENDING,
            'uuid' => Str::uuid()->toString()
        ]);
    }
}
