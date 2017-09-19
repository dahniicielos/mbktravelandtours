<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Purchase;
use App\Service;
use App\Homepage;
use App\Http\Requests\HomepageFormRequest;
use App\Http\Requests\ServiceFormRequest;
use App\Step;
use App\Faq;
use App\Http\Requests\StepFormRequest;
use App\Sub;
use App\Http\Requests\SubFormRequest;
use App\Post;
use App\Category;
use App\Http\Requests\BlogFormRequest;
use App\Van;
use App\Http\Requests\SettingsFormRequest;



class PagesController extends Controller
{
    public function home()
    {
        return view('backend.home');
    }

    public function dashboard()
    {

    	
        $total_inquiries = 0;
        $custom_tour_count = DB::table('custom_tour_packages')->count();
        $flight_reservation_count = DB::table('flight_inquiries')->count();
        $hotel_reservation_count = DB::table('hotel_reservation_inquiries')->count();
        $bus_booking_count = DB::table('bus_inquiries')->count();
        $van_rental_count = DB::table('van_rental_inquiries')->count();
        $total_inquiries += $custom_tour_count + $flight_reservation_count + $hotel_reservation_count + $bus_booking_count + $van_rental_count;
        
        $total_tour_clients = DB::table('purchases')->count();
        $total_registered_users = DB::table('users')->count();
        $total_revenue = DB::table('purchases')->sum('subtotal');

        $custom_tour_pending = DB::table('custom_tour_packages')->where('remark', 0)->get();
        $flight_reservation_pending = DB::table('flight_inquiries')->select('flight_inquiries.id', 'flight_inquiries.name', 'flight_inquiries.location_from', 'flight_inquiries.location_to', 'flight_inquiries.date_departure', 'flight_inquiries.date_return', 'loc_from.location_code as from', 'loc_to.location_code as to')
        ->leftJoin('locations as loc_from', 'flight_inquiries.location_from', '=', 'loc_from.id')
		->leftJoin('locations as loc_to', 'flight_inquiries.location_to', '=', 'loc_to.id')
        ->where('remark', 0)->get();
        //return $flight_reservation_pending;
        $hotel_reservation_pending = DB::table('hotel_reservation_inquiries')->where('remark', 0)->get();
        $bus_booking_pending = DB::table('bus_inquiries')->select('bus_inquiries.id', 'bus_inquiries.name', 'bus_inquiries.origin', 'bus_inquiries.destination', 'bus_inquiries.date_departure', 'bus_inquiries.date_return', 'orig.location_name as from', 'dest.location_name as to')
        ->leftJoin('bus_travel_locations as orig', 'bus_inquiries.origin', '=', 'orig.id')
		->leftJoin('bus_travel_locations as dest', 'bus_inquiries.destination', '=', 'dest.id')


		->where('remark', 0)->get();
		//->leftJoin('drop_off_points as dop', 'bus_inquiries.drop_off_point', '=', 'dop.id')
        $van_rental_pending = DB::table('van_rental_inquiries')->where('remark', 0)->get();



    	return view('admin.index', compact('total_inquiries', 'total_tour_clients', 'total_registered_users', 'total_revenue', 'custom_tour_count', 'flight_reservation_count', 'hotel_reservation_count', 'bus_booking_count', 'van_rental_count', 'custom_tour_pending', 'flight_reservation_pending', 'hotel_reservation_pending', 'bus_booking_pending', 'van_rental_pending'));
    }

