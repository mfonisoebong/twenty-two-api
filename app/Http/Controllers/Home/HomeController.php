<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\StoreHeroDetailsRequest;
use App\Http\Requests\Home\UpdateHeroDetailsRequest;
use App\Http\Resources\Home\HeroDetailsResource;
use App\Models\HeroDetails;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use HttpResponses;


    public function viewAll()
    {
        $details = HeroDetails::all();
        $list = HeroDetailsResource::collection($details);

        return $this->success($list);
    }

    public function view(HeroDetails $details)
    {
        return $this->success(new HeroDetailsResource($details));
    }


    public function store(StoreHeroDetailsRequest $request)
    {
        $request->createDetails();
        return $this->success('Hero details created successfully');
    }

    public function update(UpdateHeroDetailsRequest $request, HeroDetails $details)
    {
        $request->updateDetails();
        return $this->success('Hero details updated successfully');
    }

    public function destroy(HeroDetails $details)
    {
        $details->delete();
        return $this->success('Hero details deleted successfully');
    }
}
