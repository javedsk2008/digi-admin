<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');
        $api->post('login_admin', 'App\\Api\\V1\\Controllers\\LoginController@login_admin');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');
        $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');

        $api->get('view_country','App\\Api\\V1\\Controllers\\MasterApiController@view_country');
        $api->post('signup_user','App\\Api\\V1\\Controllers\\LoginController@signup_user');
        $api->post('forgot_password', 'App\\Api\\V1\\Controllers\\LoginController@forgot_password');
        $api->get('verify_email', 'App\\Api\\V1\\Controllers\\LoginController@verify_email');
        $api->post('verify_number', 'App\\Api\\V1\\Controllers\\LoginController@verify_number');
        $api->post('resend_otp', 'App\\Api\\V1\\Controllers\\LoginController@resend_otp');
        $api->post('edit_profile', 'App\\Api\\V1\\Controllers\\LoginController@edit_profile');
        $api->post('setpin', 'App\\Api\\V1\\Controllers\\LoginController@setpin');



        $api->get('view_school','App\\Api\\V1\\Controllers\\MasterApiController@view_school');
        $api->get('view_classand_course','App\\Api\\V1\\Controllers\\MasterApiController@view_classand_course');
        
        $api->get('view_subject','App\\Api\\V1\\Controllers\\MasterApiController@view_subject');
        $api->get('view_subject_details','App\\Api\\V1\\Controllers\\MasterApiController@view_subject_details');
        $api->get('view_chapter','App\\Api\\V1\\Controllers\\MasterApiController@view_chapter');
        $api->get('view_audiovideo','App\\Api\\V1\\Controllers\\MasterApiController@view_audiovideo');
        $api->get('view_audiovideo_details','App\\Api\\V1\\Controllers\\MasterApiController@view_audiovideo_details');
        $api->get('view_activity','App\\Api\\V1\\Controllers\\MasterApiController@view_activity');
        $api->get('view_activity_details','App\\Api\\V1\\Controllers\\MasterApiController@view_activity_details');
        $api->get('view_question','App\\Api\\V1\\Controllers\\MasterApiController@view_question');

        $api->post('add_alphabet_tracing','App\\Api\\V1\\Controllers\\MasterApiController@add_alphabet_tracing');
        $api->post('remove_question','App\\Api\\V1\\Controllers\\MasterApiController@remove_question');
        $api->get('view_question_alphabet_tracing','App\\Api\\V1\\Controllers\\MasterApiController@view_question_alphabet_tracing');
        $api->get('insert_answer','App\\Api\\V1\\Controllers\\MasterApiController@insert_answer');
        $api->get('view_code','App\\Api\\V1\\Controllers\\MasterApiController@view_code');

        $api->post('initial_payment','App\\Api\\V1\\Controllers\\MasterApiController@initial_payment');
        $api->post('final_payment','App\\Api\\V1\\Controllers\\MasterApiController@final_payment');

     
    });

    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);

        
    });
    $api->post('login_user','App\\Api\\V1\\Controllers\\UserController@login_user');

    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
    $api->get('viewchapter2','App\\Api\\V1\\Controllers\\UserController@viewchapter2');
   
});


// http://localhost:8000/api/auth/viewchapter?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE1NjUyNTExNjAsImV4cCI6MTU2Njc2MzE2MCwibmJmIjoxNTY1MjUxMTYwLCJqdGkiOiJ5dzhyeW1YVHBlZ0JoSmthIiwic3ViIjoxMCwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSJ9.5U-Levh-eUxUXkvitZszsQHRGA6E-O7RMlh2y54wtlw