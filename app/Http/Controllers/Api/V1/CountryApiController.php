<?php

namespace App\Http\Controllers\Api\V1;

use App\Api\Transformers\V1\CountryTransformer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;

class CountryApiController extends Controller
{
    protected $countryTransformer;

    public function __construct(CountryTransformer $countryTransformer) {
        $this->countryTransformer                  =   $countryTransformer;
    }


    /**
     * route:: /country-list
     * Method:: GET
     * Get country list
     */
    public function getCountryList(Request $request)
    {
        $data = array();
        try{

            //TODO:: code here
            if ($request->input('app_key') == null
                || $request->input('app_secret') == null
                || $request->input('application') == null)
            {
                throw new \Exception('You have to provide all credentials!');
            }
            if ($request->input('app_key') != config('misc.app.app_key')) {
                throw new \Exception('Invalid app key!');
            }
            if ($request->input('app_secret') != config('misc.app.app_secret')) {
                throw new \Exception('Invalid app secret!');
            }
            if ($request->input('application') != config('misc.app.application')) {
                throw new \Exception('Invalid application request!');
            }
            // $CountryList = Country::all();
            $CountryList = DB::table('countries')
                            ->orderBy('id', 'ASC')
                            ->get();

            $data['CountryList']    =   $CountryList;
            $data['status']         =   'success';
            $data['status_code']    =   '200';
            $data['message']        =   'Data found';

        } catch (\Exception $e) {
            $data['status_code']    = 500;
            $data['status']         = "error";
            $data['message']        = $e->getMessage();
            $logMessage = 'File : '. $e->getFile().' Line Number : '.$e->getLine(). 'Message : '.$e->getMessage();
            // writeToLog($logMessage, 'error');
        } finally {
            return response()->json($data);
        }
    }
}
