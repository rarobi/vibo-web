<?php

namespace App\Nova;

use App\Models\Country;
use App\Models\Language;
use App\Models\PaymentMethod;
use Davidpiesse\NovaToggle\Toggle;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Panel;

use App\Nova\Metrics\TotalSalesCompanies;
use App\Nova\Metrics\NewSalesCompanies;
use App\Nova\Metrics\CompaniesStatus;

// use App\Http\Controllers\Api\V1\SalesCompanyApiController;

class SalesCompany extends Resource
{
    protected $lastCompanyID;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Admin';

    /**
     * Constructor load when class in load
     *
     * @var string
     */
    // public function __construct()
    // {
    //     // $this->getLastCompanyID();
    // }


    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\SalesCompany::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'company_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'company_name', 'company_id'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable()->hideFromIndex(),
            Image::make(__('Company Logo'),'company_logo')
                ->disk('public')
                ->path('salesCompany')
                ->required()
                ->hideFromIndex(),

            Text::make(__('Company ID'), 'company_id')
            ->sortable()
            ->rules('required'),

            Text::make(__('Company Name'), 'company_name')
                ->rules('required', 'max:255'),

            Select::make(__('Language'), 'language')
                ->options(Language::pluck('language_name', 'language_code'))
                ->rules('required'),

            new Panel('Company Address', $this->companyAddressFields()),

            new Panel('Contact Person Information', $this->contactPersonFields()),

            new Panel('Optional Features', $this->optionalFeaturesFields()),

            new Panel('Accepted means of Payment', $this->paymentMethodsFields()),

            Boolean::make(__('Status'), 'status')
                ->hideFromDetail()
                ->hideWhenCreating()
                ->hideWhenUpdating()
                ->hideFromIndex()
                ->default(1),
        ];
    }


    /**
     * Get the last company ID thorugh API.
     *
     * @return array
     */
    // public function getLastCompanyID()
    // {
    //     $fields = [
    //         "app_key" => '2022BUFWICFGGNILMSLIYUVH2022',
    //         "app_secret" => '20220307OMMJPOKHYOMJSPOGZNAGMPAEZDMLNVXGMTVE20220307',
    //         "application" => 'VEBO',
    //     ];

    //     $req_url = "http://127.0.0.1:8000/api/v1/last-company-id";

	// 	$ch=curl_init();
	// 	curl_setopt($ch, CURLOPT_VERBOSE, 1);
	// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	// 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// 	curl_setopt($ch, CURLOPT_POST, 1);
	// 	curl_setopt($ch,CURLOPT_URL,$req_url);
	// 	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    //     $headers = array();
    //     $headers[] = "Content-Type: application/json";
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	// 	$response = curl_exec($ch);
	// 	$err = curl_errno($ch);

    //     echo $response;
    // }


    /**
     * Get the address fields for the resource.
     *
     * @return array
     */
    protected function companyAddressFields()
    {
        return [
            Text::make(__('Street Name'), 'street_name')
                ->rules('required')
                ->hideFromIndex(),
            Text::make(__('Street Number'), 'street_number')
                ->rules('required')
                ->hideFromIndex(),
            Text::make(__('Zip Code'), 'zip_code')
                ->rules('required')
                ->hideFromIndex(),
            Text::make(__('City'), 'city')
                ->rules('required')
                ->hideFromIndex(),
            Select::make(__('Country'), 'country')
                ->searchable()
                ->rules('required')
                ->options(Country::pluck('country_name', 'country_code'))
                ->displayUsingLabels()->hideFromIndex(),
        ];
    }
    protected function contactPersonFields()
    {
        return [
            Text::make(__('First Name'), 'contact_person_first_name')
                ->rules('required')
                ->hideFromIndex(),
            Text::make(__('Last Name'), 'contact_person_last_name')
                ->rules('required')
                ->hideFromIndex(),
            Text::make(__('Email'), 'contact_person_email')
                ->rules('required')
                ->hideFromIndex(),
            Text::make(__('Phone Number'), 'contact_person_phone_number')
                ->rules('required')
                ->hideFromIndex(),
        ];
    }

    protected function optionalFeaturesFields()
    {
        return [
            Toggle::make(__('API for Lock Connection'), 'is_api_lock_connection')
                ->trueValue(1)
                ->falseValue(0)
                ->width(65)
                ->height(20)
                ->showLabels()
                ->trueLabel('Active')
                ->falseLabel('Inactive'),

            Toggle::make(__('Push Notification'), 'is_push_notification')
                ->trueValue(1)
                ->falseValue(0)
                ->width(65)
                ->height(20)
                ->showLabels()
                ->trueLabel('Active')
                ->falseLabel('Inactive'),

            Toggle::make(__('Feedback Option'), 'is_feedback_option')
                ->trueValue(1)
                ->falseValue(0)
                ->width(65)
                ->height(20)
                ->showLabels()
                ->trueLabel('Active')
                ->falseLabel('Inactive'),
        ];
    }

    protected function paymentMethodsFields()
    {
        return [
            Select::make(__('Accepted Payment Method'), 'accepted_payment_methods')
                ->searchable()
                ->rules('required')
                ->options(PaymentMethod::pluck('name', 'id'))
                ->displayUsingLabels()->hideFromIndex(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [ 
            new TotalSalesCompanies(), 
            new NewSalesCompanies(), 
            new CompaniesStatus() 
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
