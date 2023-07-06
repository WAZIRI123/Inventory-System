<?php
namespace App\Models\Traits;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait Multitenantable
{
    protected static function bootMultitenantable(): void
    {
        $user_branch=User::find(auth()->id())->branch_id;
        static::creating(function ($model) use ($user_branch) {
        $model->branch_id =  $user_branch;
        });

        static::addGlobalScope('created_by_user_id', function (Builder $builder) use ($user_branch) {
            $builder->where('branch_id',$user_branch);
        });
    }
}