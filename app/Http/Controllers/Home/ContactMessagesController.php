<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\StoreContactMessageRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ContactMessagesController extends Controller
{

    use HttpResponses;
    public function store(StoreContactMessageRequest $request)
    {
        $request->createMessage();

        return $this->success(null, 'Your message has been sent successfully.');
    }
}
