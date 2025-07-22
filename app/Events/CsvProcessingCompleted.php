<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CsvProcessingCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $uploadId;
    /**
     * Create a new event instance.
     */
    public function __construct($uploadId)
    {
        $this->uploadId = $uploadId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('uploads.' . $this->uploadId);
    }

    public function broadcastWith()
    {
        return [
            'upload_id' => $this->uploadId,
            'message' => 'Your file upload has been processed successfully!'
        ];
    }
}
