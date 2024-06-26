<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API errors Language Lines
    |--------------------------------------------------------------------------
    */

    'unknown_error' => 'An unknown error occurred. Please try again later.',
    'invalid_credentials' => 'Invalid credentials',
    'invalid_query_parameters' => 'Invalid query parameters',
    'unauthorized' => 'Unauthorized',
    'forbidden' => 'Forbidden',

    /** User Domain errors */
    'user' => [
        'not_found' => 'User not found',
    ],

    /** Book Domain errors */
    'book' => [
        'not_found' => 'Book not found',
        'already_in_library' => 'Book already in the library',
        'not_in_library' => 'Book not in the library',
        'is_borrowed' => 'Book is borrowed',
    ],

    /** Loan Domain errors */
    'loan' => [
        'not_found' => 'Loan not found',
        'non_property' => 'Loan does not belong to the current user',
    ],

];
