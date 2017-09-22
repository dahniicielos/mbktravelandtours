<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\CustomTourPackage;
use App\FlightInquiry;
use App\HotelReservationInquiry;
use App\BusInquiry;
use App\VanRentalInquiry;
use App\Purchase;
use App\PurchasedItem;
use App\Van;
use App\User;
use App\RoleUser;
use App\Subscriber;
use App\BusTravelLocation;
use App\DropOffPoint;


class AjaxController extends Controller
{

	//======================  CUSTOM TOUR INQUIRY (custom_tour_packages)  ======================//

	//NO JOIN

	public function get_all_pending_tour_inquiries() {
		$pending_tour_inquiries = CustomTourPackage::where('remark', 0)->get();
		$data["data"] = [];
		foreach ($pending_tour_inquiries as $ptr) {
			$id = $ptr->id;
			$name = $ptr->name;
			$location = $ptr->location;
			$timeframe = $ptr->no_of_days."D".$ptr->no_of_nights."N";
			$budget = "₱ ".number_format($ptr->min_budget, 2, '.', ',')."/pax - ₱ ".number_format($ptr->max_budget, 2, '.', ',')."/pax";
			$no_of_pax = $ptr->no_of_pax;
			array_push($data["data"], ['id' => $id, 'name' => $name, 'location' => $location, 'timeframe' => $timeframe, 'budget' => $budget, 'no_of_pax' => $no_of_pax]);
		}
		return json_encode($data);
	}

	public function get_tour_inquiries() {
		$handled_tour_inquiries = CustomTourPackage::where('remark', '!=', 0)->get();
		$data["data"] = [];
		foreach ($handled_tour_inquiries as $htr) {
			$id = $htr->id;
			$name = $htr->name;
			$location = $htr->location;
			$timeframe = $htr->no_of_days."D".$htr->no_of_nights."N";
			$budget = "₱ ".number_format($htr->min_budget, 2, '.', ',')."/pax - ₱ ".number_format($htr->max_budget, 2, '.', ',')."/pax";
			$no_of_pax = $htr->no_of_pax;
			$remark = $htr->remark;
			if ($remark == 1) {
				$remark = '<center><span class="label label-warning">Processing</span></center>';
			}
			else if ($remark == 2) {
				$remark = '<center><span class="label label-success">Processed</span></center>';
			}
			else {
				$remark = '<center><span class="label label-danger">Cancelled</span></center>';
			}
			array_push($data["data"], ['id' => $id, 'name' => $name, 'location' => $location, 'timeframe' => $timeframe, 'budget' => $budget, 'no_of_pax' => $no_of_pax, 'remark' => $remark]);
		}
		return json_encode($data);
	}

	public function get_tour_inquiry($id) {
        $tour_inquiry = CustomTourPackage::whereId($id)->first();
        $data = [];
        $name = $tour_inquiry->name;
        $phone_number = $tour_inquiry->phone_number;
        $birthday = $tour_inquiry->birthday;
        $age = date("Y", strtotime($birthday));
        $age = date("Y") - $age;
        $bday_and_age = $birthday." (".$age.")";
		$location = $tour_inquiry->location;
		$timeframe = $tour_inquiry->no_of_days."D".$tour_inquiry->no_of_nights."N";
		$budget = "₱ ".number_format($tour_inquiry->min_budget, 2, '.', ',')."/pax - ₱ ".number_format($tour_inquiry->max_budget, 2, '.', ',')."/pax";
		$no_of_pax = $tour_inquiry->no_of_pax;
		$email = $tour_inquiry->email_address;
		$remark = $tour_inquiry->remark;
		$status = $remark;
		if ($remark == 0) {
			$remark = '<span class="label label-primary">Pending</span>';
		}
		else if ($remark == 1) {
			$remark = '<span class="label label-warning">Processing</span>';
		}
		else if ($remark == 2) {
			$remark = '<span class="label label-success">Processed</span>';
		}
		else {
			$remark = '<span class="label label-danger">Cancelled</span>';
		}

        array_push($data, ['id' => $id, 'name' => $name, 'phone_number' => $phone_number, 'email' => $email, 'location' => $location, 'timeframe' => $timeframe, 'budget' => $budget, 'no_of_pax' => $no_of_pax, 'bday_and_age' => $bday_and_age, 'remark' => $remark, 'status' => $status]);
        //return date("Y", strtotime($birthday));
        return json_encode($data);
	}

	public function mark_as_processed_tour_inquiry($id) {
		$custom_tour_package = CustomTourPackage::whereId($id)->firstOrFail();
		$custom_tour_package->remark = 2;
	    if ($custom_tour_package->save()) {
	    	return "success";
	    }
	    else {
	    	return "error";
	    }
	}

	public function delete_tour_inquiry($id) {
		$custom_tour_package = CustomTourPackage::whereId($id)->firstOrFail();
        if ($custom_tour_package->delete()) {
        	return "success";
        }
        else {
        	return "error";
        }
	}

	//=====================  FLIGHT RESERVATION INQUIRY (flight_inquiries)  =====================//

	//   WITH JOIN

