<?php

namespace App\Http\Controllers\Newsletter;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Newsletter\StoreSubscriberRequest;
use App\Models\NewsletterSubscriber;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class NewsletterSubscribersController extends Controller
{
    use HttpResponses;

    public function store(StoreSubscriberRequest $request)
    {

        NewsletterSubscriber::create([
            'email' => $request->email ?? null,
            'phone' => $request->phone ? $request->dial_code . $request->phone : null,
        ]);

        return $this->success(null, 'Subscriber added successfully', StatusCode::Success->value);
    }
}
