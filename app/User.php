<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Activity;

use Carbon\Carbon;

use Image;

class User extends Authenticatable
{
    use Notifiable;

    protected $appends = ['avatar_url', 'level', 'initials'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function activities() {
        return $this->hasMany(Activity::class);
    }

    public function awards() {
        return $this->hasMany(Award::class)->orderBy('created_at', 'ASC')->orderBy('grade', 'DESC');
    }

    public function unseenAwards() {
        return $this->awards()->where('user_notified', false);
    }

    public function awardsFormatted() {
        foreach(['monthly', 'yearly', 'misc'] as $type) {
            $awards[$type] = $this->awards()->where('type', $type)->get();
        }

        return $awards;
    }

    public function scopeTopListMonthly($query, $month = NULL, $year = NULL) {
        $now = Carbon::now();
        
        if(!$month)
            $month = $now->format('m');

        if(!$year)
            $year = $now->format('Y');

        return $query->selectRaw("ifnull(round(sum((select km where deleted_at IS NULL and year(performed_at) = $year AND month(performed_at) = $month)*multiplier)), 0) as score")
            ->leftJoin('activities', 'activities.user_id', 'users.id')
            ->leftJoin('activity_types', 'activity_types.id', 'activities.type_id')
            ->orderBy('score', 'DESC')
            ->orderBy('users.name', 'ASC')
            ->groupBy('users.id');
    }

    public function scopeTopListYearly($query, $year = NULL) {
        $now = Carbon::now();

        if(!$year)
            $year = $now->format('Y');

        return $query->selectRaw("ifnull(round(sum((select km where deleted_at IS NULL and year(performed_at) = $year)*multiplier)), 0) as score")
            ->leftJoin('activities', 'activities.user_id', 'users.id')
            ->leftJoin('activity_types', 'activity_types.id', 'activities.type_id')
            ->orderBy('score', 'DESC')
            ->orderBy('users.name', 'ASC')
            ->groupBy('users.id', 'users.name');
    }

    public function scopeTopListAllTime($query) {
        return $query->selectRaw("ifnull(round(sum((select km where deleted_at IS NULL)*multiplier)), 0) as score")
            ->leftJoin('activities', 'activities.user_id', 'users.id')
            ->leftJoin('activity_types', 'activity_types.id', 'activities.type_id')
            ->orderBy('score', 'DESC')
            ->orderBy('users.name', 'ASC')
            ->groupBy('users.id', 'users.name');
    }

    public function getTotalKmAttribute() {
        return $this->activities()->sum('km');
    }

    public function getInitialsAttribute() {
        $name = explode(' ', $this->name);

        if(count($name) > 1)
            return mb_strtoupper(substr($name[0], 0, 1).substr(end($name), 0, 1));

        return ucfirst(substr($name[0], 0, 2));
    }

    public function getLevelAttribute() {
        $score = User::where('users.id', $this->id)->topListAllTime()->first()->score;
        $levels = config('levels');
        $level = -1;

        foreach($levels as $id => $details) {
            $level++;
            if($score < $details[0]) {

                return (object)[
                    'number' => $level,
                    'name' => $levels[$id-1][1],
                    'score' => $score,
                    'last_cap' => $levels[$id-1][0],
                    'next_cap' => $levels[$id][0],
                ];
            }
        }
    }

    public function getAvatarUrlAttribute() {
        if($avatar = $this->avatar) {
            if(is_file(storage_path("app/public/avatars/$avatar")))
                return asset("storage/avatars/$avatar");
        }

        return NULL;
    }

    public function removeAvatarImage() {

        // current avatar
        $logoPath = storage_path("app/public/avatars/{$this->avatar}");
        if(is_file($logoPath)) {

            // remove image
            unlink($logoPath);

            // removed
            return true;
        }

        // no image removed
        return false;
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

        $path = 'app/public/avatars';

        // Get paths
        $saveTo = storage_path($path . '/' . $hashName);

        // Check if folders exsist
        if(!is_dir($dir = dirname($saveTo))) { mkdir($dir, 0777, true); }

        // Crop and resize image, then save
        Image::make($file)->orientate()->fit(300,300)->save($saveTo);

        // Return hash to save to db later
        return $hashName;
    }
}