	public function get_all_pending_flight_inquiries() {
		$pending_flight_reservation = FlightInquiry::select('flight_inquiries.id', 'flight_inquiries.name', 'flight_inquiries.location_from', 'flight_inquiries.location_to', 'flight_inquiries.date_departure', 'flight_inquiries.date_return', 'loc_from.location_code as from', 'loc_to.location_code as to')
        ->leftJoin('locations as loc_from', 'flight_inquiries.location_from', '=', 'loc_from.id')
		->leftJoin('locations as loc_to', 'flight_inquiries.location_to', '=', 'loc_to.id')
        ->where('remark', 0)->get();

        $data["data"] = [];
		foreach ($pending_flight_reservation as $pfr) {
			$id = $pfr->id;
			$name = $pfr->name;
			$loc_from = $pfr->from;
			$loc_to = $pfr->to;
			$departure = date("F j, Y", strtotime($pfr->date_departure));
			$return = date("F j, Y", strtotime($pfr->date_return));
			array_push($data["data"], ['id' => $id, 'name' => $name, 'loc_from' => $loc_from, 'loc_to' => $loc_to, 'departure' => $departure, 'return' => $return]);
		}

		return json_encode($data);
	}

	public function get_flight_inquiries() {
		$flight_reservation = FlightInquiry::select('flight_inquiries.id', 'flight_inquiries.name', 'flight_inquiries.location_from', 'flight_inquiries.location_to', 'flight_inquiries.date_departure', 'flight_inquiries.date_return', 'loc_from.location_code as from', 'loc_to.location_code as to', 'flight_inquiries.remark')
        ->leftJoin('locations as loc_from', 'flight_inquiries.location_from', '=', 'loc_from.id')
		->leftJoin('locations as loc_to', 'flight_inquiries.location_to', '=', 'loc_to.id')
        ->where('remark', '!=', 0)->get();

        $data["data"] = [];
		foreach ($flight_reservation as $fr) {
			$id = $fr->id;
			$name = $fr->name;
			$loc_from = $fr->from;
			$loc_to = $fr->to;
			$departure = date("F j, Y", strtotime($fr->date_departure));
			$return = date("F j, Y", strtotime($fr->date_return));
			$remark = $fr->remark;
			if ($remark == 1) {
				$remark = '<center><span class="label label-warning">Processing</span></center>';
			}
			else if ($remark == 2) {
				$remark = '<center><span class="label label-success">Processed</span></center>';
			}
			else {
				$remark = '<center><span class="label label-danger">Cancelled</span></center>';
			}
			array_push($data["data"], ['id' => $id, 'name' => $name, 'loc_from' => $loc_from, 'loc_to' => $loc_to, 'departure' => $departure, 'return' => $return, 'remark' => $remark]);
		}

		return json_encode($data);

	}

	public function get_flight_inquiry($id) {
		$flight_inquiry = FlightInquiry::select('flight_inquiries.id', 'flight_inquiries.name', 'flight_inquiries.location_from', 'flight_inquiries.location_to', 'flight_inquiries.date_departure', 'flight_inquiries.date_return', 'loc_from.location_code as from_code', 'loc_from.location_name as from_name', 'loc_to.location_code as to_code', 'loc_to.location_name as to_name', 'flight_inquiries.phone_number', 'flight_inquiries.email_address', 'flight_inquiries.flight_type', 'flight_inquiries.flight_route', 'flight_inquiries.child_no', 'flight_inquiries.infant_no', 'flight_inquiries.adult_no', 'flight_inquiries.remark')
        ->leftJoin('locations as loc_from', 'flight_inquiries.location_from', '=', 'loc_from.id')
		->leftJoin('locations as loc_to', 'flight_inquiries.location_to', '=', 'loc_to.id')
        ->where('flight_inquiries.id', $id)->firstOrFail();

        $data = [];
		
		$id = $flight_inquiry->id;
		$name = $flight_inquiry->name;
		$email = $flight_inquiry->email_address;
		$birthday = $flight_inquiry->birthday;
        $age = date("Y", strtotime($birthday));
        $age = date("Y") - $age;
        $bday_and_age = $birthday." (".$age.")";
		$phone_number = $flight_inquiry->phone_number;
		$adult_no = $flight_inquiry->adult_no;
		$child_no = $flight_inquiry->child_no;
		$infant_no = $flight_inquiry->infant_no;
		$flight_route = $flight_inquiry->flight_route;
		if ($flight_route == 0) {
			$flight_route = "One way";
		}
		else {
			$flight_route = "Round Trip";
		}
		$flight_type = $flight_inquiry->flight_type;
		if ($flight_type == 0) {
			$flight_type = "Direct Flight";
		}
		else {
			$flight_type = "Connecting Flight";
		}
		$loc_from = $flight_inquiry->from;
		$loc_to = $flight_inquiry->to;
		$origin = $flight_inquiry->from_name." (".$flight_inquiry->from_code.")";
		$destination = $flight_inquiry->to_name." (".$flight_inquiry->to_code.")";
		$departure = date("F j, Y", strtotime($flight_inquiry->date_departure));
		$return = date("F j, Y", strtotime($flight_inquiry->date_return));
		$remark = $flight_inquiry->remark;
		$status = $remark;
		if ($remark == 0) {
			$remark = '<span class="label label-primary">Pending</span>';
		}
		else if ($remark == 1) {
			$remark = '<span class="label label-warning">Processing</span>';
		}
		else if ($remark == 2) {
			$remark = '<span class="label label-success">Processed</span>';
		}
		else {
			$remark = '<span class="label label-danger">Cancelled</span>';
		}


		array_push($data, ['id' => $id, 'name' => $name, 'departure' => $departure, 'return' => $return, 'remark' => $remark, 'email' => $email, 'bday_and_age' => $bday_and_age, 'phone_number' => $phone_number, 'adult_no' => $adult_no, 'child_no' => $child_no, 'infant_no' => $infant_no, 'flight_route' => $flight_route, 'flight_type' => $flight_type, 'origin' => $origin, 'destination' => $destination, 'status' => $status]);
		

		return json_encode($data);

	}

