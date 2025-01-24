<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\SendNotificationRequest;
use App\Http\Resources\Notification\NotificationResource;
use App\Models\Notification;
use App\Models\User;
use App\Notifications\Admin\AdminNotification;
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

    public function sendNotifications(SendNotificationRequest $request)
    {
        $request->sendNotifications();
        return $this->success(null, 'Notifications sent successfully');
    }
}
