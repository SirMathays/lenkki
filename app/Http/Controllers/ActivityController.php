<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\User;

use Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class ActivityController extends Controller
{
    public function newActivity() 
    {
    	return view('activity.new');
    }

    public function history($year, $month = NULL) {
        if(!$month)
            $data = User::select('users.id', 'users.name', 'users.avatar')->topListYearly($year)->get();
        else
            $data = User::select('users.id', 'users.name', 'users.avatar')->topListMonthly($month, $year)->get();

        $years = Activity::years()->get();

        return view('activity.history', [
            'data' => $data,
            'year' => $year,
            'years' => $years,
            'month' => $month
        ]);
    }

    public function historyFilter(Request $request) {
        return redirect(route('history', ['month' => $request->input('month'), 'year' => $request->input('year')]));
    }

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

    public function show($actId) 
    {
        $activity = Activity::findOrFail($actId);

        return view('activity.show', [
            'activity' => $activity,
        ]);
    }

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

    public function delete(Request $request) {
        $request->validate([
            'id' => 'required|exists:activities,id',
        ]);

        $id = $request->input('id');
        $activity = Activity::findOrFail($id);

        if(!$activity->userHasRights())
            return redirect()->back();

        $activity->delete();

        return redirect(route('home'));
    }

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

    public function stravaSubscriptionCallback() {
        $client = new Client();
        $response = $client->request('GET', 'https://6d19c8cd.ngrok.io/auth/strava/subscribe/callback');
        return $response->getHeader('hub.challenge');
    }

    public function getActivity($activity) {
        return 'hih';
    }
}
