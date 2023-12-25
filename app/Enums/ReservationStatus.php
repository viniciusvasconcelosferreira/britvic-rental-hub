<?php

namespace App\Enums;

use Spatie\Enum\Enum;

/**
 * @method static self PENDING()
 * @method static self CONFIRMED()
 * @method static self IN_PROGRESS()
 * @method static self COMPLETED()
 * @method static self CANCELLED()
 */
class ReservationStatus extends Enum
{
}
