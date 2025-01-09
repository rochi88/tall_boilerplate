<?php

declare(strict_types = 1);

namespace App\Enums;

enum Messages
{
    public const RETRIEVED_SUCCESSFULLY = 'Records retrieved successfully';
    public const CREATED_SUCCESSFULLY = 'Record created successfully';
    public const FETCHED_SUCCESSFULLY = 'Record fetched successfully';
    public const UPDATED_SUCCESSFULLY = 'Record updated successfully';
    public const TRASHED_SUCCESSFULLY = 'Record trashed successfully';
    public const VALIDATION_FAILED = 'Validation failed';
    public const NO_QUERY_RESULTS = 'No record found';
    public const NON_NUMERIC_ID = 'Provided id is not numeric';
    public const FORBIDDEN = 'Forbidden | Insufficient rights to access this resource';
    public const UNAUTHORIZED = 'Unauthorized';
    public const LOGGED_OUT_SUCCESSFULLY = 'Successfully logged out';
    public const INTERNAL_SERVER_ERROR_MESSAGE = 'Internal Server Error';
    public const UNAUTHORIZED_DOMAIN_OR_IP = 'Unauthorized domain or IP';
    public const LOGIN_SUCCESSFUL = 'Login successful';
    public const RESET_PASSWORD_SUCCESSFUL = 'Password reset successfully';
    public const OTP_SUCCESSFUL = 'OTP sent successfully to ';
    public const OTP_VERIFIED = 'OTP verified successfully';
    public const INVALID_USER = 'Invalid User';
    public const RESOURCE_NOT_FOUND = 'Resource Not Found';
    public const METHOD_NOT_ALLOWED_MSG = 'Method not allowed for this endpoint.';
    public const DB_QUERY_ERROR_MSG = 'Database query error';
    public const NOT_ACCEPTABLE_MSG = 'Response format not acceptable';
    public const TOO_MANY_ATTEMPT = 'Too Many Requests';
    public const DUPLICATE_ENTRY_MSG = 'Duplicate entry - The resource already exists.';
}
