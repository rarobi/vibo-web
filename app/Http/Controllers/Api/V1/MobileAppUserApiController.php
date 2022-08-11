<?php

namespace App\Http\Controllers\Api\V1;

use App\Api\Transformers\V1\MobileAppUserTransformer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MobileAppUser;

class MobileAppUserApiController extends Controller
{
    protected $mobileAppUserTransformer;

    // constructor => MobileAppUserTransformer $mobileAppUserTransformer

    public function __construct() {
        // $this->mobileAppUserTransformer                  =   $mobileAppUserTransformer;
    }


    /**
     * route:: /last-company-id
     * Method:: GET
     * generate new company id based on last company id
     */
    public function lastMobileAppUserId(Request $request)
    {
        $data = array();
        try{

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

            $prefix = 'MU';
            // $user_id = DB::select("SELECT CONCAT('$prefix',LPAD(IFNULL(MAX(SUBSTR(table2.user_id,-6,6) )+1,0),6,'0')) AS user_id FROM (SELECT * FROM mobile_app_users ) AS table2 WHERE table2.user_id LIKE '$prefix%'")[0]->user_id;
            $result = DB::table('mobile_app_users')
                    ->where('user_id', 'like', '%' . $prefix . '%')
                    ->select("user_id")
                    ->orderBy('id','desc')
                    ->first();
            
            $data['status']         =   'success';
            $data['status_code']    =   '200';
            $data['user_id']        =   (isset($result->user_id))?$result->user_id:'00000';

        } catch (\Exception $e) {
            $data['status_code']    = 500;
            $data['status']         = "error";
            $data['message']        = $e->getMessage();
            $logMessage = 'File : '. $e->getFile().' Line Number : '.$e->getLine(). 'Message : '.$e->getMessage();
            writeToLog($logMessage, 'error');
        } finally {
            return response()->json($data);
        }
    }
}
