<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class ActivitySaving
{
    use Dispatchable;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        // material for xp calculation
        $km = $event->km;
        $multiplier = $event->activityType->multiplier;

        // add the calculation
        $event->xp = $km*$multiplier;
    }
}
