<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomAvailability extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [
        'id'
    ];

    /**
     * Get the user that owns the RoomAvailability
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    /**
     * Get the kost that owns the RoomAvailability
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kost()
    {
        return $this->belongsTo(\App\Models\Kost::class, 'kost_id', 'id');
    }
}
