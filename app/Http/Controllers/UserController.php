<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Socialite;
use App\User;
use App\Activity;

use Auth;
use Image;

class UserController extends Controller
{
    /**
     * @deprecated
     * Connect to API
     *
     * @param  string  $service
     * @return Laravel\Socialite\Facades
     */
    public function connectAPI($service) {
    	return Socialite::driver($service)->redirect();
    }

    /**
     * @deprecated
     * Callback method for the Socialite plugin
     *
     * @param  string  $service
     * @return Illuminate\Http\RedirectResponse
     */
    public function callbackAPI($service) {
        $user = Auth::user();
        $id = $service.'_id';
        $token = $service.'_token';

        $user->$id = Socialite::driver($service)->user()->id;
        $user->save();

        return redirect(route('profile', $user->id));
    }

    /**
     * Show the profile view
     *
     * @param  int  $userId
     * @return Illuminate\View\View
     */
    public function profilePage($userId) {
    	$user = User::findOrFail($userId);

    	return view('user.show', [
    		'user' => $user
    	]);
    }

    /**
     * Show the edit view
     *
     * @return Illuminate\View\View
     */
    public function edit() {
        return view('user.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Save the user information
     *
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function save(Request $request) {

        $request->validate([
            'name' => 'required|string',
            'email' => 'email',
        ]);

        $id = $request->input('id');
        $user = User::findOrFail($id);

        if($user->id != Auth::id())
            return redirect()->back();

        $user->name = $request->input('name'); 
        $user->email = $request->input('email'); 

        // Avatar upload
        if($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            // Validate upload
            if(!empty($avatar) && !$avatar->isValid()) {
                return redirect()->back();
            }
            
            // Validate extension
            if(!in_array($avatar->extension(), ['jpg', 'jpeg', 'png'])) {
                return redirect()->back();
            }

            $user->removeAvatarImage();

            $path = $user->storeImage($avatar);
            $user->avatar = $path;

        }
        
        $user->save();

        return redirect(route('profile', Auth::id()));
    }

    /**
     * Returns unseen awards related to user
     *
     * @return App\Award
     */
    public function getUnseenAwards() {
        return Auth::user()->unseenAwards;
    }
}
