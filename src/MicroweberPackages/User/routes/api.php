<?php
/**
* Created by PhpStorm.
 * User: Bojidar
* Date: 10/7/2020
* Time: 5:50 PM
*/

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('api/users/export_my_data', function () {

    if (!is_logged()) {
        return array('error' => 'You must be logged');
    }

    $user_id = (int) $_GET['user_id'];

    $exportFromTables = [];
    $prefix = mw()->database_manager->get_prefix();
    $tablesList = mw()->database_manager->get_tables_list(true);
    foreach ($tablesList as $table) {
        $table = str_replace($prefix, false, $table);
        $columns  = Schema::getColumnListing($table);
        if (in_array('created_by',$columns)) {
            $exportFromTables[] = $table;
        }
    }

    $exportData = [];
    foreach ($exportFromTables as $exportFromTable) {
        $getData = \Illuminate\Support\Facades\DB::table($exportFromTable)->where('created_by', $user_id)->get();
        if (!empty($getData)) {
            $exportData[$exportFromTable] = $getData->toArray();
        }
    }

    $json = new \MicroweberPackages\Backup\Exporters\JsonExport($exportData);
    $getJson = $json->start();

    if (isset($getJson['files'][0]['filepath'])) {
        return response()->download($getJson['files'][0]['filepath'])->deleteFileAfterSend(true);
    }

})->name('users.export_my_data');

// OLD API SAVE USER
Route::post('api/save_user', function (Request $request) {
    if (!defined('MW_API_CALL')) {
        define('MW_API_CALL', true);
    }
    if(!is_logged()){
        App::abort(403, 'Unauthorized action.');
    }
    $input = Input::all();
    return save_user($input);
})->middleware(['api']);

Route::post('api/delete_user', function (Request $request) {
    if (!defined('MW_API_CALL')) {
        define('MW_API_CALL', true);
    }
    if(!is_admin()){
        App::abort(403, 'Unauthorized action.');
    }
    $input = Input::all();
    return delete_user($input);
})->middleware(['api']);

Route::name('api.user.')->prefix('api/user')->middleware(['public.api'])->namespace('\MicroweberPackages\User\Http\Controllers')->group(function () {

    Route::post('login', 'UserLoginController@login')->name('login')->middleware(['allowed_ips','throttle:60,1']);
    Route::post('logout', 'UserLoginController@logout')->name('logout');
    Route::post('register', 'UserRegisterController@register')->name('register')->middleware(['allowed_ips']);

    Route::post('/forgot-password', 'UserForgotPasswordController@send')->name('password.email');
    Route::post('/reset-password', 'UserForgotPasswordController@update')->name('password.update');

    Route::post('/profile-update', 'UserProfileController@update')->name('profile.update');

});

Route::name('api.')
    ->prefix('api')
    ->middleware(['api'])
    ->namespace('\MicroweberPackages\User\Http\Controllers\Api')
    ->group(function () {
        Route::apiResource('user', 'UserApiController');
    });
