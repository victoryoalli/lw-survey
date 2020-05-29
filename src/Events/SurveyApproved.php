<?php

namespace VictorYoalli\LwSurvey\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use VictorYoalli\LwSurvey\Models\Entry;
use VictorYoalli\LwSurvey\Models\Survey;

class SurveyApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $entry;
    public $survey;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Survey $survey, Entry $entry)
    {
        $this->entry = $entry;
        $this->survey = $survey;
    }

    
}