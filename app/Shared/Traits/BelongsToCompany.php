<?php

namespace App\Shared\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait BelongsToCompany
{
    public static function bootBelongsToCompany(): void
    {
        // 1. FILTRO AUTOMÁTICO: En cualquier consulta, añade el 'where company_id'
        static::addGlobalScope('company', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where('company_id', Auth::user()->company_id);
            }
        });

        // 2. ASIGNACIÓN AUTOMÁTICA: Al crear un registro, le inyecta el company_id del usuario logueado
        static::creating(function ($model) {
            if (Auth::check() && ! $model->company_id) {
                $model->company_id = Auth::user()->company_id;
            }
        });
    }
}