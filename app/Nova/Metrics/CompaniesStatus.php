<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

class CompaniesStatus extends Partition
{
    /**
     * Indicates whether the metric should be refreshed when actions run.
     *
     * @var bool
     */
    public $refreshWhenActionRuns = true;

    /**
     * Get the displayable name of the metric
     *
     * @return string
     */
    public function name()
    {
        return __('Companies Status');
    }

    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, \App\Models\SalesCompany::class, 'status')
                    ->label(function ($value) {
                        switch ($value) {
                            case 1:
                                return 'Active';
                            case null:
                                return 'In-Active';
                            default:
                                return ucfirst($value);
                        }
                    });
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'companies-status';
    }
}