	public function mark_as_processed_flight_inquiry($id) {
		$flight_inquiry = FlightInquiry::whereId($id)->firstOrFail();
		$flight_inquiry->remark = 2;
	    if ($flight_inquiry->save()) {
	    	return "success";
	    }
	    else {
	    	return "error";
	    }
	}

	public function delete_flight_inquiry($id) {
		$flight_inquiry = FlightInquiry::whereId($id)->firstOrFail();
        if ($flight_inquiry->delete()) {
        	return "success";
        }
        else {
        	return "error";
        }
	}


	//=================  HOTEL RESERVATION INQUIRY (hotel_reservation_inquiries) =================//

	public function get_all_pending_hotel_inquiries() {
		$pending_hotel_inquiries = HotelReservationInquiry::where('remark', 0)->get();
		$data["data"] = [];
		foreach ($pending_hotel_inquiries as $phi) {
			$id = $phi->id;
			$name = $phi->name;
			$location = $phi->location;
			$check_in = date("F j, Y", strtotime($phi->check_in));
			$check_out = date("F j, Y", strtotime($phi->check_out));
			$no_of_pax = $phi->no_of_pax;
			array_push($data["data"], ['id' => $id, 'name' => $name, 'location' => $location, 'check_in' => $check_in, 'check_out' => $check_out, 'no_of_pax' => $no_of_pax]);
		}
		return json_encode($data);
	}

	public function get_hotel_inquiries() {
		$handled_hotel_inquiries = HotelReservationInquiry::where('remark', '!=', 0)->get();
		$data["data"] = [];
		foreach ($handled_hotel_inquiries as $hti) {
			$id = $hti->id;
			$name = $hti->name;
			$location = $hti->location;
			$check_in = date("F j, Y", strtotime($hti->check_in));
			$check_out = date("F j, Y", strtotime($hti->check_out));
			$no_of_pax = $hti->no_of_pax;
			$remark = $hti->remark;
			if ($remark == 1) {
				$remark = '<center><span class="label label-warning">Processing</span></center>';
			}
			else if ($remark == 2) {
				$remark = '<center><span class="label label-success">Processed</span></center>';
			}
			else {
				$remark = '<center><span class="label label-danger">Cancelled</span></center>';
			}
			array_push($data["data"], ['id' => $id, 'name' => $name, 'location' => $location, 'check_in' => $check_in, 'check_out' => $check_out, 'no_of_pax' => $no_of_pax, 'remark' => $remark]);
		}
		return json_encode($data);
	}

	public function get_hotel_inquiry($id) {
        $hotel_inquiry = HotelReservationInquiry::whereId($id)->first();
        $data = [];

        $name = $hotel_inquiry->name;
        $phone_number = $hotel_inquiry->phone_number;
        $birthday = $hotel_inquiry->birthday;
        $age = date("Y", strtotime($birthday));
        $age = date("Y") - $age;
        $bday_and_age = $birthday." (".$age.")";
        $email = $hotel_inquiry->email_address;

		$location = $hotel_inquiry->location;
		$check_in = date("F j, Y", strtotime($hotel_inquiry->check_in));
		$check_out = date("F j, Y", strtotime($hotel_inquiry->check_out));
		$no_of_pax = $hotel_inquiry->no_of_pax;
		
		$adult_no = $hotel_inquiry->adult_no;
		$child_no = $hotel_inquiry->child_no;

		$for_work = $hotel_inquiry->for_work;
		if ($for_work == 1) {
			$for_work = '<span class="label label-success">Yes</span>';
		}
		else {
			$for_work = '<span class="label label-danger">No</span>';
		}
		$remark = $hotel_inquiry->remark;
		$status = $remark;
		if ($remark == 0) {
			$remark = '<span class="label label-primary">Pending</span>';
		}
		else if ($remark == 1) {
			$remark = '<span class="label label-warning">Processing</span>';
		}
		else if ($remark == 2) {
			$remark = '<span class="label label-success">Processed</span>';
		}
		else {
			$remark = '<span class="label label-danger">Cancelled</span>';
		}

        array_push($data, ['id' => $id, 'name' => $name, 'phone_number' => $phone_number, 'email' => $email, 'bday_and_age' => $bday_and_age, 'location' => $location, 'check_in' => $check_in, 'check_out' => $check_out, 'no_of_pax' => $no_of_pax, 'remark' => $remark, 'status' => $status, 'adult_no' => $adult_no, 'child_no' => $child_no, 'for_work' => $for_work]);
        //return date("Y", strtotime($birthday));
        return json_encode($data);
	}

	public function mark_as_processed_hotel_inquiry($id) {
		$hotel_inquiry = HotelReservationInquiry::whereId($id)->firstOrFail();
		$hotel_inquiry->remark = 2;
	    if ($hotel_inquiry->save()) {
	    	return "success";
	    }
	    else {
	    	return "error";
	    }
	}

