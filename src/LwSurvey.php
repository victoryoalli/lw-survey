<?php

namespace VictorYoalli\LwSurvey;

use Illuminate\Support\Facades\App;

class LwSurvey
{
    public function routes()
    {
        App::make('router')->livewire('surveys', 'survey');
    }
}
