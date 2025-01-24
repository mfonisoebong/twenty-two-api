<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Invoice\RecentPurchaseResource;
use App\Http\Resources\Invoice\SaleResource;
use App\Http\Resources\User\UserListResource;
use App\Models\User;
use App\Notifications\User\StatusUpdated;
use App\Traits\HttpResponses;
use App\Traits\Pagination;
use App\Traits\UploadFiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    use HttpResponses, Pagination, UploadFiles;


    public function viewAll()
    {
        $users = User::filter()->paginate(15);

        $usersList = UserListResource::collection($users);

        $usersData = $this->paginatedData($users, $usersList);

        return $this->success($usersData);
    }

    public function view(User $user)
    {

        $recentPurchaes = DB::table('invoices')
            ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->join('products', 'invoice_items.product_id', '=', 'products.id')
            ->select('invoices.created_at', 'invoices.id', 'products.name', 'products.featured_image', 'invoice_items.unit_price', 'invoice_items.quantity', 'invoices.trx_id')
            ->where('invoices.user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        $purchases = RecentPurchaseResource::collection($recentPurchaes);


        $data = [
            'id' => (string)$user->id,
            'name' => $user->full_name,
            'email' => $user->email,
            'phone' => $user->phone,
            'role' => $user->role,
            'status' => $user->status,
            'avatar' => $this->getFilePath($user->avatar),
            'created_at' => $user->created_at->format('Y-m-d'),
            'invoices' => $purchases,
        ];

        return $this->success($data);
    }

    public function updateStatus(User $user, string $status)
    {
        $user->update(['status' => $status]);
        $user->notify(new StatusUpdated());

        return $this->success(['message' => 'User status updated successfully']);
    }
}