    public function tour_clients()
    {
        //total_revenue = sum(total) where status = 1 (pending paid) or 2 (approved)
        //monthly_revenue = sum(total) where (status = 1 (pending paid) or 2 (approved)) and datetime_paid = this_month
        //accounts_receivable = sum(total) where status = 1 (pending paid) or 2 (approved)
        /*=========================================================================
           used subtotal for the reason that misc and tax are more of an expense
        ==========================================================================*/
        $total_revenue = Purchase::whereRaw(DB::raw('purchase_status = 1 or purchase_status = 2'))->sum('subtotal');
        $month = date('m');
        $monthly_revenue = Purchase::whereRaw(DB::raw('(purchase_status = 1 or purchase_status = 2) and (month(datetime_paid) = '.$month.')'))->sum('subtotal');
        $accounts_receivable = Purchase::where('purchase_status', '0')->sum('subtotal');
        $total_pending_tour_clients = DB::table('purchases')->where('purchase_status', '!=', 2)->count();
        return view('admin.tour_clients', compact('total_revenue', 'monthly_revenue', 'accounts_receivable', 'total_pending_tour_clients'));
    }

    public function home_page()
    {
        $homepage = Homepage::select('about', 'mission', 'vision')->firstOrFail();
        $services = Service::all();
        return view('admin.pages.home', compact('homepage', 'services'));
    }

    public function update_about(HomepageFormRequest $request)
    {
        $homepage = Homepage::select('id', 'about')->firstOrFail();
        $homepage->about = $request->get('description');
        $homepage->save();
        return redirect('/admin/pages/home')->with('status', 'About has been successfully updated.');
    }

    public function update_mission(HomepageFormRequest $request)
    {
        $homepage = Homepage::select('id', 'mission')->firstOrFail();
        $homepage->mission = $request->get('description');
        $homepage->save();
        return redirect('/admin/pages/home')->with('status', 'Mission has been successfully updated.');
    }

    public function update_vision(HomepageFormRequest $request)
    {
        $homepage = Homepage::select('id', 'vision')->firstOrFail();
        $homepage->vision = $request->get('description');
        $homepage->save();
        return redirect('/admin/pages/home')->with('status', 'Vision has been successfully updated.');
    }

    public function update_service($id, ServiceFormRequest $request)
    {
        $service = Service::whereId($id)->firstOrFail();
        $service->name = $request->get('service_name');
        $service->description = $request->get('service_description');
        $service->save();
        return redirect('admin/pages/home')->with('status', $request->get('service_name')." has been successfully updated.");
    }

    //1 for flight; 2 for tour; 3 for hotel; 4 for bus; 5 for van

    public function flight_page()
    {
        $steps = Step::where('step_type', 1)->get();
        $faqs = Faq::where('faq_type', 1)->get();
        return view('admin.pages.flight', compact('steps', 'faqs'));
    }

    public function custom_tour_page()
    {
        $steps = Step::where('step_type', 2)->get();
        $faqs = Faq::where('faq_type', 2)->get();
        return view('admin.pages.tour', compact('steps', 'faqs'));
    }

    public function bus_page()
    {
        $steps = Step::where('step_type', 4)->get();
        $faqs = Faq::where('faq_type', 4)->get();
        return view('admin.pages.bus', compact('steps', 'faqs'));
    }

    public function hotel_page()
    {
        $steps = Step::where('step_type', 3)->get();
        $faqs = Faq::where('faq_type', 3)->get();
        return view('admin.pages.hotel', compact('steps', 'faqs'));
    }

    public function van_page()
    {
        $vans = Van::all();
        $steps = Step::where('step_type', 5)->get();
        $faqs = Faq::where('faq_type', 5)->get();
        return view('admin.pages.van', compact('steps', 'faqs', 'vans'));
    }

    public function update_step($id, StepFormRequest $request)
    {
        $step = Step::whereId($id)->firstOrFail();
        $step_type = $step->step_type;
        $step->step_desc = $request->get('description');
        $step->save();
        if ($step_type == 1) {
            return redirect('admin/pages/flight')->with('status', 'Airline Ticketing Step was successfully updated.');
        }
        else if ($step_type == 2) {
            return redirect('admin/pages/custom-tour')->with('status', 'Custom Tour Step was successfully updated.');
        }
        else if ($step_type == 3) {
            return redirect('admin/pages/hotel')->with('status', 'Hotel Reservation Step was successfully updated.');
        }
        else if ($step_type == 4) {
            return redirect('admin/pages/bus')->with('status', 'Bus Booking Step was successfully updated.');
        }
        else {
            return redirect('admin/pages/van')->with('status', 'Van Rental Step was successfully updated.');
        }
    }

