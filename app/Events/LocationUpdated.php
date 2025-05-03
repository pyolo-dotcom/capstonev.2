<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LocationUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $truckId;
    public $locationData;

    public function __construct($truckId, $locationData)
    {
        $this->truckId = $truckId;
        $this->locationData = $locationData;
    }

    public function broadcastOn()
    {
        return new Channel('tracking');
    }

    public function broadcastAs()
    {
        return 'location.updated';
    }

    public function broadcastWith()
    {
        return [
            'truck_id' => $this->truckId,
            'location' => $this->locationData,
            'timestamp' => now()->toDateTimeString() // Add timestamp
        ];
    }
}