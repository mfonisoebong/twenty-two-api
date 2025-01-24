<?php

namespace App\Http\Controllers\Newsletter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Newsletter\StoreSubscriptionRequest;
use App\Traits\HttpResponses;
use App\Traits\Pagination;
use Illuminate\Http\Request;

class NewsletterSubscriptionController extends Controller
{
    use HttpResponses, Pagination;


    public function store(StoreSubscriptionRequest $request)
    {
        $request->addSubscription();
        return $this->success(null, 'Subscription added successfully');
    }
}
