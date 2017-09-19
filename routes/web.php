<?php

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

Route::get('/', 'PagesController@home');
Route::get('/home', 'PagesController@home');
Route::get('/about', 'PagesController@about');
Route::get('/contact', 'TicketsController@create');
Route::get('/tickets', 'TicketsController@index');
Route::get('/ticket/{slug?}', 'TicketsController@show');
Route::get('/ticket/{slug?}/edit','TicketsController@edit');
Route::get('/users/register', 'Auth\RegisterController@showRegistrationForm');
Route::get('/users/logout', 'Auth\LoginController@logout');
Route::get('/users/login', 'Auth\LoginController@showLoginForm');
Route::group(array('prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'manager'), function () {
    Route::get('/users', [ 'as' => 'admin.user.index', 'uses' => 'UsersController@index']);
    Route::get('roles', 'RolesController@index');
    Route::get('roles/create', 'RolesController@create');
    Route::get('users/{id?}/edit', 'UsersController@edit');
    Route::get('/', 'PagesController@home');
    Route::get('posts', 'PostsController@index');
    Route::get('posts/create', 'PostsController@create');
    Route::get('posts/{id?}/edit', 'PostsController@edit');
    Route::get('categories', 'CategoriesController@index');
    Route::get('categories/create', 'CategoriesController@create');
    Route::get('dashboard', 'PagesController@dashboard');
    Route::get('tour-clients', 'PagesController@tour_clients');

    Route::post('roles/create', 'RolesController@store');
    Route::post('users/{id?}/edit','UsersController@update');
    Route::post('posts/create', 'PostsController@store');
    Route::post('posts/{id?}/edit','PostsController@update');
    Route::post('categories/create', 'CategoriesController@store');

    Route::get('/users/profile/purchases/{uniqid?}', 'UsersController@view_purchase');
    Route::get('/users/purchase/cancel-order/{id?}', 'UsersController@cancel_purchase');


    //================= AJAX QUERIES =================//

    //================= CUSTOM TOUR ==================//

    Route::get('/ajax/custom-tour/get-all-pending', 'AjaxController@get_all_pending_tour_inquiries');
    Route::get('/ajax/custom-tour/get-all', 'AjaxController@get_tour_inquiries');
    Route::get('/ajax/custom-tour/get-inquiry/{id?}', 'AjaxController@get_tour_inquiry');
    Route::get('/ajax/custom-tour/mark-as-processed/{id?}', 'AjaxController@mark_as_processed_tour_inquiry');
    Route::get('/ajax/custom-tour/delete-inquiry/{id?}', 'AjaxController@delete_tour_inquiry');

    //============ AIRLINE TICKETING =============//

    Route::get('/ajax/airline-ticketing/get-all-pending', 'AjaxController@get_all_pending_flight_inquiries');
    Route::get('/ajax/airline-ticketing/get-all', 'AjaxController@get_flight_inquiries');
    Route::get('/ajax/airline-ticketing/get-inquiry/{id?}', 'AjaxController@get_flight_inquiry');
    Route::get('/ajax/airline-ticketing/mark-as-processed/{id?}', 'AjaxController@mark_as_processed_flight_inquiry');
    Route::get('/ajax/airline-ticketing/delete-inquiry/{id?}', 'AjaxController@delete_flight_inquiry');

    //============ HOTEL RESERVATION =============//

    Route::get('/ajax/hotel-reservation/get-all-pending', 'AjaxController@get_all_pending_hotel_inquiries');
    Route::get('/ajax/hotel-reservation/get-all', 'AjaxController@get_hotel_inquiries');
    Route::get('/ajax/hotel-reservation/get-inquiry/{id?}', 'AjaxController@get_hotel_inquiry');
    Route::get('/ajax/hotel-reservation/mark-as-processed/{id?}', 'AjaxController@mark_as_processed_hotel_inquiry');
    Route::get('/ajax/hotel-reservation/delete-inquiry/{id?}', 'AjaxController@delete_hotel_inquiry');

    //============ BUS BOOKING =============//

    Route::get('/ajax/bus-booking/get-all-pending', 'AjaxController@get_all_pending_bus_inquiries');
    Route::get('/ajax/bus-booking/get-all', 'AjaxController@get_bus_inquiries');
    Route::get('/ajax/bus-booking/get-inquiry/{id?}', 'AjaxController@get_bus_inquiry');
    Route::get('/ajax/bus-booking/mark-as-processed/{id?}', 'AjaxController@mark_as_processed_bus_inquiry');
    Route::get('/ajax/bus-booking/delete-inquiry/{id?}', 'AjaxController@delete_bus_inquiry');


    //============ VAN RENTAL =============//

    Route::get('/ajax/van-rental/get-all-pending', 'AjaxController@get_all_pending_van_inquiries');
    Route::get('/ajax/van-rental/get-all', 'AjaxController@get_van_inquiries');
    Route::get('/ajax/van-rental/get-inquiry/{id?}', 'AjaxController@get_van_inquiry');
    Route::get('/ajax/van-rental/mark-as-processed/{id?}', 'AjaxController@mark_as_processed_van_inquiry');
    Route::get('/ajax/van-rental/delete-inquiry/{id?}', 'AjaxController@delete_van_inquiry');

    //============ TOUR CLIENTS =============//

    Route::get('/ajax/tour-clients/get-all-pending', 'AjaxController@get_pending_tour_clients');
    Route::get('/ajax/tour-clients/get-all-previous', 'AjaxController@get_previous_tour_clients');
    Route::get('/ajax/tour-clients/get-info/{id?}', 'AjaxController@get_tour_client_info');
    Route::get('/ajax/tour-clients/mark-as-approved/{id?}', 'AjaxController@approve_tour_client');
    Route::get('/ajax/tour-clients/deny/{id?}', 'AjaxController@deny_tour_client');



    //============ FAQS =============//

    Route::get('/faqs', 'FaqsController@index');
    Route::get('/ajax/faqs/get-info/{id?}', 'FaqsController@get_faq_info');
    Route::post('/faqs/add-new', 'FaqsController@add_faq');
    Route::post('/faqs/edit/{id?}', 'FaqsController@update_faq');
    Route::get('/faqs/delete/{id?}', 'FaqsController@delete_faq');

    //============ TESTIMONIALS =============//

    Route::get('/testimonials', 'TestimonialsController@index');
    Route::get('/testimonials/approve/{id?}', 'TestimonialsController@approve');
    Route::get('/testimonials/deny/{id?}', 'TestimonialsController@deny');
    Route::get('/testimonials/delete/{id?}', 'TestimonialsController@delete');


    //============ PAGES =============//

    Route::get('/pages/home', 'PagesController@home_page');
    Route::post('/pages/home/update-about', 'PagesController@update_about');
    Route::post('/pages/home/update-mission', 'PagesController@update_mission');
    Route::post('/pages/home/update-vision', 'PagesController@update_vision');
    Route::post('/pages/home/update-service/{id?}', 'PagesController@update_service');

    Route::get('/pages/flight', 'PagesController@flight_page');
    Route::get('/pages/custom-tour', 'PagesController@custom_tour_page');
    Route::get('/pages/bus', 'PagesController@bus_page');
    Route::get('/pages/hotel', 'PagesController@hotel_page');
    Route::get('/pages/van', 'PagesController@van_page');
    Route::get('/ajax/van/get-info/{id?}', 'AjaxController@get_van_info');
    Route::post('/pages/vans/add', 'VanController@add_van');
    Route::post('/pages/vans/update/{id?}', 'VanController@update_van');
    Route::get('/pages/vans/delete/{id?}', 'VanController@delete_van');

    Route::post('/pages/steps/update/{id?}', 'PagesController@update_step');

    Route::get('/faqs/hide/{id?}', 'FaqsController@hide_faq');
    Route::get('/faqs/unhide/{id?}', 'FaqsController@unhide_faq');

    Route::get('/pages/hotel-policy', 'PagesController@hotel_policy_page');
    Route::get('/pages/flight-policy', 'PagesController@flight_policy_page');
    Route::get('/pages/terms-and-conditions', 'PagesController@terms_and_conditions_page');
    Route::get('/pages/work-with-us', 'PagesController@work_with_us_page');

    Route::post('/pages/update-sub/{id?}', 'PagesController@update_sub');


    Route::get('/settings', 'PagesController@settings');
    Route::post('/settings', 'PagesController@update_settings');


    //============ BLOG POSTS =============//

    Route::get('/blogs', 'PagesController@blog');
    Route::get('/blogs/new', 'PagesController@add_new_blog');
    Route::post('/blogs/new', 'PagesController@save_new_blog');

    Route::get('/ajax/users/get-all', 'AjaxController@get_all_users');
    Route::get('/ajax/users/get-info/{id?}', 'AjaxController@get_user_info');
    Route::get('/ajax/users/remove-admin-role/{id?}', 'AjaxController@remove_admin_role_from_user');
    Route::get('/ajax/users/add-admin-role/{id?}', 'AjaxController@add_admin_role_to_user');
    Route::get('/ajax/users/delete/{id?}', 'AjaxController@delete_user');

    Route::get('/newsletter', 'PagesController@newsletter');
    Route::get('/ajax/newsletter/get-all', 'AjaxController@get_all_subscribers');
    Route::get('/ajax/newsletter/unsubscribe/{id?}', 'AjaxController@unsubscribe_user');

});
Route::middleware(['member'])->group(function () {
    Route::get('users/profile', 'UsersController@profile');
    //Route::get('users/profile/edit/{id?}', 'UsersController@update_profile');
    Route::get('users/settings', 'UsersController@settings');

    Route::post('users/settings', 'UsersController@update');

    Route::get('/checkout', 'CheckoutController@index');

    Route::post('/checkout', 'CheckoutController@checkout');

    Route::get('/users/profile/purchases/{uniqid?}', 'UsersController@view_purchase');

    Route::post('/users/profile/purchases/upload-receipt', 'UsersController@update_purchase_info');

    Route::get('/users/purchase/cancel-order/{id?}', 'UsersController@cancel_purchase');
});
Route::get('/blogs', 'BlogController@index');
Route::get('/blog/{slug?}', 'BlogController@show');
Route::get('/tour-packages', 'TourPackageController@index');
Route::get('/tour-packages/cheap-packages', 'TourPackageController@cheap_packages');
Route::get('/tour-packages/custom', 'TourPackageController@custom_tour');
Route::get('/tour-packages/{slug?}', 'TourPackageController@show');

