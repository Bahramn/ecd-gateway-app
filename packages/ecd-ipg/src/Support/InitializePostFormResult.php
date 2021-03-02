<?php

namespace Bahramn\EcdIpg\Support;

use Bahramn\EcdIpg\Support\Interfaces\InitializeResultInterface;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * @package Bahramn\EcdIpg\Payment
 */
class InitializePostFormResult implements InitializeResultInterface
{
    private string $actionURL;
    private array $formData;

    /**
     * InitializePostFormResult constructor.
     *
     * @param string $actionURL
     * @param array $formData
     */
    public function __construct(string $actionURL, array $formData)
    {
        $this->actionURL = $actionURL;
        $this->formData = $formData;
    }

    /**
     * Returns the type of the result.
     *
     * @return string
     */
    public function getType(): string
    {
        return 'postForm';
    }

    /**
     * Returns the URL that we should redirect the user to.
     *
     * @return string
     */
    public function getURL(): string
    {
        return $this->actionURL;
    }

    /**
     * Returns the response corresponding to this result.
     *
     * @return Factory|Response|View
     */
    public function getResponse()
    {
        return view('vendor.ecd-gateway.post-form', [
            'data' => $this,
        ]);
    }

    /**
     * @return array
     */
    public function getFormData(): array
    {
        return $this->formData;
    }

    /**
     * Returns the additional data that may the initialize result has.
     *
     * @return array
     */
    public function getAdditionalData(): array
    {
        return array_map(fn ($value, $key) => [
                'key' => $key,
                'value' => $value,
            ], $this->formData, array_keys($this->formData));
    }
}
