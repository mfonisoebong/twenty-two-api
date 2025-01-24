<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\StoreSubscriberRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class NewsletterSubscribersController extends Controller
{
    use HttpResponses;

    public function store(StoreSubscriberRequest $request)
    {
        $request->createSubscriber();

        return $this->success(null, 'You have successfully subscribed to our newsletter.');
    }
}