Route::get('/faqs', 'PagesController@faqs');
Route::get('/hotel-cancellation-policy', 'PagesController@hotel_cancellation_policy');
Route::get('/flight-cancellation-policy', 'PagesController@flight_cancellation_policy');
Route::get('/terms-and-conditions', 'PagesController@terms_and_conditions');
Route::get('/work-with-us', 'PagesController@work_with_us');
Route::get('/testimonials', 'PagesController@testimonials');

/*
|--------------------------------------------------------------------------
| INQUIRIES
|--------------------------------------------------------------------------
|
*/
Route::get('/inquiries/airline-ticketing', 'InquiriesController@flight');
Route::get('/inquiries/bus-booking', 'InquiriesController@bus');
Route::get('/inquiries/hotel-reservation', 'InquiriesController@hotel');
Route::get('/inquiries/van-rental', 'InquiriesController@van_rental');


Route::get('/inquiries/get-drop-offs', 'InquiriesController@get_drop_offs');

Route::get('/shopping-cart', 'CartController@index');
Route::get('/cart/remove-from-cart/{id?}', 'CartController@remove_from_cart');
Route::get('/cart/proceed-to-checkout', 'CartController@proceed_to_checkout');



/*
|--------------------------------------------------------------------------
| POST / passing forms
|--------------------------------------------------------------------------
|
*/