	public function delete_hotel_inquiry($id) {
		$hotel_inquiry = HotelReservationInquiry::whereId($id)->firstOrFail();
        if ($hotel_inquiry->delete()) {
        	return "success";
        }
        else {
        	return "error";
        }
	}

	//===========================  BUS BOOKING INQUIRY (bus_inquiries)  ===========================//

	public function get_all_pending_bus_inquiries() {
		$pending_bus_inquiries = BusInquiry::select('bus_inquiries.id', 'bus_inquiries.name', 'bus_inquiries.origin', 'bus_inquiries.destination', 'bus_inquiries.date_departure', 'bus_inquiries.date_return', 'orig.location_name as from', 'dest.location_name as to')
        ->leftJoin('bus_travel_locations as orig', 'bus_inquiries.origin', '=', 'orig.id')
		->leftJoin('bus_travel_locations as dest', 'bus_inquiries.destination', '=', 'dest.id')
		->where('remark', 0)->get();

        $data["data"] = [];
		foreach ($pending_bus_inquiries as $pbi) {
			$id = $pbi->id;
			$name = $pbi->name;
			$origin = $pbi->from;
			$destination = $pbi->to;
			$departure = date("F j, Y", strtotime($pbi->date_departure));
			$return = date("F j, Y", strtotime($pbi->date_return));
			array_push($data["data"], ['id' => $id, 'name' => $name, 'origin' => $origin, 'destination' => $destination, 'departure' => $departure, 'return' => $return]);
		}

		return json_encode($data);
	}

	public function get_bus_inquiries() {
		$bus_inquiries = BusInquiry::select('bus_inquiries.id', 'bus_inquiries.name', 'bus_inquiries.origin', 'bus_inquiries.destination', 'bus_inquiries.date_departure', 'bus_inquiries.date_return', 'bus_inquiries.remark', 'orig.location_name as from', 'dest.location_name as to')
        ->leftJoin('bus_travel_locations as orig', 'bus_inquiries.origin', '=', 'orig.id')
		->leftJoin('bus_travel_locations as dest', 'bus_inquiries.destination', '=', 'dest.id')
		->where('remark', '!=', 0)->get();

        $data["data"] = [];
		foreach ($bus_inquiries as $bi) {
			$id = $bi->id;
			$name = $bi->name;
			$origin = $bi->from;
			$destination = $bi->to;
			$departure = date("F j, Y", strtotime($bi->date_departure));
			$return = date("F j, Y", strtotime($bi->date_return));
			$remark = $bi->remark;
			if ($remark == 1) {
				$remark = '<center><span class="label label-warning">Processing</span></center>';
			}
			else if ($remark == 2) {
				$remark = '<center><span class="label label-success">Processed</span></center>';
			}
			else {
				$remark = '<center><span class="label label-danger">Cancelled</span></center>';
			}
			array_push($data["data"], ['id' => $id, 'name' => $name, 'origin' => $origin, 'destination' => $destination, 'departure' => $departure, 'return' => $return, 'remark' => $remark]);
		}

		return json_encode($data);

	}

	public function get_bus_inquiry($id) {
		$bus_inquiry = BusInquiry::select('bus_inquiries.id', 'bus_inquiries.name', 'bus_inquiries.birthday', 'bus_inquiries.phone_number', 'bus_inquiries.email_address', 'bus_inquiries.travel_type', 'bus_inquiries.origin', 'bus_inquiries.destination', 'bus_inquiries.remark', 'bus_inquiries.date_departure', 'bus_inquiries.date_return', 'orig.location_name as from', 'dest.location_name as to')
        ->leftJoin('bus_travel_locations as orig', 'bus_inquiries.origin', '=', 'orig.id')
		->leftJoin('bus_travel_locations as dest', 'bus_inquiries.destination', '=', 'dest.id')
		->where('bus_inquiries.id', $id)->first();

        $data = [];
		
		$id = $bus_inquiry->id;
		$name = $bus_inquiry->name;
		$email = $bus_inquiry->email_address;
		$birthday = $bus_inquiry->birthday;
        $age = date("Y", strtotime($birthday));
        $age = date("Y") - $age;
        $bday_and_age = $birthday." (".$age.")";
		$phone_number = $bus_inquiry->phone_number;

		$travel_type = $bus_inquiry->travel_type;
		if ($travel_type == 0) {
			$travel_type = "One way";
		}
		else {
			$travel_type = "Round Trip";
		}

		$origin = $bus_inquiry->from;
		$destination = $bus_inquiry->to;
		$departure = date("F j, Y", strtotime($bus_inquiry->date_departure));
		$return = date("F j, Y", strtotime($bus_inquiry->date_return));
		$remark = $bus_inquiry->remark;
		$status = $remark;
		if ($remark == 0) {
			$remark = '<span class="label label-primary">Pending</span>';
		}
		else if ($remark == 1) {
			$remark = '<span class="label label-warning">Processing</span>';
		}
		else if ($remark == 2) {
			$remark = '<span class="label label-success">Processed</span>';
		}
		else {
			$remark = '<span class="label label-danger">Cancelled</span>';
		}
		$id_number = $bus_inquiry->id_number;
		if (empty($id_number)) {
			$id_number = "-";
		}


		array_push($data, ['id' => $id, 'name' => $name, 'departure' => $departure, 'return' => $return, 'remark' => $remark, 'email' => $email, 'bday_and_age' => $bday_and_age, 'phone_number' => $phone_number, 'travel_type' => $travel_type, 'origin' => $origin, 'destination' => $destination, 'status' => $status, 'id_number' => $id_number]);
		

		return json_encode($data);

	}

