<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'name',
        'zip',
        'city',
        'street',
        'housenr',
        'country',
        'created_at',
        'updated_at'
    ];

    public function users()
    {
        return $this->hasMany('Zento\User');
    }

    public static function findOrCreate(array $location)
    {
        // Check if necessary keys exist, otherwise fail with 403
        if(!array_key_exists('zip', $location) &&
            !array_key_exists('city', $location) &&
            !array_key_exists('street', $location) &&
            !array_key_exists('housenr', $location) &&
            !array_key_exists('country', $location)) {
            abort(403, 'Unauthorized action.');
        }

        // TODO: extract this block to the Location model
        // check if given location exists; use or create otherwise.
        $loc = Location::where('street', '=', $location['street'])
            ->where('housenr', '=', $location['housenr'])
            ->where('zip', '=', $location['zip'])
            ->where('city', '=', $location['city'])
            ->where('country', '=', $location['country']);
        if(!$loc->exists()) {
            $loc = Location::create([
                'street' => $location['street'],
                'housenr' => $location['housenr'],
                'zip' => $location['zip'],
                'city' => $location['city'],
                'country' => $location['country']
            ]);
        } else {
            $loc = $loc->first();
        }
        return $loc;
    }
}