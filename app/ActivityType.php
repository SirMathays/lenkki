<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
	public $timestamps = false;

    protected $appends = ['logo_url'];

	public function getLogoUrlAttribute() {
        if($logo = $this->logo) {
            if(is_file(storage_path("app/public/activity-types/$logo")))
                return asset("storage/activity-types/$logo");
        }

        return NULL;
    }
}
