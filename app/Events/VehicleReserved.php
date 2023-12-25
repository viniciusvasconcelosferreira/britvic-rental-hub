<?php

namespace App\Events;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VehicleReserved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $vehicle;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param Vehicle $vehicle
     */
    public function __construct(User $user, Vehicle $vehicle)
    {
        $this->user = $user;
        $this->vehicle = $vehicle;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
