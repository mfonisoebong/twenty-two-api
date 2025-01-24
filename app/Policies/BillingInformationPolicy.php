<?php

namespace App\Policies;

use App\Models\BillingInformation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BillingInformationPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BillingInformation $billingInformation): bool
    {
        return (int)$user->id === (int)$billingInformation->user_id;
    }


    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BillingInformation $billingInformation): bool
    {
        return (int)$user->id === (int)$billingInformation->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BillingInformation $billingInformation): bool
    {
        return (int)$user->id === (int)$billingInformation->user_id;
    }
    
}
