<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\ActivityType;
use App\User;

use Auth;

use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Return a xp top list
     * @author Matti
     *
     * @param  int     $limit     0
     * @param  int     $year      NULL
     * @param  int     $month     NULL
     * @return array
     */
    public function xpTopList($limit = 0, $year = NULL, $month = NULL) 
    {
        $data = User::select('users.id', 'users.name', 'users.avatar')->xpTopList($month, $year);

        if($limit)
            $data->limit($limit);

        $data = $data->get();
        
        foreach($data as &$row) {
            $row->comparison = compare($row->user_score, $data[0]->user_score).'%';
        }

        return response(['users' => $data->toArray()], 200);
    }

    public function activityTopList($activityType, $limit = 0, $year = NULL, $month = NULL)
    {
        $data = User::select('users.id', 'users.name', 'users.avatar')->activityTopList($activityType, $month, $year);

        if($limit)
            $data->limit($limit);

        $data = $data->get();
        
        foreach($data as &$row) {
            $row->comparison = compare($row->user_score, $data[0]->user_score).'%';
        }

        return response(['activity' => ActivityType::find($activityType), 'users' => $data->toArray()], 200);
    }

    /**
     * Return 10 most recent activities
     * @author Matti
     *
     * @param  int  $typeId
     * @return object
     */
    public function recentActivities($typeId = NULL) 
    {
        $data = Activity::orderBy('performed_at', 'DESC')->orderBy('updated_at', 'DESC')->limit(10);

        if($typeId) {
            $type = ActivityType::find($typeId);
            $data->where('type_id', $type->id);
        }

        return $data->paginate(10);
    }

    /**
     * Return activities related to user
     * @author Matti
     *
     * @param  int  $userId
     * @return object
     */
    public function userActivities($userId) 
    {
        $data = Activity::where('user_id', $userId)->orderBy('performed_at', 'DESC')->orderBy('updated_at', 'DESC')->paginate(10);

        return $data;
    }

    /**
     * Show the application dashboard.
     * @author Matti
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $now = Carbon::now();
        
        return view('home', [
            'year' => $now->year,
            'month' => $now->month
        ]);
    }
}
