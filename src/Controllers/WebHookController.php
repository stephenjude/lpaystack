<?php

namespace Unicodeveloper\Paystack\Controllers;

use Illuminate\Routing\Controller;
use Unicodeveloper\Paystack\Model\PaystackEvent;
use Unicodeveloper\Paystack\Request\WebHookRequest;

class WebHookController extends Controller
{
    /**
     * Handles the WebHook Request
     *
     * @param WebHookRequest $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function handleWebHook(WebHookRequest $request)
    {
        $data = $this->getFormattedPayload($request->all());

        $paystackEvent = PaystackEvent::create($data);

        event($data['event'], $paystackEvent);

        return response([], 200);
    }

    /**
     * Retrieves a formatted payload data
     *
     * @param array $newData
     * @return array
     */
    protected function getFormattedPayload(array $newData): array
    {
        $data = $newData['data'];

        return [
            'event'  => $newData['event'],
            'payload' => $data,
        ];
    }
}