	public function mark_as_processed_bus_inquiry($id) {
		$bus_inquiry = BusInquiry::whereId($id)->firstOrFail();
		$bus_inquiry->remark = 2;
	    if ($bus_inquiry->save()) {
	    	return "success";
	    }
	    else {
	    	return "error";
	    }
	}

	public function delete_bus_inquiry($id) {
		$bus_inquiry = BusInquiry::whereId($id)->firstOrFail();
        if ($bus_inquiry->delete()) {
        	return "success";
        }
        else {
        	return "error";
        }
	}


	//========================  VAN RENTAL INQUIRY (van_rental_inquiries)  ========================//


	public function get_all_pending_van_inquiries() {
		$pending_van_inquiries = VanRentalInquiry::where('remark', 0)->get();
		$data["data"] = [];
		foreach ($pending_van_inquiries as $pvi) {
			$id = $pvi->id;
			$name = $pvi->name;
			$from = $pvi->location_from;
			$to = $pvi->location_to;
			$rental_day_start = date("F j, Y", strtotime($pvi->rental_day_start));
			$rental_day_end = date("F j, Y", strtotime($pvi->rental_day_end));
			array_push($data["data"], ['id' => $id, 'name' => $name, 'from' => $from, 'to' => $to, 'rental_day_start' => $rental_day_start, 'rental_day_end' => $rental_day_end]);
		}
		return json_encode($data);
	}

	public function get_van_inquiries() {
		$van_inquiries = VanRentalInquiry::where('remark', '!=', 0)->get();
		$data["data"] = [];
		foreach ($van_inquiries as $vi) {
			$id = $vi->id;
			$name = $vi->name;
			$from = $vi->location_from;
			$to = $vi->location_to;
			$rental_day_start = date("F j, Y", strtotime($vi->rental_day_start));
			$rental_day_end = date("F j, Y", strtotime($vi->rental_day_end));
			$remark = $vi->remark;
			if ($remark == 1) {
				$remark = '<center><span class="label label-warning">Processing</span></center>';
			}
			else if ($remark == 2) {
				$remark = '<center><span class="label label-success">Processed</span></center>';
			}
			else {
				$remark = '<center><span class="label label-danger">Cancelled</span></center>';
			}
			array_push($data["data"], ['id' => $id, 'name' => $name, 'from' => $from, 'to' => $to, 'rental_day_start' => $rental_day_start, 'rental_day_end' => $rental_day_end, 'remark' => $remark]);
		}
		return json_encode($data);
	}

	public function get_van_inquiry($id) {//WITH JOIN TO VANS
        $van_inquiry = VanRentalInquiry::select('van_rental_inquiries.id', 'van_rental_inquiries.name', 'van_rental_inquiries.phone_number', 'van_rental_inquiries.email_address', 'van_rental_inquiries.birthday', 'van_rental_inquiries.location_from', 'van_rental_inquiries.location_to', 'van_rental_inquiries.rental_day_start', 'van_rental_inquiries.rental_day_end', 'van_rental_inquiries.remark', 'vans.brand', 'vans.model', 'vans.no_of_seats')
        ->leftJoin('vans', 'van_rental_inquiries.van_id', '=', 'vans.id')
        ->where('van_rental_inquiries.id', $id)->first();
        $data = [];

        $name = $van_inquiry->name;
        $phone_number = $van_inquiry->phone_number;
        $birthday = $van_inquiry->birthday;
        $age = date("Y", strtotime($birthday));
        $age = date("Y") - $age;
        $bday_and_age = $birthday." (".$age.")";
        $email = $van_inquiry->email_address;

		$from = $van_inquiry->location_from;
		$to = $van_inquiry->location_to;
		$rental_day_start = date("F j, Y", strtotime($van_inquiry->rental_day_start));
		$rental_day_end = date("F j, Y", strtotime($van_inquiry->rental_day_end));
		
		$van_type = $van_inquiry->brand." ".$van_inquiry->model." (".$van_inquiry->no_of_seats."-seater)";

		$remark = $van_inquiry->remark;
		$status = $remark;
		if ($remark == 0) {
			$remark = '<span class="label label-primary">Pending</span>';
		}
		else if ($remark == 1) {
			$remark = '<span class="label label-warning">Processing</span>';
		}
		else if ($remark == 2) {
			$remark = '<span class="label label-success">Processed</span>';
		}
		else {
			$remark = '<span class="label label-danger">Cancelled</span>';
		}

        array_push($data, ['id' => $id, 'name' => $name, 'phone_number' => $phone_number, 'email' => $email, 'bday_and_age' => $bday_and_age, 'from' => $from, 'rental_day_start' => $rental_day_start, 'rental_day_end' => $rental_day_end, 'to' => $to, 'remark' => $remark, 'status' => $status, 'van_type' => $van_type]);
        //return date("Y", strtotime($birthday));
        return json_encode($data);
	}



