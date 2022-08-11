<?php

namespace App\Http\Controllers\Api\V1;

use App\Api\Transformers\V1\LanguageTransformer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;

class LanguageApiController extends Controller
{
    protected $languageTransformer;

    public function __construct(LanguageTransformer $languageTransformer) {
        $this->languageTransformer                  =   $languageTransformer;
    }
    
    /**
     * route:: /language-list
     * Method:: GET
     * Get language list
     */
    public function getLanguageList(Request $request)
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
            // $LanguageList = Language::all();
            $LanguageList = DB::table('languages')
                            ->select('id', 'language_code', 'language_name')
                            ->orderBy('id', 'ASC')
                            ->get();
            
            $data['LanguageList']    =   $LanguageList;
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
