<?php

namespace App\Models\Scopes;

use App\Facades\AnonymousUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ForCurrentAnonymousUser implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        //
        $builder->where('anonymous_user_id', AnonymousUser::getCurrentUser()->id);
    }
}
