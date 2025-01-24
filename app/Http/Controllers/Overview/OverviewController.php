<?php

namespace App\Http\Controllers\Overview;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Overview\OverviewRequest;
use App\Traits\HttpResponses;


class OverviewController extends Controller
{

    use HttpResponses;


    public function __invoke(OverviewRequest $request)
    {
        $overview = $request->getOverviewData();
        $overviewStats = $request->getOverviewStats();
        $recentSales = $request->getRecentSales();

        $data = [
            'overview' => $overview,
            'overview_stats' => $overviewStats,
            'recent_sales' => $recentSales
        ];

        return $this->success($data);
    }}
