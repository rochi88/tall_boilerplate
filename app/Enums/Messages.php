<?php

declare(strict_types=1);

namespace App\Enums;

enum Messages: string
{
    case RETRIEVED_SUCCESSFULLY = 'Records retrieved successfully';
    case CREATED_SUCCESSFULLY = 'Record created successfully';
    case FETCHED_SUCCESSFULLY = 'Record fetched successfully';
    case UPDATED_SUCCESSFULLY = 'Record updated successfully';
    case TRASHED_SUCCESSFULLY = 'Record trashed successfully';
    case VALIDATION_FAILED = 'Validation failed';
    case NO_QUERY_RESULTS = 'No record found';
    case NON_NUMERIC_ID = 'Provided id is not numeric';
    case FORBIDDEN = 'Forbidden | Insufficient rights to access this resource';
    case UNAUTHORIZED = 'Unauthorized';
    case LOGGED_OUT_SUCCESSFULLY = 'Successfully logged out';
    case INTERNAL_SERVER_ERROR_MESSAGE = 'Internal Server Error';
    case UNAUTHORIZED_DOMAIN_OR_IP = 'Unauthorized domain or IP';
    case LOGIN_SUCCESSFUL = 'Login successful';
    case RESET_PASSWORD_SUCCESSFUL = 'Password reset successfully';
    case OTP_SUCCESSFUL = 'OTP sent successfully to ';
    case OTP_VERIFIED = 'OTP verified successfully';
    case INVALID_USER = 'Invalid User';
    case RESOURCE_NOT_FOUND = 'Resource Not Found';
    case RESTORED_SUCCESSFULLY = 'Record restored successfully';
    case DELETED_SUCCESSFULLY = 'Record deleted permanently successfully';
    case INVALID_CREDENTIALS = 'Invalid credentials provided';
    case INTERNAL_ERROR_MSG = 'Internal server error';
    case NOT_FOUND_MSG = 'Requested resource not found';
    case METHOD_NOT_ALLOWED_MSG = 'Method not allowed for this endpoint.';
    case DB_QUERY_ERROR_MSG = 'Database query error';
    case NOT_ACCEPTABLE_MSG = 'Response format not acceptable';
    case TOO_MANY_ATTEMPT = 'Too Many Requests';
    case DUPLICATE_ENTRY_MSG = 'Duplicate entry - The resource already exists.';
}
