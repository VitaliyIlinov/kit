<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 * @property int $id
 * @property int $code
 * @property string $symbol
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Symbol extends Model
{
    protected $fillable = [
        'code',
        'symbol',
    ];
}