Route::post('/contact', 'TicketsController@store');
Route::post('/ticket/{slug?}/edit','TicketsController@update');
Route::post('/ticket/{slug?}/delete','TicketsController@destroy');
Route::post('/comment', 'CommentsController@newComment');
Route::post('/users/register', 'Auth\RegisterController@register');
Route::post('/users/login', 'Auth\LoginController@login');


Route::post('/inquiries/airline-ticketing', 'InquiriesController@store_flight');
Route::post('/inquiries/bus-booking', 'InquiriesController@store_bus');
Route::post('/inquiries/van-rental', 'InquiriesController@store_van_rental');
Route::post('/inquiries/hotel-reservation', 'InquiriesController@store_hotel_reservation');
Route::post('/tour-packages/custom', 'TourPackageController@store');

Route::post('/testimonials', 'TestimonialsController@store');

Route::post('/cart/add-to-cart', 'CartController@add_to_cart');


/*
|--------------------------------------------------------------------------
| NEWSLETTER SUBSCRITPTION
|--------------------------------------------------------------------------
|
*/


Route::post('/subscribe-to-newsletter', 'SubscribersController@subscribe');
Route::get('/subscribe-to-newsletter/registered-user', 'SubscribersController@subscribe_registered');
Route::get('/unsubscribe/{uniqid?}', 'SubscribersController@unsubscribe');
Route::get('/unsubscribe-registered/{uniqid?}', 'SubscribersController@unsubscribe_registered');



/*
|--------------------------------------------------------------------------
| Emails
|--------------------------------------------------------------------------
|
*/
Route::get('sendemail', function () {

    $data = array(
        'name' => "Learning Laravel",
    );

    Mail::send('emails.welcome', $data, function ($message) {

        $message->from('creativemindsphilippines@gmail.com', 'Learning Laravel');

        $message->to('creativemindsphilippines@gmail.com')->subject('Learning Laravel test email');

    });

    return "Your email has been sent successfully";

});
Auth::routes();
