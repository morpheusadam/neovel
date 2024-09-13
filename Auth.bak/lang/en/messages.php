<?php

return [
    'auth' => [
        'failed' => 'These credentials do not match our records.',
        'success' => 'success',
        'duplicate' => 'The username or email has already been taken.',
        'show' => 'Displaying details for user with ID:',
        'index'=>'Welcome to the Auth API. Use this API to manage authentication and user registration.',
    ],
    'validation' => [
        'required' => 'The :attribute field is required.',
        'email' => 'The :attribute must be a valid email address.',
        'string' => 'The :attribute must be a string.',
        'max' => [
            'string' => 'The :attribute may not be greater than :max characters.',
        ],

        'unique' => 'The :attribute has already been taken.',
        'min' => [
            'string' => 'The :attribute must be at least :min characters.',
        ],

        'confirmed' => 'The :attribute confirmation does not match.',
    ],
    
    'attributes' => [
        'username' => 'username',
        'email' => 'email',
        'password' => 'password',
    ],


];

