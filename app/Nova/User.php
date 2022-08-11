<?php

namespace App\Nova;

use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Silvanite\NovaToolPermissions\Role;
use Laravel\Nova\Fields\Boolean;

use App\Nova\Metrics\CountNewUsers;
use App\Nova\Actions\PublishUsers;
use App\Nova\Actions\UnPublishUsers;
use App\Nova\Actions\ImportUsers;
// use App\Nova\Lense\MenUsers;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class User extends Resource
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
    public static $model = \App\Models\User::class;

    public static $priority = 100;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Admin';

    /**
     * The visual style used for the table. Available options are 'tight' and 'default'.
     *
     * @var string
     */
    public static $tableStyle = 'tight';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'name', 'email',
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
            ID::make()->sortable(),

            Gravatar::make()->maxWidth(50),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8'),

            Text::make(__('User Type'), 'type'),

            Select::make('Role','role_id')
                ->options(function(){
                    $authUserRole = auth()->user()->getUserRole();
                    $role = DB::table('roles');
                    if($authUserRole == 'sales-admin'){
                        $role->where('slug','customer-admin');
                    }elseif($authUserRole == 'customer-admin'){
                        $role->where('slug','employee');
                    }
                    return $role->pluck('name','id');
                })->rules(['required'])
                ->fillUsing(function ($request,$model){
                    $model::saved(function($model) use ($request){
                        $userRole = UserRole::firstOrNew(['user_id'=>$model->id]);
                        $userRole->user_id = $model->id;
                        $userRole->role_id = $request->role_id;
                        $userRole->save();
                    });
                })->hideFromIndex()->hideWhenUpdating()->hideFromDetail(),

            HasOne::make('Roles', 'roles', Role::class),

            Boolean::make(__('Status'), 'status')
            ->trueValue('yes')
            ->falseValue('no'),

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
        return [ new CountNewUsers() ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new Filters\UserType,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [
            new Lenses\MenUsers,
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new Actions\ImportUsers,
            new PublishUsers,
            new UnPublishUsers,
            (new DownloadExcel)->withHeadings(),
        ];
    }
}
