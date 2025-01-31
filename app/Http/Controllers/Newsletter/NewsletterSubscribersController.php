<?php

namespace App\Http\Controllers\Newsletter;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Newsletter\StoreSubscriberRequest;
use App\Http\Resources\Newsletter\SubscriberResource;
use App\Models\NewsletterSubscriber;
use App\Traits\HttpResponses;
use App\Traits\Pagination;
use Illuminate\Http\Request;

class NewsletterSubscribersController extends Controller
{
    use HttpResponses, Pagination;

    public function store(StoreSubscriberRequest $request)
    {
        NewsletterSubscriber::create([
            'email' => $request->email ?? null,
            'phone' => $request->phone ? $request->dial_code . $request->phone : null,
        ]);
        return $this->success(null, 'Subscriber added successfully', StatusCode::Success->value);
    }

    public function viewAll()
    {
        $subscribers = NewsletterSubscriber::latest()->paginate(12);
        $list = SubscriberResource::collection($subscribers);

        $data = $this->paginatedData($subscribers, $list);

        return $this->success($data);
    }

    public function exportCsv()
    {
        $subscribers = NewsletterSubscriber::all();
        $filename = 'subscribers.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Email', 'Phone', 'Created At']);

        foreach ($subscribers as $subscriber) {
            fputcsv($handle, [$subscriber->email, $subscriber->phone, $subscriber->created_at]);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
        ];

        return response()->download($filename, 'subscribers.csv', $headers);
    }
}
