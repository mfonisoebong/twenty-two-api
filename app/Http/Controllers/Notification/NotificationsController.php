<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Notification;
use App\Traits\HttpResponses;
use App\Traits\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NotificationsController extends Controller
{
    use HttpResponses, Pagination;

    public function markAsRead(Notification $notification, Request $request)
    {
        Gate::authorize('update', $notification);
        $notification->update([
            'read_at' => now()
        ]);
        return $this->success($notification);
    }

    public function viewAll(Request $request)
    {
        $notifications = $request->user()->notifications()->paginate(3);
        $list = NotificationResource::collection($notifications);

        $data = $this->paginatedData($notifications, $list);

        return $this->success($data);
    }
}
