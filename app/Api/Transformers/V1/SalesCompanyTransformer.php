<?php

namespace App\Api\Transformers\V1;

use App\Api\Transformers\Transformer;

class SalesCompanyTransformer extends Transformer
{

    /**
     * SalesCompanyTransformer constructor.
     */
    public function __construct()
    {
        //
    }

    public function transform($data) {

        return [
            'id'                => $data->id,
            'company_id'        => $data->company_id,
            'language'          => $data->language,
            'company_name'      => $data->company_name,
            'street_name'       => $data->street_name,
            'street_number'     => $data->street_number,
            'zip_code'          => $data->zip_code,
            'city'              => $data->city,
            'country'           => $data->country,
            'contact_person_first_name'     => $data->contact_person_first_name,
            'contact_person_last_name'      => $data->contact_person_last_name,
            'contact_person_email'          => $data->contact_person_email,
            'contact_person_phone_number'   => $data->contact_person_phone_number,
            'accepted_payment_methods'      => $data->accepted_payment_methods,
            'company_logo'                  => $data->company_logo,
            'status'                        => $data->status

        ];
    }

}
