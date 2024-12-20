<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\BusConfirm;
use App\Models\BusOperators;
use App\Models\BusSeat;
use App\Models\BusType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use GuzzleHttp\Promise\Create;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Psy\Readline\Hoa\Console;
use Stripe\StripeClient;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class BusController extends Controller
{


    public function __construct()
    {
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getMessage());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getMessage());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getMessage());
        }
        return response()->json(compact('user'));
    }

    /* -----------------------------------------------------------------------------------------
    @Description: Function for Get Bus View Booking
    -------------------------------------------------------------------------------------------- */
    public function getBusViewBooking(Request $request, $BusId)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'You are not able login from this application...'], 200);
            }
            $busConfirmData = BusConfirm::where('bus_id', $BusId)->where('booking_status', 'confirm')->get()->toArray();
            $busSeatData = BusSeat::where('bus_id', $BusId)->get()->toArray();
            $matchedSeats = [];

            foreach ($busSeatData as $busData) {
                $foundMatch = false;
                foreach ($busConfirmData as $busConfirm) {
                    if ($busData['seat_numbers'] === $busConfirm['seat_numbers']) {
                        $busData['available'] = true;
                        $matchedSeats[] = $busData;
                        $foundMatch = true;
                        break;
                    }
                }
                if (!$foundMatch) {
                    $busData['available'] = false;
                    $matchedSeats[] = $busData;
                }
            }

            $seatsByBusId = [];

            foreach ($matchedSeats as $seat) {
                $seat_collection = $seat['seat_collection'];
                // print_r($busId);
                // Initialize the seats array for the bus ID if it doesn't exist
                if (!isset($seatsByBusId[$seat_collection])) {
                    $seatsByBusId[$seat_collection] = ['seats' => []];
                }

                // // Add the seat to the seats array for the corresponding bus ID
                $seatsByBusId[$seat_collection]['seats'][] = [
                    'seatNumber' => $seat['seat_numbers'],
                    'class' => $seat['class'],
                    'available' => $seat['available'],
                    'price' => $seat['price']
                ];
            }


            return response()->json(['status' => 'success', 'message' => 'Bus List View Successfull', 'data' => $seatsByBusId]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => "Something went Wrong..."], 200);
        }
    }

    /* -----------------------------------------------------------------------------------------
    @Description: Function for Get Bus View List
    -------------------------------------------------------------------------------------------- */
    public function getBusViewList(Request $request, $from, $to)
    {
        try {
            // Authenticate user using JWT token
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'You are not able to log in from this application...'], 200);
            }

            // Initialize query
            $query = Bus::with('bustype_list', 'busoperators_list');

            // Parse and apply Price filters
            $priceParts = [];
            if ($request->has('price') && !empty($request->price)) {
                $priceParts = explode(',', $request->price);
                $query->whereBetween('price', [$priceParts[0], $priceParts[1]]);
            }

            // Parse and apply bus type filters
            if ($request->has('busType') && !empty($request->busType)) {
                $busType = explode(',', $request->busType);
                $query->whereIn('bus_type', $busType);
            }

            // Parse and apply bus operators filters
            if ($request->has('busOperators') && !empty($request->busOperators)) {
                $busOperators = explode(',', $request->busOperators);
                $query->whereIn('bus_operators', $busOperators);
            }

            // Parse and apply bus operators filters
            if ($request->from && $request->to) {
                $query->where('from', $request->from)->where('to', $request->to);
            }

            // Paginate the query results
            $data = $query->paginate(4);

            // Return JSON response with paginated bus data
            return response()->json([
                'status' => 'success',
                'message' => 'Bus List View Successful',
                'data' => $data,
            ]);
        } catch (Exception $e) {
            // Handle exceptions
            return response()->json(['status' => 'error', 'message' => 'Something went wrong...'], 200);
        }
    }

    /* -----------------------------------------------------------------------------------------
    @Description: Function for Get Bus Type List
    -------------------------------------------------------------------------------------------- */
    public function getBusType(Request $request)
    {
        try {
            // Authenticate user using JWT token
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'You are not able to log in from this application...'], 200);
            }

            $data = BusType::where('status', 'active')->get();
            // Return JSON response with paginated bus data
            return response()->json([
                'status' => 'success',
                'message' => 'Bus List View Successful',
                'data' => $data,
            ]);
        } catch (Exception $e) {
            // Handle exceptions
            return response()->json(['status' => 'error', 'message' => 'Something went wrong...'], 200);
        }
    }

    /* -----------------------------------------------------------------------------------------
    @Description: Function for Get Bus Operators List
    -------------------------------------------------------------------------------------------- */
    public function getBusOperators(Request $request)
    {
        try {
            // Authenticate user using JWT token
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'You are not able to log in from this application...'], 200);
            }

            $data = BusOperators::where('status', 'active')->get();
            // Return JSON response with paginated bus data
            return response()->json([
                'status' => 'success',
                'message' => 'Bus List View Successful',
                'data' => $data,
            ]);
        } catch (Exception $e) {
            // Handle exceptions
            return response()->json(['status' => 'error', 'message' => 'Something went wrong...'], 200);
        }
    }

    /* -----------------------------------------------------------------------------------------
    @Description: Function for Post Bus Continue List
    -------------------------------------------------------------------------------------------- */
    public function getBusContinue(Request $request)
    {
        try {
            // Authenticate user using JWT token
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'You are not able to log in from this application...'], 200);
            }
            $seatNumbersString = $request->seatNumbers; // Assuming $request->seatNumbers is a string
            $seatNumbersArray = explode(',', $seatNumbersString); // Split the string into an array using ',' as delimiter

            foreach ($seatNumbersArray as $seatNumber) {
                dd($seatNumber);
                $data['seat_numbers'] = $seatNumber;
                $data['user_id'] = $user->id;
                // BusConfirm::Create($data);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Bus List View Successful',
            ]);
            // $data = BusOperators::where('status', 'active')->get();
            // // Return JSON response with paginated bus data
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Bus List View Successful',
            //     'data' => $data,
            // ]);
        } catch (Exception $e) {
            // Handle exceptions
            return response()->json(['status' => 'error', 'message' => 'Something went wrong...'], 200);
        }
    }

    /* -----------------------------------------------------------------------------------------
    @Description: Function for Get Confirm Bus Details List
    -------------------------------------------------------------------------------------------- */
    public function getConfirmBusDetails(Request $request)
    {
        try {
            // Authenticate user using JWT token
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'You are not able to log in from this application...'], 200);
            }
            $busData = Bus::where('id', $request->busId)->with(['busoperators_list', 'bustype_list', 'bus_confirm_details_list' => function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('booking_status', 'pending');
            }])->first();

            $priceSum = BusConfirm::where('bus_id', $request->busId)
                ->where('user_id', $user->id)
                ->where('booking_status', 'pending')
                ->sum('price');

            return response()->json([
                'status' => 'success',
                'message' => 'Bus List View Successful',
                'data' => $busData,
                'priceSum' => $priceSum
            ]);
        } catch (Exception $e) {
            // Handle exceptions
            return response()->json(['status' => 'error', 'message' => 'Something went wrong...'], 200);
        }
    }

    public function processPayment(Request $request)
    {
        dd("processPayment");
    }

    /* -----------------------------------------------------------------------------------------
    @Description: Function for Post Bus Continue List
    -------------------------------------------------------------------------------------------- */
    public function getAllOrderDetails(Request $request)
    {
        try {
            // Authenticate user using JWT token
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'You are not able to log in from this application...'], 200);
            }
            $busData = BusConfirm::with(['bus_seat_list'])->where('user_id',$user->id)->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Bus List View Successful',
                'data' => $busData
            ]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something went wrong...'], 200);
        }
    }
}
