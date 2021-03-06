<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Events\ActivitySaving;

use Auth;
use Image;

class Activity extends Model
{
    use SoftDeletes;

    protected $dispatchesEvents = [
        'saving' => ActivitySaving::class,
    ];
    
    protected $appends = [
        'image_url',
        'user_has_rights',
        'activity_name',
        'performed_at_formatted',
    ];

	/**
     * The attributes that are dates.
     *
     * @var array
     */
	protected $dates = [
		'performed_at'
	];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'km', 
        'type_id', 
        'duration', 
        'performed_at', 
        'user_id'
    ];

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function activityType() {
        return $this->belongsTo(ActivityType::class, 'type_id');
    }

    public static function season() {
        foreach(config('seasons') as $season => $months) { 
            $current = in_array(7, $months) ? $season : NULL;
            break;
        }

        return $current;
    }

    public function userHasRights() {
        return $this->user->id == Auth::id() ? true : false;
    }

    public function getUserHasRightsAttribute() {   
        return $this->user->id == Auth::id() ? true : false;
    }

    public function getPerformedAtFormattedAttribute() {
        return $this->performed_at->format('j.n.Y');
    }

    public function getActivityNameAttribute() {
        return $this->activityType->name;
    }

    public function getImageUrlAttribute() {
        if($image = $this->image) {
            if(is_file(storage_path("app/public/activities/$image")))
                return asset("storage/activities/$image");
        }

        return NULL;
    }

    public function removeImage() {

        // current image
        $imagePath = storage_path("app/public/activities/{$this->image}");
        if(is_file($imagePath)) {

            // remove image
            unlink($imagePath);

            // removed
            return true;
        }

        // no image removed
        return false;
    }

    public function scopeMonths($query) {
        $query->selectRaw('month(performed_at) as month')->distinct();
    }

    public function scopeYears($query) {
        $query->selectRaw('year(performed_at) as year')->distinct();
    }

    /**
     * Save logo and return hash
     */
    public static function storeImage($file) {

        // Validate
        if(empty($file)) {
            return null;
        }

        // Use hash for image name
        $hashName = $file->hashName();

        $path = 'app/public/activities';

        // Get paths
        $saveTo = storage_path($path . '/' . $hashName);

        // Check if folders exsist
        if(!is_dir($dir = dirname($saveTo))) { mkdir($dir, 0777, true); }

        // Crop and resize image, then save
        Image::make($file)->orientate()->fit(500,240)->save($saveTo);

        // Return hash to save to db later
        return $hashName;
    }
}