    public function hotel_policy_page()
    {
        $sub = Sub::firstOrFail();
        return view('admin.pages.hotel_policy', compact('sub'));
    }

    public function flight_policy_page()
    {
        $sub = Sub::firstOrFail();
        return view('admin.pages.flight_policy', compact('sub'));
    }

    public function terms_and_conditions_page()
    {
        $sub = Sub::firstOrFail();
        return view('admin.pages.terms_and_conditions', compact('sub'));
    }

    public function work_with_us_page()
    {
        $sub = Sub::firstOrFail();
        return view('admin.pages.work_with_us', compact('sub'));
    }

    public function update_sub($id, SubFormRequest $request) 
    {
        //1 for hotel; 2 for flight; 3 for terms and conditions; 4 for work with us;
        $sub = Sub::whereId($id)->firstOrFail();
        if ($request->get('sub_type') == 1) {
            //hotel-policy
            $sub->hotel_policy = $request->get('description');
            $sub->save();
            return redirect('admin/pages/hotel-policy')->with('status', 'Hotel Policy page has been successfully updated.');
        }
        else if ($request->get('sub_type') == 2) {
            //flight-policy
            $sub->flight_policy = $request->get('description');
            $sub->save();
            return redirect('admin/pages/flight-policy')->with('status', 'Flight Policy page has been successfully updated.');
        }
        else if ($request->get('sub_type') == 3) {
            //terms-and-conditions
            $sub->terms_and_conditions = $request->get('description');
            $sub->save();
            return redirect('admin/pages/terms-and-conditions')->with('status', 'Terms and conditions page has been successfully updated.');
        }
        else {
            //work-with-us
            $sub->work_with_us = $request->get('description');
            $sub->save();
            return redirect('admin/pages/work-with-us')->with('status', 'Work with us page has been successfully updated.');
        }
    }


    public function settings()
    {
        $homepage = Homepage::firstOrFail();
        return view('admin.settings', compact('homepage'));
    }

    public function update_settings(SettingsFormRequest $request)
    {
        $homepage = Homepage::firstOrFail();
        $homepage->email_address = $request->get('email_address');
        $homepage->address = $request->get('address');
        $homepage->phone_number = $request->get('phone_number');
        $homepage->tax = $request->get('tax');
        $homepage->save();
        return redirect('admin/settings')->with('status', 'Information successfully updated');
    }    
    
    public function blog()
    {
        $posts = Post::select('posts.id', 'posts.title', 'posts.content', 'posts.slug', 'posts.status', 'posts.author', 'posts.meta_description', 'posts.meta_keys', 'posts.date_published', 'posts.featured_img', 'posts.category_id', 'm.src')->leftJoin('medias as m', 'posts.featured_img', '=', 'm.id')->orderBy('posts.date_published')->get();
        $categories = Category::all();
        //if category == 0 : category == "others"
        return view('admin.blogs', compact('posts', 'categories'));
    }

    public function add_new_blog()
    {
        $categories = Category::pluck('name', 'id');
        $categories[0] = "Others";
        return view('admin.new_blog', compact('categories'));
    }

    public function save_new_blog(BlogFormRequest $request)
    {
        $title = $request->get('post-title');
        $content = $request->get('content');
        $slug = $request->get('slug');
        $category_id = $request->get('category');
        $meta_description = $request->get('meta_description');
        $meta_keys = $request->get('meta_keys');
        $featured_img = $request->featured_img;
        echo $title."<br>";
        echo $content."<br>";
        echo $slug."<br>";
        echo $category_id."<br>";
        echo $meta_description."<br>";
        echo $meta_keys."<br>";
        print_r($featured_img);
    }


    public function newsletter() {
        return view('admin.newsletter');
    }


}