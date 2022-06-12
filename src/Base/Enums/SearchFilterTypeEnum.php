<?php

namespace Base\Enums;

enum SearchFilterTypeEnum: string
{
    case WHERE = 'where';
    case OR_WHERE = 'orWhere';
    case WHERE_FULLTEXT = 'whereFullText';
    case OR_WHERE_FULLTEXT = 'orWhereFullText';
}
