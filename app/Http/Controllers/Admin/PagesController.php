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
use App\Http\Requests\BusTravelLocationFormRequest;
use App\BusTravelLocation;
use App\DropOffPoint;
use App\Http\Requests\RouteFormRequest;
use App\Http\Requests\DropOffFormRequest;
use App\Http\Requests\EditRouteFormRequest;




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
        $locations = BusTravelLocation::pluck('location_name', 'id');
        return view('admin.pages.bus', compact('steps', 'faqs', 'locations'));
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
    
    


    public function newsletter() {
        return view('admin.newsletter');
    }


    public function new_bus_travel_location(BusTravelLocationFormRequest $request) {
        $bus_travel_location = new BusTravelLocation(array(
            'location_name' => $request->get('location_name'),
        ));

        $bus_travel_location->save();
        return redirect('/admin/pages/bus')->with('status', $request->location_name.' has been successfully added. You can see it in the drop down of the location field whenever you try to manage a route.');
    }

    public function new_route(RouteFormRequest $request) {
        $location = BusTravelLocation::whereId($request->get('drop_off_point'))->firstOrFail();
        //echo $location->location_name
        $route = new DropOffPoint(array(
            'origin' => $request->get('origin'),
            'destination' => $request->get('destination'),
            'drop_off_point' => $request->get('drop_off_point'),
            'drop_off_point_name' => $location->location_name
        ));
        $route->save();
        return redirect('/admin/pages/bus')->with('status', 'Route has been successfully added. You can add more drop off points if you click on the row of the route that you have created.');
    }

    public function delete_drop_off_point($id) {

        $drop_off_point = DropOffPoint::whereId($id)->firstOrFail();
        $is_there = DropOffPoint::whereRaw(DB::raw('origin = '.$drop_off_point->origin.' and  destination = '.$drop_off_point->destination))->get();
        if (count($is_there) > 1) {
            $drop_off_point->delete();
            return redirect('/admin/pages/bus')->with('status', 'Drop Off Point Has been successfully deleted.');
        }
        else {
            return redirect('/admin/pages/bus')->with('error', 'There should be at least 1 drop off point.');
        }
    }

    public function new_drop_off_point(DropOffFormRequest $request) {
        $location = BusTravelLocation::whereId($request->get('drop_off_point_id'))->firstOrFail();
        //echo $location->location_name
        $is_there = DropOffPoint::whereRaw(DB::raw('origin = '.$request->get('origin_id').' and  destination = '.$request->get('destination_id').' and drop_off_point = '.$request->get('drop_off_point_id')))->get();
        //return count($is_there);
        if (count($is_there) > 0) {
            return redirect('/admin/pages/bus')->with('error', 'Drop off point is already there.');
        }
        else {
            $route = new DropOffPoint(array(
                'origin' => $request->get('origin_id'),
                'destination' => $request->get('destination_id'),
                'drop_off_point' => $request->get('drop_off_point_id'),
                'drop_off_point_name' => $location->location_name
            ));
            $route->save();
            return redirect('/admin/pages/bus')->with('status', 'Drop off point has been successfully added.');
        }
        
    }

    public function delete_route($o, $d) {
        $routes = DropOffPoint::whereRaw(DB::raw('origin = '.$o.' and  destination = '.$d))->get();
        foreach ($routes as $route) {
            $route->delete();
        }
        return redirect('admin/pages/bus')->with('status', 'Route has been successfully deleted');
    }

    public function edit_route($o, $d, EditRouteFormRequest $request) {
        $routes = DB::table('drop_off_points')->whereRaw(DB::raw('origin = '.$o.' and  destination = '.$d))->update(['origin' => $request->get('origin'), 'destination' => $request->get('destination')]);
        //return 'origin: '.$request->get('origin').'<br> destination: '.$request->get('destination');
        //foreach ($routes as $route) {
            // $routes->origin = $request->get('origin');
            // $routes->destination = $request->get('destination');
            //$routes
        //}
        return redirect('admin/pages/bus')->with('status', 'Route has been successfully updated');
    }

    public function edit_bus_travel_location($id, BusTravelLocationFormRequest $request) {
        $location = BusTravelLocation::whereId($id)->firstOrFail();
        $location->location_name = $request->location_name;
        $location->save();
        return redirect('admin/pages/bus')->with('status', 'Location has been successfully updated');
    }

    public function delete_bus_travel_location($id) {
        $location = BusTravelLocation::whereId($id)->firstOrFail();
        $location->delete();
        return redirect('admin/pages/bus')->with('status', 'Location has been successfully deleted');
    }

}