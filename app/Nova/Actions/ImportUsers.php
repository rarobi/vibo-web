<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
// use Anaseqal\NovaImport\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Fields\File;

use Laravel\Nova\Actions\Action;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
// use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class ImportUsers extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $standalone = true;

    /**
     * Indicates if this action is only available on the resource detail view.
     *
     * @var bool
     */
    public $onlyOnIndex = true;

    /**
     * Get the displayable name of the action.
     *
     * @return string
     */
    public function name() {
        return __('Import Users');
    }

    /**
     * @return string
     */
    public function uriKey() :string
    {
        return 'import-users';
    }

    /**
     * Perform the action.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @return mixed
     */
    public function handle(ActionFields $fields)
    {
        // Excel::import(new UsersImport, $fields->file);

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\UsersImport, $fields->file);        

        return Action::message('It worked!');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            \Laravel\Nova\Fields\File::make('File')
                ->rules('required'),
        ];
    }
}