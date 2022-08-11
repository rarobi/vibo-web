<?php

namespace App\Api\Transformers\V1;

use App\Api\Transformers\Transformer;

class CountryTransformer extends Transformer
{

    /**
     * CountryTransformer constructor.
     */
    public function __construct()
    {
        //
    }

    public function transform($countryData) {

        return [
            'field1'              => $countryData->id,
        ];
    }

}
