<?php

namespace App\Http\Requests\Overview;

use App\Http\Resources\Invoice\RecentSaleResource;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use App\Traits\Date;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class OverviewRequest extends FormRequest
{
    use Date;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [];
    }

    public function getOverviewData()
    {

        $totalRevenueThisMonth = Invoice::where('status', '!=', 'pending')
            ->where('status', '!=', 'cancelled')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount_paid');
        $totalRevenueLastMonth = Invoice::where('status', '!=', 'pending')
            ->where('status', '!=', 'cancelled')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount_paid');
        $percentChange = $totalRevenueLastMonth ? (($totalRevenueThisMonth - $totalRevenueLastMonth) / $totalRevenueLastMonth) * 100 : 0;
        $percent = $percentChange > 0 ? '+' . $percentChange . '%' : $percentChange . '%';

        $customers = User::count() > 100_000_000 ? '100M+' : User::count();
        $totalSalesThisMonth = Invoice::where('status', '!=', 'pending')
            ->where('status', '!=', 'cancelled')
            ->whereMonth('created_at', now()->month)
            ->count();
        $activeProducts = Product::count();


        return [
            'total_revenue_this_month' => currency_format($totalRevenueThisMonth),
            'percent_change' => $percent,
            'customers' => $customers,
            'total_sales_this_month' => $totalSalesThisMonth,
            'active_products' => $activeProducts
        ];
    }

    public function getOverviewStats()
    {
        $monthlySales = [];

        foreach ($this->months as $month => $label) {

            $amount = Invoice::whereMonth('created_at', $month)
                ->whereYear('created_at', Carbon::now()->year)
                ->where('status', '!=', 'pending')
                ->where('status', '!=', 'cancelled')
                ->sum('amount_paid');


            $amountPaid = (float)$amount;

            array_push($monthlySales, [
                'month' => $label,
                'amount' => $amountPaid
            ]);
        }

        return $monthlySales;
    }

    public function getRecentSales()
    {

        $sales = Invoice::where('status', '!=', 'pending')
            ->where('status', '!=', 'cancelled')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->latest()
            ->limit(6)
            ->get();

        $recentSales = RecentSaleResource::collection($sales);

        return $recentSales;
    }
}
