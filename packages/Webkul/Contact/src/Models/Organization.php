<?php

namespace Webkul\Contact\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Attribute\Traits\CustomAttribute;
use Webkul\Contact\Contracts\Organization as OrganizationContract;
use Webkul\User\Models\UserProxy;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model implements OrganizationContract
{
    use CustomAttribute, HasFactory;

    protected $casts = [
        'address' => 'array',
    ];

    protected $fillable = [
        'name',
        'address',
        'user_id',
    ];

    public function persons()
    {
        return $this->hasMany(PersonProxy::modelClass());
    }

    public function user()
    {
        return $this->belongsTo(UserProxy::modelClass());
    }

    protected static function newFactory()
    {
        return \Database\Factories\OrganizationFactory::new();
    }
}
