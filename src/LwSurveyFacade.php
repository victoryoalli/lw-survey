<?php

namespace Victoryoalli\LwSurvey;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Victoryoalli\LwSurvey\Skeleton\SkeletonClass
 */
class LwSurveyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'lw-survey';
    }
}
