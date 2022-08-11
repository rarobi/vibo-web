<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Nova\Actions\EmailSendOnMobileUserCreate;
use App\Nova\Actions\GetLastMobileAppUserID;
use Bissolli\NovaPhoneField\PhoneNumber;
use App\Http\Controllers\Api\V1\MobileAppUserApiController;

use KirschbaumDevelopment\NovaMail\Actions\SendMail;
use Laravel\Nova\Fields\HasMany;
use KirschbaumDevelopment\NovaMail\Nova\NovaSentMail;

use Veboweb\StringLimit\StringLimit;

class MobileUser extends Resource
{
    /**
     * to display User resource turn {$displayInNavigation} into true instead of false
     *
     * @var string
     */
    public static $displayInNavigation = false;
    
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\MobileAppUser::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get last mobile app user's user_id
     *
     * @return string
     */

    public function getLastUserID()
    {
        $request = new \Illuminate\Http\Request();

        $request->replace([
            'app_key' => config('misc.app.app_key'),
            'app_secret' => config('misc.app.app_secret'),
            'application' => config('misc.app.application'),
        ]);

        $mobile_app_user = new MobileAppUserApiController();
        $response = $mobile_app_user->lastMobileAppUserId($request);
        $result = $response->getData();

        $user_id = str_replace("MU", "", $result->user_id);
        
        $lastMobileAppUserID = "MU".str_pad(((int) $user_id + 1), 5, "0", STR_PAD_LEFT);
        
        return $lastMobileAppUserID;

    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Text::make(__('User ID'), 'user_id')
            ->default($this->getLastUserID())
            ->readonly()
            ->rules('required'),

            Hidden::make(__('User ID'), 'user_id')
            ->default($this->getLastUserID()),

            Text::make(__('Employee Number'), 'employee_number')
            ->rules('required'),
            Select::make(__('Language'), 'language')
            ->options(\App\Models\Language::pluck('language_name', 'language_code'))
            ->rules('required'),
            Text::make(__('First Name'), 'first_name')
            ->rules('required'),
            Text::make(__('Last Name'), 'last_name')
            ->rules('required'),
            Select::make(__('User Medium'), 'user_medium')
            ->options([
                '1' => 'Email',
                '2' => 'Cell Phone',
            ])
            ->rules('required'),
            Text::make(__('E-Mail Adresse'), 'email')
            ->rules('required'),
            PhoneNumber::make(__('Cell Phone Number'), 'cell_phone_number')
            ->rules('required'),
            HasMany::make('Sent Mail', 'mails', NovaSentMail::class),
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
        return [];
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
        return [ new GetLastMobileAppUserID];
    }
}
