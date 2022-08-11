<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use KirschbaumDevelopment\NovaMail\Traits\Mailable;

class MobileAppUser extends Model
{
    use HasFactory, Mailable;

    /**
     * Get the name of the email field for the model.
     *
     * @return string
     */
    public function getEmailField(): string
    {
        return 'email';
    }

    protected $table = "mobile_app_users";
    protected $fillable = [
        'user_id',
        'language',
        'employee_number',
        'first_name',
        'last_name',
        'user_medium',
        'email',
        'cell_phone_number',
    ];
}
