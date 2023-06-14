<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 * @property int $id
 * @property int $from
 * @property string $to
 * @property float $best_rate
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Course extends Model
{
    protected $fillable = [
        'from',
        'to',
        'best_rate',
    ];
}