	public function get_van_info($id) 
	{
		$van = Van::whereId($id)->firstOrFail();
		$data = [];

		//brand
		//model
		//no_of_seats
		//description
		//van_image
		$id = $van->id;
		$brand = $van->brand;
		$model = $van->model;
		$no_of_seats = $van->no_of_seats;
		$description = $van->description;
		$van_image = $van->van_image;
        array_push($data, ['id' => $id, 'brand' => $brand, 'model' => $model, 'no_of_seats' => $no_of_seats, 'description' => $description, 'van_image' => $van_image]);
        return json_encode($data);
	}


	public function mark_as_processed_van_inquiry($id) {
		$van_inquiry = VanRentalInquiry::whereId($id)->firstOrFail();
		$van_inquiry->remark = 2;
	    if ($van_inquiry->save()) {
	    	return "success";
	    }
	    else {
	    	return "error";
	    }
	}

	public function delete_van_inquiry($id) {
		$van_inquiry = VanRentalInquiry::whereId($id)->firstOrFail();
        if ($van_inquiry->delete()) {
        	return "success";
        }
        else {
        	return "error";
        }
	}







	//=========================================  TOUR CLIENTS  =========================================//

	public function get_pending_tour_clients() {
		//purchase_status = 0 or 1
		$purchases = Purchase::select('purchases.id', 'users.first_name', 'users.last_name', 'purchases.purchase_status')
		->leftJoin('users', 'purchases.user_id', '=', 'users.id')
		->where('purchases.purchase_status', '<=', '1')
		->get();
		$data["data"] = [];
		foreach ($purchases as $p) {
			$id = $p->id;
			$purchased_items = PurchasedItem::where('purchase_id', $id)->get();
			$package = "";
			$chosen_travel_date = "";
			$counter = 0;
			foreach ($purchased_items as $pi) {
				if ($counter > 0) {
					$package .= "<br>";
					$chosen_travel_date .= "<br>";
				}
				$package .= $pi->package_name." (".$pi->package_type.")";
				$chosen_travel_date .= date("F j, Y", strtotime($pi->chosen_travel_date));
				$counter++;
			}
			$name = $p->first_name." ".$p->last_name;
			
			$purchase_status = $p->purchase_status;
			if ($purchase_status == 0) {
				$purchase_status = '<center><span class="label label-warning">Unpaid</span></center>';
			}
			else if ($purchase_status == 1) {
				$purchase_status = '<center><span class="label label-success">Paid</span></center>';
			}
			else if ($purchase_status == 2) {
				$purchase_status = '<center><span class="label label-success">Approved</span></center>';
			}
			else {
				$purchase_status = '<center><span class="label label-danger">Denied</span></center>';
			}
			array_push($data["data"], ['id' => $id, 'name' => $name, 'package' => $package, 'chosen_travel_date' => $chosen_travel_date, 'purchase_status' => $purchase_status]);
		}
		return json_encode($data);
	}

	public function get_previous_tour_clients() {
		//purchase_status = 2
		//purchase_status = 0 or 1
		$purchases = Purchase::select('purchases.id', 'purchases.total', 'users.first_name', 'users.last_name', 'purchases.purchase_status', 'purchases.datetime_paid', 'purchases.subtotal')
		->leftJoin('users', 'purchases.user_id', '=', 'users.id')
		->where('purchases.purchase_status', '2')
		->get();
		$data["data"] = [];
		foreach ($purchases as $p) {
			$id = $p->id;
			$purchased_items = PurchasedItem::where('purchase_id', $id)->get();
			$package = "";
			$chosen_travel_date = "";
			$counter = 0;
			foreach ($purchased_items as $pi) {
				if ($counter > 0) {
					$package .= "<br>";
					$chosen_travel_date .= "<br>";
				}
				$package .= $pi->package_name." (".$pi->package_type.")";
				$chosen_travel_date .= date("F j, Y", strtotime($pi->chosen_travel_date));
				$counter++;
			}
			$name = $p->first_name." ".$p->last_name;
			$paid = date("F j, Y h:i A", strtotime($p->datetime_paid));
			$total = "₱".number_format($p->subtotal, 2, '.', ',');
			array_push($data["data"], ['id' => $id, 'name' => $name, 'package' => $package, 'chosen_travel_date' => $chosen_travel_date, 'total' => $total]);
		}
		return json_encode($data);
	}

