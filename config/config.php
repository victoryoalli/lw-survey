<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'models' => [
        'user' => 'App\Models\User',
        'survey' => 'App\Models\Survey',
        'user_id' => 'user_id',
        'survey_id' => 'survey_id',
    ],
    'database' => [
        'tables' => [
            'surveys' => 'lw_surveys',
            'survey_types' => 'lw_survey_types',
            'question_types' => 'lw_question_types',
            'sections' => 'lw_sections',
            'questions' => 'lw_questions',
            'options' => 'lw_options',
            'entries' => 'lw_entries',
            'answers' => 'lw_answers',
        ]
    ],
];
