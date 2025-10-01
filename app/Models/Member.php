<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'organization_id',
        'name',
        'email',
        'whatsapp',
        'birth_date',
        'parent_name',
        'parent_phone',
        'type',
        'status',
        'entry_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'entry_date' => 'date',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function ministries(): BelongsToMany
    {
        return $this->belongsToMany(Ministry::class, 'member_ministry')
            ->withPivot('joined_at', 'left_at')
            ->withTimestamps();
    }
}