	public function get_tour_client_info($id) {
		$p = Purchase::select('purchases.id', 'purchases.total', 'users.first_name', 'users.last_name', 'users.email', 'users.phone_number', 'users.province', 'users.city', 'users.birthday', 'purchases.purchase_status', 'purchases.subtotal', 'purchases.miscellaneous_fee', 'tax', 'purchases.total', 'purchases.datetime_paid', 'purchases.proof_of_purchase')
		->leftJoin('users', 'purchases.user_id', '=', 'users.id')
		->where('purchases.id', $id)
		->firstOrFail();
		$data = [];
		
		$id = $p->id;
		$purchased_items = PurchasedItem::where('purchase_id', $id)->get();
		$package = "";
		$counter = 0;
		$travel_date_period = "";
		foreach ($purchased_items as $pi) {
			if ($counter > 0) {
				$package .= "<br>";
				$travel_date_period .= "<br>";
			}
			$package .= $pi->package_name." (".$pi->package_type.") - ".$pi->customer_pax;
			$travel_date_period .= date("F j, Y", strtotime($pi->chosen_travel_date))." (".$pi->travel_period.")";
			$counter++;
		}

		$name = ucwords($p->first_name)." ".ucwords($p->last_name);
		$birthday = $p->birthday;
        $age = date("Y", strtotime($birthday));
        $age = date("Y") - $age;
        $bday_and_age = $birthday." (".$age.")";
        $email = $p->email;
        $address = ucwords($p->province).", ".ucwords($p->city);
        $phone_number = $p->phone_number;

        $purchase_status = $p->purchase_status;
        $status = $purchase_status;
		if ($purchase_status == 0) {
			$purchase_status = '<span class="label label-warning">Unpaid</span>';
		}
		else if ($purchase_status == 1) {
			$purchase_status = '<span class="label label-success">Paid</span>';
		}
		else if ($purchase_status == 2) {
			$purchase_status = '<span class="label label-success">Approved</span>';
		}
		else {
			$purchase_status = '<span class="label label-danger">Denied</span>';
		}

        $subtotal = "₱ ".number_format($p->subtotal, 2, '.', ',');
        $misc = "₱ ".number_format($p->miscellaneous_fee, 2, '.', ',');
        $tax = "₱ ".number_format($p->tax, 2, '.', ',');
		$paid = date("F j, Y h:i A", strtotime($p->datetime_paid));
		$total = "₱ ".number_format($p->total, 2, '.', ',');

		$proof_of_purchase = '<img src="'.$p->proof_of_purchase.'" style="width: 100%; margin-top: 20px;">';

		array_push($data, ['id' => $id, 'name' => $name, 'bday_and_age' => $bday_and_age, 'email' => $email, 'address' => $address, 'phone_number' => $phone_number, 'package' => $package, 'travel_date_period' => $travel_date_period, 'total' => $total, 'subtotal' => $subtotal,  'misc' => $misc, 'tax' => $tax, 'datetime_paid' => $paid, 'purchase_status' => $purchase_status, 'status' => $status, 'proof_of_purchase' => $proof_of_purchase]);
		
		return json_encode($data);
	}

	public function approve_tour_client($id) {
		$purchase = Purchase::whereId($id)->firstOrFail();
		$purchase->purchase_status = 2;
		if ($purchase->save()) {
			return "success";
		}
		else {
			return "error";
		}
	}

	public function deny_tour_client($id) {
		$purchase = Purchase::whereId($id)->firstOrFail();
        if ($purchase->delete()) {
        	return "success";
        }
        else {
        	return "error";
        }
	}

	function get_all_users() {
		$users = User::orderBy('created_at', 'desc')->get();

		$data["data"] = [];

		foreach ($users as $user) {
			$id = $user->id;
			$name = ucwords($user->first_name)." ".ucwords($user->last_name);
			$email = $user->email;
			$date_joined = date("F j, Y h:i A", strtotime($user->created_at));
			$birthday = $user->birthday;
	        $age = date("Y", strtotime($birthday));
	        $age = date("Y") - $age;
	        $birthday_age = $birthday." (".$age.")";
	        $roles = $user->roles()->get();

	        $membership;
	        $is_admin = false;
	        foreach ($roles as $role) {
	        	if ($role->id == 1) {//admin
	        		$is_admin = true;
	        		break;
	        	}
	        	else {//member
	        		$is_admin = false;
	        		continue;
	        	}
	        }
	        if ($is_admin) {
	        	$membership = '<center><span class="label label-success">Admin</span></center>';
	        }
	        else {
	        	$membership = '<center><span class="label label-primary">Member</span></center>';
	        }
	        array_push($data["data"], ['id' => $id, 'name' => $name, 'email' => $email, 'date_joined' => $date_joined, 'membership' => $membership]);
		}
		return json_encode($data);
	}

	function get_user_info($id) {
		$user = User::whereId($id)->firstOrFail();
		$data = [];
		
		$id = $user->id;


		$profile_picture = '<img src="'.$user->profile_picture.'" style="width: 100%; margin-top: 20px;">';

		$name = ucwords($user->first_name)." ".ucwords($user->last_name);
		$birthday = $user->birthday;
        $age = date("Y", strtotime($birthday));
        $age = date("Y") - $age;
        $birthday_age = date("F j, Y", strtotime($user->birthday))." (".$age.")";
        $email = $user->email;
        $address = ucwords($user->province).", ".ucwords($user->city);
        $phone_number = $user->phone_number;

        $roles = $user->roles()->get();

        $membership;
        $is_admin = false;
        foreach ($roles as $role) {
        	if ($role->id == 1) {//admin
        		$is_admin = true;
        		break;
        	}
        	else {//member
        		$is_admin = false;
        		continue;
        	}
        }
        if ($is_admin) {
        	$membership = '<span class="label label-success">Admin</span>';
        }
        else {
        	$membership = '<span class="label label-primary">Member</span>';
        }

        $date_joined = date("F j, Y h:i A", strtotime($user->created_at));

		array_push($data, ['id' => $id, 'name' => $name, 'birthday_age' => $birthday_age, 'email' => $email, 'address' => $address, 'phone_number' => $phone_number, 'membership' => $membership, 'profile_picture' => $profile_picture, 'date_joined' => $date_joined, 'is_admin' => $is_admin]);
		
		return json_encode($data);
	}

