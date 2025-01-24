<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\StoreBillingInformationRequest;
use App\Http\Requests\Invoice\UpdateBillingInformationRequest;
use App\Models\BillingInformation;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BillingInformationController extends Controller
{
    use HttpResponses;

    public function store(StoreBillingInformationRequest $request)
    {
        $info = $request->createBillingInfo();
        return $this->success($info, 'Billing information saved successfully');
    }

    public function update(BillingInformation $info, UpdateBillingInformationRequest $request)
    {
        Gate::authorize('update', $info);

        $info = $request->updateInfo();
        return $this->success($info, 'Billing information saved successfully');
    }


    public function viewAll(Request $request)
    {
        $infos = $request
            ->user()
            ->billingInformations()
            ->select([
                'id',
                'first_name',
                'last_name',
                'company_name',
                'apartment',
                'city',
                'phone',
                'email',
                'user_id',
                'is_default'
            ]);

        return $this->success($infos);
    }

    public function view(BillingInformation $info, Request $request)
    {
        Gate::authorize('view', $info);
    }

    public function destroy(BillingInformation $info, Request $request)
    {
        Gate::authorize('delete', $info);

        $info->delete();
        return $this->success(null, 'Billing information deleted successfully');
    }

}
