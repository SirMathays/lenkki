<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ActivityType;
use App\Activity;
use App\User;

use Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ActivityController extends Controller
{
    /**
     * Show new Activity form
     * @author Matti
     *
     * @return Illuminate\View\View
     */
    public function newActivity() 
    {
    	return view('activity.new');
    }

    /**
     * Show the activity top list dashboard.
     * @author Matti
     *
     * @param  int  $typeId
     * @return Illuminate\Http\Response
     */
    public function activityTopList($typeId)
    {
        $type = ActivityType::findOrFail($typeId);

        return view('activity.top-list', [
            'type' => $type,
            'typeId' => $type->id,
        ]);
    }

    /**
     * Show activity history page
     * @author Matti
     *
     * @param  string  $year
     * @param  string  $month         NULL
     * @param  string  $activityType  NULL
     * @return Illuminate\View\View
     */
    public function history($year, $month = NULL, $activityType = NULL) {
        
        $data = User::select('users.id', 'users.name');
        $type = null;

        if($activityType) {
            $type = ActivityType::findOrFail($activityType);
            $data->activityTopList($type->id, $month, $year);
        }
        else {
            $data->xpTopList($month, $year);
        }

        $years = Activity::years()->get();
        $activityTypes = ActivityType::pluck('name', 'id')->toArray();

        return view('activity.history', [
            'data' => $data->get(),
            'years' => $years,
            'year' => $year,
            'month' => $month,
            'activity' => optional($type)->id,
            'activityTypes' => $activityTypes,
        ]);
    }

    /**
     * Redirect user to the correct activity history URL
     * @author Matti
     *
     * @param  Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function historyFilter(Request $request) {
        return redirect(route('history', [
            'year' => $request->input('year'),
            'month' => $request->input('month'), 
            'activityType' => $request->input('activity')
        ]));
    }

    /**
     * Show activity edit page
     * @author Matti
     *
     * @param  int  $id
     * @return Illuminate\View\View
     */
    public function edit($actId) 
    {
        $activity = Activity::findOrFail($actId);

        // check for edit rights
        if($activity->user_id != Auth::id())
            return redirect()->back();

        $activity->performed = $activity->performed_at->format('Y-m-d');

        return view('activity.new', [
            'activity' => $activity,
        ]);
    }

    /**
     * Show activity
     * @author Matti
     *
     * @param  int  $id
     * @return Illuminate\View\View
     */
    public function show($actId) 
    {
        $activity = Activity::findOrFail($actId);

        return view('activity.show', [
            'activity' => $activity,
        ]);
    }

    /**
     * Get activity
     * @author Matti
     *
     * @param  int  $id
     * @return Illuminate\View\View
     */
    public function get($actId)
    {
        $data = Activity::findOrFail($actId);

        return $data->toArray();
    }

    /**
     * Validate and save activity
     * @author Matti
     *
     * @param  Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function save(Request $request) 
    {
    	$request->validate([
            'performed_at' => 'date',
    		'km' => 'required|numeric',
    		'duration' => 'required|integer',
    		'type_id' => 'exists:activity_types,id',
    	]);

        $data = $request->input();

        if(!empty($data['activity_id'])) {
            $activity = Activity::findOrFail($data['activity_id']);
            if(!$activity->userHasRights()) {
                return redirect()->back();
            }
        } else {
            $activity = new Activity;
        }

        $activity->user_id = Auth::id();
        $activity->km = $data['km'];
        $activity->duration = $data['duration'];
        $activity->type_id = $data['type_id'];
        $activity->performed_at = $data['performed_at'];

        // Image upload
        if($request->hasFile('image')) {
            $image = $request->file('image');

            // Validate upload
            if(!empty($image) && !$image->isValid()) {
                return redirect()->back();
            }
            
            // Validate extension
            if(!in_array($image->extension(), ['jpg', 'jpeg', 'png'])) {
                return redirect()->back();
            }

            $activity->removeImage();

            $path = $activity->storeImage($image);
            $activity->image = $path;

        }

        $activity->save();

        return redirect(route('home'));
    }

    /**
     * Delete activity
     * @author Matti
     *
     * @param  Illuminate\Http\Request  $request
     * @return Illuminate\Http\Response
     */
    public function delete($id) {
        $activity = Activity::findOrFail($id);

        if(!$activity->userHasRights())
            return redirect()->back();

        $activity->delete();

        return redirect(route('home'));
    }

    /**
     * Sends subscription plea to Strava API
     * @author Matti
     * @todo   Actually figure out how to use this fukken thing
     *
     * @return void
     */
    public function stravaSubscription() {
        $client = new Client(); //GuzzleHttp\Client
        $result = $client->post('https://api.strava.com/api/v3/push_subscriptions', [
            'form_params' => [
                'client_id' => env('STRAVA_KEY'),
                'client_secret' => env('STRAVA_SECRET'),
                'callback_url' => 'https://6d19c8cd.ngrok.io/auth/strava/subscribe/callback',
                // 'callback_url' => action('ActivityController@stravaSubscriptionCallback'),
                'verify_token' => 'STRAVA',
            ]
        ]);

    }

    /**
     * Receives stuff from Strava API
     * @author Matti
     * @todo   Actually figure out how to use this fukken thing
     *
     * @return void
     */
    public function stravaSubscriptionCallback() {
        $client = new Client();
        $response = $client->request('GET', 'https://6d19c8cd.ngrok.io/auth/strava/subscribe/callback');
        return $response->getHeader('hub.challenge');
    }

    /**
     * I don't even know
     * @author Matti
     * @todo   Actually figure out how to use this fukken thing
     *
     * @return void
     */
    public function getActivity($activity) {
        return 'hih';
    }
}