	public function remove_admin_role_from_user($id) {//
		if (Auth::user()->id == $id) {
			return "error";
		}
		else {
			$user = User::whereId($id)->firstOrFail();
			if ($user->hasRole('manager')) {
				//if it is really an admin
				$role_user = RoleUser::whereRaw(DB::raw('user_id = '.$id.' and role_id = 1'))->first();
				if ($role_user = RoleUser::whereRaw(DB::raw('user_id = '.$id.' and role_id = 1'))->delete()) {
					return "success";
				}
				else {
					return "false";
				}
			}
			else {
				//if it is not an admin
				return "error";
			}
		}
	}

	public function add_admin_role_to_user($id) {//
		if (Auth::user()->id == $id) {
			return "error";
		}
		else {
			$user = User::whereId($id)->firstOrFail();
			if ($user->hasRole('manager')) {
				//if it is already an admin
				return "error";
			}
			else {
				if ($user->roles()->attach(1) == '') {
					return "success";
				}
				else {
					return "error";
				}
				
			}
		}
	}

	public function delete_user($id) {
		if (Auth::user()->id == $id) {
			return "error";
		}
		else {
			$user = User::whereId($id)->firstOrFail();
			if ($user->delete()) {
				return "success";
			}
			else {
				return "false";
			}
		}
	}

	public function get_all_subscribers() {
		$subscribers = Subscriber::orderBy('created_at', 'desc')->get();

		$data["data"] = [];

		foreach ($subscribers as $subscriber) {
			$id = $subscriber->id;
			$email = $subscriber->email;
			$uniqid = $subscriber->uniqid;
			$unsubscirbe_btn = '<center><button class="btn btn-danger" onclick="unsubscirbe_user('.$id.', \''.$email.'\')">Unsubscribe</button></center>';
			$date_subscribed = date("F j, Y h:i A", strtotime($subscriber->created_at));
	        array_push($data["data"], ['id' => $id, 'unsubscirbe_btn' => $unsubscirbe_btn, 'email' => $email, 'uniqid' => $uniqid, 'date_subscribed' => $date_subscribed]);
		}
		return json_encode($data);
	}
	
	public function unsubscribe_user($id) {
		$subscriber = Subscriber::whereId($id)->firstOrFail();
		if ($subscriber->delete()) {
			return "success";
		}
		else {
			return "error";
		}
	}


	public function get_all_routes() {
		$drop_off_points = DropOffPoint::select(DB::raw('DISTINCT drop_off_points.origin as origin_id, drop_off_points.destination as destination_id, o.location_name as origin, d.location_name as destination'))
		->leftJoin('bus_travel_locations as o', 'drop_off_points.origin', '=', 'o.id')
		->leftJoin('bus_travel_locations as d', 'drop_off_points.destination', '=', 'd.id')
		->get();
		//return $drop_off_points;
		$data["data"] = [];

		foreach ($drop_off_points as $dop) {
			$origin = $dop->origin;
			$destination = $dop->destination;
			$origin_id = $dop->origin_id;
			$destination_id = $dop->destination_id;
	        array_push($data["data"], ['origin' => $origin, 'destination' => $destination, 'origin_id' => $origin_id, 'destination_id' => $destination_id]);
		}
		return json_encode($data);
	}

	public function get_route_info($o, $d) {
		$drop_off_points = DropOffPoint::select(DB::raw('DISTINCT drop_off_points.origin as origin_id, drop_off_points.destination as destination_id, o.location_name as origin, d.location_name as destination, drop_off_points.drop_off_point_name, drop_off_points.id'))
		->leftJoin('bus_travel_locations as o', 'drop_off_points.origin', '=', 'o.id')
		->leftJoin('bus_travel_locations as d', 'drop_off_points.destination', '=', 'd.id')
		->whereRaw(DB::raw('drop_off_points.origin = '.$o.' and drop_off_points.destination = '.$d))
		->get();
		$data = [];
		$origin_name;
		$destination_name;
		$drop_off_points_names = "";
		$counter = 0;
		foreach ($drop_off_points as $dop) {
			$origin_name = $dop->origin.'&nbsp;<a href="#" class="text-blue" onclick="toggleEditLocation('.$dop->origin_id.')">Edit Location</a>';
			$destination_name = $dop->destination.'&nbsp;<a href="#" class="text-blue" onclick="toggleEditLocation('.$dop->destination_id.')">Edit Location</a>';
			if ($counter > 0) {
				$drop_off_points_names .= ", ".$dop->drop_off_point_name.'&nbsp;';
				if (count($drop_off_points) > 1) {
					$drop_off_points_names .= '<a onclick="removeDropOffPoint('.$dop->id.')"><i class="fa fa-minus-circle" style="color:red"></i></a>';
				}
				
			}
			else {
				$drop_off_points_names .= $dop->drop_off_point_name.'&nbsp;';
				if (count($drop_off_points) > 1) {
					$drop_off_points_names .= '<a onclick="removeDropOffPoint('.$dop->id.')"><i class="fa fa-minus-circle" style="color:red"></i></a>';
				}
				
			}
			$counter++;
		}

		array_push($data, ['origin_name' => $origin_name, 'destination_name' => $destination_name, 'drop_off_points_names' => $drop_off_points_names, 'o' => $o, 'd' => $d]);
		return json_encode($data);
	}

	public function get_location_info($id) {
		$location = BusTravelLocation::whereId($id)->firstOrFail();
		$data = [];
		$location_name = $location->location_name;
		array_push($data, ['location_name' => $location_name, 'id' => $id]);
		return json_encode($data);
	}


}