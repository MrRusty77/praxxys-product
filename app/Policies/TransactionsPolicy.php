<?php

namespace App\Policies;

use App\Models\Transactions;
use App\Models\Users;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Users $users)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Users  $users
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Users $users, Transactions $transactions)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Users $users)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Users  $users
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Users $users, Transactions $transactions)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Users  $users
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Users $users, Transactions $transactions)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Users  $users
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Users $users, Transactions $transactions)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Users  $users
     * @param  \App\Models\Transactions  $transactions
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Users $users, Transactions $transactions)
    {
        //
    }
}
