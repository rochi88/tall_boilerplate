<?php

declare(strict_types=1);

namespace App\Enums;

enum MySQLError: int
{
    public static function getMessage(int $code): ?string
    {
        return match ($code) {
            self::ER_DUP_ENTRY => 'Duplicate entry violation for a unique key constraint',
            self::ER_BAD_NULL_ERROR => 'Column cannot be null and a null value is being inserted',
            self::ER_ACCESS_DENIED_ERROR => 'Access denied for a user to a particular database',
            self::ER_BAD_FIELD_ERROR => 'Unknown column in a query',
            self::ER_PARSE_ERROR => 'Syntax error in SQL query',
            self::ER_CANNOT_ADD_FOREIGN => 'Cannot add a foreign key constraint',
            self::ER_NO_REFERENCED_ROW => 'Cannot add or update a child row: foreign key constraint fails',
            self::ER_NO_SUCH_TABLE => 'Table does not exist',
            self::ER_NO_DEFAULT_FOR_FIELD => 'Field does not have a default value and is not nullable',
            self::ER_TRUNCATED_WRONG_VALUE => 'Incorrect integer value: a string is being inserted into an integer column',
            default => null,
        };
    }
    case ER_DUP_ENTRY = 1062;
    case ER_BAD_NULL_ERROR = 1048;
    case ER_ACCESS_DENIED_ERROR = 1045;
    case ER_BAD_FIELD_ERROR = 1054;
    case ER_PARSE_ERROR = 1064;
    case ER_CANNOT_ADD_FOREIGN = 1215;
    case ER_NO_REFERENCED_ROW = 1452;
    case ER_NO_SUCH_TABLE = 1146;
    case ER_NO_DEFAULT_FOR_FIELD = 1364;
    case ER_TRUNCATED_WRONG_VALUE = 1366;
}
