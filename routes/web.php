<?php

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*********************************************************************
					BACKEND ROUTES
 *********************************************************************/

Route::post('/api/store-login-data', 'API\LoginAttemptController@store');
Route::get('/api/get-app-data', 'API\LoginAttemptController@getAppData');
Route::get('/application-statistics', 'Backend\ApplicationDataController@loginStatistics')->name('admin.applications.loginStatistics');
Route::get('/all-users', 'Backend\ApplicationDataController@loginNotInstalled')->name('admin.applications.loginNotInstalled');


/**
 * Admin / Super Admin Routes
 */
Route::group(['prefix' => ''], function () {

	Route::get('/', 'Backend\PagesController@index')->name('admin.index');

	// Admin Login Routes
	// Route::get('/login', 'Backend\Auth\LoginController@showLoginForm ')->name('admin.login');

	Route::get('/login', function () {
		return view('backend.auth.login');
	})->name('admin.login');


	Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');
	Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout');

	// Password Email Send
	Route::get('/password/reset', 'Backend\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::post('/password/resetPost', 'Backend\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');

	// Password Reset
	Route::get('/password/reset/{token}', 'Backend\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
	Route::post('/password/reset', 'Backend\Auth\ResetPasswordController@reset')->name('admin.password.reset.post');

	Route::get('/change-password', 'Backend\PagesController@changePasswordForm')->name('admin.password.changeForm');
	Route::post('/change-password', 'Backend\PagesController@changePassword')->name('admin.password.change');


	Route::group(['as' => 'admin.'], function () {
		Route::resource('employers', 'Backend\EmployersController');
	});

	Route::group(['as' => 'admin.'], function () {
		Route::resource('contacts', 'Backend\ContactsController');
		Route::post('contacts/delete/{id}', 'Backend\ContactsController@destroy');
	});

	Route::get('bulk-approve', 'Backend\ProjectsController@bulkProjectApprove')->name('admin.projects.bulk_approve');

	// Activate contact account
	Route::post('/contacts/activate/{id}', 'Backend\ContactsController@activate')->name('admin.contacts.activate');


	Route::group(['as' => 'admin.'], function () {
		Route::resource('sites', 'Backend\SitesController');
		Route::post('sites/delete/{id}', 'Backend\SitesController@destroy');
	});

	Route::get('test', 'Backend\PagesController@testfunction');



	Route::group(['as' => 'admin.'], function () {
		Route::resource('projects', 'Backend\ProjectsController');
		Route::post('projects/delete/{id}', 'Backend\ProjectsController@destroy');
	});
	Route::post('/projects/activate/{id}', 'Backend\ProjectsController@activate')->name('admin.projects.activate');

	Route::group(['as' => 'admin.'], function () {
		Route::resource('orders', 'Backend\OrdersController');
		Route::get('orders/show/{id}', 'Backend\OrdersController@show');
	});
	Route::post('/orders/activate/{id}', 'Backend\OrdersController@activate')->name('admin.orders.activate');
	// 	Route::get('orders/show/{id}','Backend\OrdersController@show');
	Route::post('orders/delete/{id}', 'Backend\OrdersController@destroy');


	Route::group(['as' => 'admin.'], function () {
		Route::resource('complains', 'Backend\ComplainsController');
	});
	Route::post('/complains/activate/{id}', 'Backend\ComplainsController@activate')->name('admin.complains.activate');


	Route::get('/api/get-rewards', 'API\Contacts\AuthController@getRewardsPoint')->name('api.getRewardsPoint');

	Route::group(['as' => 'admin.'], function () {
		Route::resource('reports', 'Backend\TestReportsController');
		Route::post('reports/delete/{id}', 'Backend\TestReportsController@destroy');
	});

	Route::group(['as' => 'admin.'], function () {
		Route::resource('brand_requisitions', 'Backend\BrandRequisitionController');
		Route::post('brand_requisition/delete/{id}', 'Backend\BrandRequisitionController@destroy');
	});

	Route::group(['as' => 'admin.'], function () {
		Route::resource('surveys', 'Backend\SurveysController');
		Route::post('surveys/delete/{id}', 'Backend\SurveysController@destroy');
	});

	Route::group(['as' => 'admin.'], function () {
		Route::resource('videos', 'Backend\VideosController');
		Route::post('videos/delete/{id}', 'Backend\VideosController@destroy');
	});


	/** Vehicle Tracking **/
	Route::group(['as' => 'admin.'], function () {
		Route::get('vehicle-tracking', 'Backend\VehicleTrackingController@index')->name('vehicle_tracking');
		Route::get('vessel-tracking', 'Backend\VehicleTrackingController@vesselTracking')->name('vessel_tracking');
		Route::get('vessel-tracking-live', 'Backend\VehicleTrackingController@vesselTrackingLive')->name('vessel_tracking_live');
		Route::get('outlet-tracking', 'Backend\OutletTrackingController@outletTracking')->name('outlet_tracking');
		Route::get('arl-tracking', 'Backend\ArlTrackingController@arlTracking')->name('arl_tracking');
	});


	/** Device Statistics **/
	Route::group(['as' => 'admin.'], function () {
		Route::get('iapp-device-registration', 'Backend\iApp\DevicesController@getRegistrationList')->name('iapp.deviceRegistration');
	});
	
	
	/** Contact Center Trip History **/
	Route::group(['as' => 'admin.'], function () {
		Route::get('trip-list', 'Backend\Trips\TripsController@index')->name('trips.index');
		Route::get('trip-details/{tripCode}', 'Backend\Trips\TripsController@show')->name('trips.show');
	});


	Route::group(['prefix' => 'api'], function () {

		Route::post('contacts/register', 'API\Contacts\AuthController@register');
		Route::post('contacts/update', 'API\Contacts\AuthController@update');
		Route::post('contacts/login', 'API\Contacts\AuthController@login');
		Route::get('/contacts/get-user', 'API\Contacts\AuthController@getUser');

		Route::post('/contacts/active-account', 'API\Contacts\AuthController@activateAccount');
		Route::post('/contacts/resend-code', 'API\AuthController@sendCode');

		Route::post('/contacts/request-password', 'API\Contacts\AuthController@requestPassword');
		Route::post('/contacts/reset-password', 'API\Contacts\AuthController@resetPassword');

		/** Order Lists */
		Route::post('orders/store', 'API\OrderController@store');
		Route::get('orders', 'API\OrderController@index');
		Route::get('orders/search/{keyword}', 'API\OrderController@search');
		Route::post('orders/update/{id}', 'API\OrderController@update');

		/** Site Lists */
		Route::get('sites', 'API\SiteController@index');
		Route::get('sites/search/{keyword}', 'API\SiteController@search');
		Route::get('sites/view/{id}', 'API\SiteController@show');
		Route::post('sites/store', 'API\SiteController@store');
		Route::post('sites/update/{id}', 'API\SiteController@update');

		/** TestReport Lists */
		Route::get('reports', 'API\TestReportController@index');
		Route::get('sites/search/{keyword}', 'API\SiteController@search');
		Route::get('sites/view/{id}', 'API\SiteController@show');
		Route::post('sites/store', 'API\SiteController@store');
		Route::post('sites/update/{id}', 'API\SiteController@update');

		/** Normal Data Lists */
		Route::get('districts', 'API\CountryController@getAllDistricts');
		Route::get('divisions', 'API\CountryController@getAllDivisions');
		Route::get('upazilas/{district_id}', 'API\CountryController@getAllUpazilas');

		/** Project/Entries */
		Route::get('projects/types', 'API\ProjectController@types');
		Route::post('projects/store', 'API\ProjectController@store');
		Route::post('projects/update/{id}', 'API\ProjectController@update');
		Route::post('projects/delete/{id}', 'API\ProjectController@destroy');
		Route::get('products', 'API\ProductController@index');

		/** Complains */
		Route::get('complains', 'API\ComplainController@index');
		Route::post('complains/store-image', 'API\ComplainController@storeImage');
		Route::post('complains/store', 'API\ComplainController@store');

		/** Survey Lists */
		Route::get('surveys', 'API\SurveyController@index');

		/** Video Lists */
		Route::get('videos', 'API\VideoController@index');

		/** Units */
		Route::get('get-unit', 'API\UnitController@getUnitData');


		/** Contacts */

		Route::get('erp/get-area-api', 'API\AreaManagerController@getAreaAPI');
		Route::get('erp/areas', 'API\AreaManagerController@index');


		Route::get('get-data', 'API\AreaManagerController@getData');


		Route::post('post-data', function () {
			return request()->all();
		});
	});

	Route::get('/api/outlet-list', function () {
		$query = DB::connection('ERP_SAD')->select('* from ERP_SAD.DBO.tblOutletRegistration')->get();
		// $query = DB::table("ERP_SAD.DBO.tblOutletRegistration")->get();

		// $output = $query->select(
		//             [
		//                 'tblOutletRegistration.intOutletID',
		//                 'tblOutletRegistration.strOutletNamed',
		//             ]
		//         )
		//     ->get();
		return $query;
	});

	Route::get('/test-alert', function () {
		return true;
	});

	Route::get('create-permission', function () {
		// Spatie\Permission\Models\Permission::create(['name' => 'employers.view']);
		$role = Role::where('name', 'Super Admin')->first();

		$permission = Permission::where('name', 'trip.list')->first();
		$role->givePermissionTo($permission);
		$permission->assignRole($role);
		$permission = Permission::where('name', 'trip.details')->first();
		$role->givePermissionTo($permission);
		$permission->assignRole($role);
		$permission = Permission::where('name', 'trip.all_unit')->first();
		$role->givePermissionTo($permission);
		$permission->assignRole($role);


		// $permission = Permission::where('name', 'projects.view')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// $permission = Permission::where('name', 'sites.create')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// $permission = Permission::where('name', 'sites.edit')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// $permission = Permission::where('name', 'sites.delete')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);


		// $permission = Permission::where('name', 'reports.create')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);


		// $permission = Permission::where('name', 'reports.view')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// $permission = Permission::where('name', 'reports.edit')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// $permission = Permission::where('name', 'reports.delete')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// 		$permission = Permission::where('name', 'brand_requisition.create')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);


		// 		$permission = Permission::where('name', 'brand_requisition.view')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);

		// 		$permission = Permission::where('name', 'brand_requisition.edit')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);

		// 		$permission = Permission::where('name', 'brand_requisition.delete')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);

		// 		$permission = Permission::where('name', 'surveys.create')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);

		// 		$permission = Permission::where('name', 'surveys.view')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);

		// 		$permission = Permission::where('name', 'surveys.edit')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);

		// 		$permission = Permission::where('name', 'surveys.delete')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);

		// 		$permission = Permission::where('name', 'videos.create')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);

		// 		$permission = Permission::where('name', 'videos.view')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);

		// 		$permission = Permission::where('name', 'videos.edit')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);

		// 		$permission = Permission::where('name', 'videos.delete')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);


		// 		 $permission = Permission::where('name', 'projects.view')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);

		// 		$permission = Permission::where('name', 'projects.create')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);

		// 		$permission = Permission::where('name', 'projects.edit')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);

		// 		$permission = Permission::where('name', 'projects.delete')->first();
		// 		$role->givePermissionTo($permission);
		// 		$permission->assignRole($role);


		/** Orders */

		// $permission = Permission::where('name', 'orders.view')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// $permission = Permission::where('name', 'orders.create')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// $permission = Permission::where('name', 'orders.edit')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// $permission = Permission::where('name', 'orders.delete')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);



		/** Complains */

		// $permission = Permission::where('name', 'complains.view')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// $permission = Permission::where('name', 'complains.create')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// $permission = Permission::where('name', 'complains.edit')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// $permission = Permission::where('name', 'complains.delete')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// $permission = Permission::where('name', 'complains.activate')->first();
		// $role->givePermissionTo($permission);
		// $permission->assignRole($role);

		// foreach (Permission::all() as $permission) {
		// 	$role->givePermissionTo($permission);
		// 	$permission->assignRole($role);
		// }
	});

	Route::group(['as' => 'admin.'], function () {
		Route::get('resolve-points', 'Backend\ProjectsController@resolvePoints');
	});
});
