<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\StoreBillingInformationRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class BillingInformationController extends Controller
{
    use HttpResponses;

    public function saveBillingInformation(StoreBillingInformationRequest $request)
    {
        $request->updateOrStoreBillingInformation();
        return $this->success(null, 'Billing information saved successfully');
    }


    public function view(Request $request)
    {
        $billingInformation = $request
            ->user()
            ->billingInformation
            ?->only(['first_name', 'last_name', 'company_name', 'apartment', 'city', 'phone', 'email']);

        return $this->success($billingInformation);
    }

}
