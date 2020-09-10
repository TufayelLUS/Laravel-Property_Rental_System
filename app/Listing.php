<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    //
    protected $fillable = ['user_id','title', 'cat', 'property_price', 'rooms', 'bedrooms', 'bathrooms', 'attached_bathrooms', 'common_bathrooms', 'kitchens', 'balcony', 'gas', 'electricity', 'advance', 'furniture', 'swimming', 'playground', 'photo', 'applicant_type', 'property_location', 'description', 'phone_shared', 'is_booked', 'booked_by', 'booking_expires', 'expiry_unit'];
}
