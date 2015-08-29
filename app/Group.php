<?php

namespace Zento;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * Users relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('Zento\User');
    }

    /**
     * Returns an array that contains the group id as key and the group name as value.
     *
     * @return array
     */
    public static function groupsArray()
    {
        $groups = Group::all();
        $groupsArray = array();
        foreach($groups as $group) {
            $groupsArray[$group->id] = $group->name;
        }
        return $groupsArray;
    }
}
