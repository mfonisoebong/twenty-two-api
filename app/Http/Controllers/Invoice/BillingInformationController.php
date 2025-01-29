<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoice\StoreBillingInformationRequest;
use App\Http\Requests\Invoice\UpdateBillingInformationRequest;
use App\Http\Resources\Invoice\BillingResource;
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

    public function viewDefault(Request $request)
    {
        $info = $request
            ->user()
            ->billingInformations()
            ->where('is_default', true)
            ->exists() ?
            $request->user()->billingInformations()->where('is_default', true)->first() :
            $request->user()->billingInformations()->first();

        $data = $info ? new BillingResource($info) : null;

        return $this->success($data);
    }

    public function viewAll(Request $request)
    {
        $infos = $request
            ->user()
            ->billingInformations;

        $data = BillingResource::collection($infos);

        return $this->success($data);
    }

    public function view(BillingInformation $info, Request $request)
    {
        Gate::authorize('view', $info);
        $data = new BillingResource($info);
        return $this->success($data);
    }

    public function destroy(BillingInformation $info, Request $request)
    {
        Gate::authorize('delete', $info);

        $info->delete();
        return $this->success(null, 'Billing information deleted successfully');
    }

}
