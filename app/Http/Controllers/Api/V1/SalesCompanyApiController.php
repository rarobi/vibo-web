<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\SalesCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Api\Transformers\V1\SalesCompanyTransformer;

class SalesCompanyApiController extends Controller
{

    protected $salesCompanyTransformer;

    public function __construct(SalesCompanyTransformer $salesCompanyTransformer) {
        $this->salesCompanyTransformer                  =   $salesCompanyTransformer;
    }

    /**
     * route:: /last-company-id
     * Method:: GET
     * generate new company id based on last company id
     */
    public function lastCompanyId(Request $request)
    {
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

            $prefix = 'SC';
            $companyId = DB::select("SELECT CONCAT('$prefix',LPAD(IFNULL(MAX(SUBSTR(table2.company_id,-6,6) )+1,0),6,'0')) AS company_id FROM (SELECT * FROM sales_companies ) AS table2 WHERE table2.company_id LIKE '$prefix%'")[0]->company_id;

            $data['status']         =   'success';
            $data['status_code']    =   '200';
            $data['companyId']      =   $companyId;

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

    /**
     * route:: /sales-company-store
     * Method:: POST
     * store new sales company
     */
    public function store(Request $request)
    {
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

            if ($request->input('company_id') == null)
            {
                throw new \Exception('Company ID is required!');
            }

            if ($request->input('language') == null)
            {
                throw new \Exception('Language is required!');
            }

            if ($request->input('company_name') == null)
            {
                throw new \Exception('Company name is required!');
            }

            if ($request->input('street_name') == null)
            {
                throw new \Exception('Street name is required!');
            }

            if ($request->input('street_number') == null)
            {
                throw new \Exception('Street number is required!');
            }

            if ($request->input('zip_code') == null)
            {
                throw new \Exception('Zip code is required!');
            }

            if ($request->input('city') == null)
            {
                throw new \Exception('City is required!');
            }

            if ($request->input('country') == null)
            {
                throw new \Exception('Country is required!');
            }

            if ($request->input('contact_person_first_name') == null)
            {
                throw new \Exception('Contact person first name is required!');
            }

            if ($request->input('contact_person_last_name') == null)
            {
                throw new \Exception('Contact person last name is required!');
            }

            if ($request->input('contact_person_email') == null)
            {
                throw new \Exception('Contact person email is required!');
            }

            if ($request->input('contact_person_phone_number') == null)
            {
                throw new \Exception('Contact person phone number is required!');
            }

            if ($request->input('accepted_payment_methods') == null)
            {
                throw new \Exception('Payment methods is required!');
            }

            if ($request->file('company_logo') == null)
            {
                throw new \Exception('Company logo is required!');
            }

            $companyIdCheck = SalesCompany::where('company_id',$request->input('company_id'))->first();
            if($companyIdCheck){
                throw new \Exception($request->input('company_id').' this Company ID already exist!');
            }
            $saleCompany = New SalesCompany();
            $saleCompany->company_id = $request->input('company_id');
            $saleCompany->language = $request->input('language');
            $saleCompany->company_name = $request->input('company_name');
            $saleCompany->street_name = $request->input('street_name');
            $saleCompany->street_number = $request->input('street_number');
            $saleCompany->zip_code = $request->input('zip_code');
            $saleCompany->city = $request->input('city');
            $saleCompany->country = $request->input('country');
            $saleCompany->contact_person_first_name = $request->input('contact_person_first_name');
            $saleCompany->contact_person_last_name = $request->input('contact_person_last_name');
            $saleCompany->contact_person_email = $request->input('contact_person_email');
            $saleCompany->contact_person_phone_number = $request->input('contact_person_phone_number');
            $saleCompany->accepted_payment_methods = $request->input('accepted_payment_methods');

            $prefix = $request->input('company_id').'_';
            $companyLogo = $request->file('company_logo');
            if ($request->hasFile('avatar_location')) {
                $mimeType = $companyLogo->getClientMimeType();
                if(!in_array($mimeType,['image/jpeg','image/jpg','image/png'])){
                    throw new \Exception('Profile image must be png or jpg or jpeg format!');
                }
                $companyLogoFile = trim(sprintf("%s", uniqid($prefix, true))) .'.'.$companyLogo->getClientOriginalExtension();
                $companyLogo->move('uploads/sales_company_logos/', $companyLogoFile);
                $saleCompany->company_logo = $companyLogoFile;
            }

            $saleCompany->status = 1;
            $saleCompany->save();

            $data['sales_company']  = $this->salesCompanyTransformer->transform($saleCompany);
            $data['status']         =   'success';
            $data['status_code']    =   '200';

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
