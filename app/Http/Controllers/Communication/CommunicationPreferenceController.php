<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Communication\StorePreferencesRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class CommunicationPreferenceController extends Controller
{
    use HttpResponses;

    public function viewAll(Request $request)
    {
        $user = $request->user();
        $preferences = explode(',', $user->communication_preference);
        $preferences = $preferences[0] === '' ? [] : $preferences;

        return $this->success($preferences);
    }

    public function save(StorePreferencesRequest $request)
    {
        $request->savePreferences();
        return $this->success('Preferences saved successfully');
    }
}
