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

    protected $appends = [
        'avatar_url',
        'level',
        'initials'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function activities() {
        return $this->hasMany(Activity::class);
    }

    public function xp() {
        return $this->activities()->sum('xp');
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

    public function getTotalKmAttribute() {
        return $this->activities()->sum('km');
    }

    public function totalKmByType($typeId) {
        return $this->activities()->where('type_id', $typeId)->sum('km');
    }

    public function scopeXpTopList($query, $month = NULL, $year = NULL) 
    {
        $whereParts = [];
        
        if($month)
            $whereParts[] = "month(activities.performed_at) = $month";

        if($year)
            $whereParts[] = "year(activities.performed_at) = $year";

        $where = count($whereParts) > 0 ? ' where '.implode(' and ', $whereParts) : NULL;

        $query->selectRaw("ifnull(sum((select activities.xp$where)), 0) as user_xp")
            ->leftJoin('activities', 'activities.user_id', 'users.id')
            ->orderBy('user_xp', 'DESC')
            ->orderBy('users.name', 'ASC')
            ->groupBy('users.id', 'users.name');


        return $query;
    }

    public function scopeActivityTopList($query, $month = NULL, $year = NULL, $activity = NULL) 
    {
        $query->selectRaw('ifnull(sum(activities.km), 0) as user_km')
            ->leftJoin('activities', 'activities.user_id', 'users.id')
            ->orderBy('user_km', 'DESC')
            ->orderBy('users.name', 'ASC')
            ->groupBy('users.id', 'users.name');

        if($month)
            $query->whereRaw("month(activities.performed_at) = $month");

        if($year)
            $query->whereRaw("year(activities.performed_at) = $year");

        if($activity)
            $query->where('type_id', $activity);

        return $query;
    }

    public function getInitialsAttribute() {
        $name = explode(' ', $this->name);

        if(count($name) > 1)
            return mb_strtoupper(substr($name[0], 0, 1).substr(end($name), 0, 1));

        return ucfirst(substr($name[0], 0, 2));
    }

    public function getLevelAttribute() {
        $xp = self::xp();
        $levels = config('levels');
        $level = -1;

        foreach($levels as $id => $details) {
            $level++;
            if($xp < $details[0]) {

                return (object)[
                    'number' => $level,
                    'name' => $levels[$id-1][1],
                    'xp' => $xp,
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
