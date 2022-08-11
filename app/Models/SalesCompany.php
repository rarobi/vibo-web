<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use App\Http\Controllers\Api\V1\SalesCompanyApiController;

class SalesCompany extends Model
{
    use HasFactory;

    protected $table = "sales_companies";

    // public const $lastCompanyID = [new \App\Http\Controllers\Api\V1\SalesCompanyApiController::class, 'lastCompanyId'];

    protected $fillable = [
        'id',
        'company_id',
        'language',
        'company_name',
        'street_name',
        'street_number',
        'zip_code',
        'city',
        'country',
        'contact_person_first_name',
        'contact_person_last_name',
        'contact_person_email',
        'contact_person_phone_number',
        'accepted_payment_methods',
        'company_logo',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
