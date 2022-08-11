<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Support\Facades\DB;

class GetLastMobileAppUserID extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $prefix = 'SC';
        $companyId = DB::select("SELECT CONCAT('$prefix',LPAD(IFNULL(MAX(SUBSTR(table2.company_id,-6,6) )+1,0),6,'0')) AS company_id FROM (SELECT * FROM sales_companies ) AS table2 WHERE table2.company_id LIKE '$prefix%'")[0]->company_id;
        return $companyId;
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
