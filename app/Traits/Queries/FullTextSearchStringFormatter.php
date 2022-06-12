<?php

namespace App\Traits\Queries;

trait FullTextSearchStringFormatter
{
    protected function format(string|array $search): string
    {
        if (is_array($search)) {
            $search = implode(" ", $search);
        }

        $strings = explode(' ', $search);
        return implode('* ', $strings).'*';
    }
}
