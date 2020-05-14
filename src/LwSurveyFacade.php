<?php

namespace VictorYoalli\LwSurvey;

use Illuminate\Support\Facades\Facade;

/**
 * @see \VictorYoalli\LwSurvey\Skeleton\SkeletonClass
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
