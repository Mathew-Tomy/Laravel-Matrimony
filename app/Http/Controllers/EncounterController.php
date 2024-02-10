<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Notifications\DbStoreNotification;
use Notification;
use App\Utility\EmailUtility;
use App\Utility\SmsUtility;
use App\Http\Controllers\Controller;
use App\Models\Likes;
use App\Models\Encounter;
use App\Models\Member;
use App\Models\ChatThread;
use App\User;
use App\Models\AllUsers;
use App\Models\ProfileView;
use App\Models\IgnoredUser;
use Hash;
use Artisan;
use Auth;
use DB;

use Kutia\Larafirebase\Facades\Larafirebase;

use App\Utility\UserEncounterUtility;
class EncounterController extends Controller
{
    public function show_encounter()
    {
        if (Auth::user()->user_type == 'member') {
            $user = auth()->user();
    
            // Get all encounter users, excluding skipped users
            $skipped_users = session()->get('skipped_users', []);
            $encounter_users = User::where('id', '<>', $user->id)
                ->where('blocked', 0)
                ->where('deactivated', 0)
                ->where('approved', 1)
                ->where('user_type', 'member')
                ->whereNotIn('id', function($query) use ($user) {
                    $query->select('liked_user_id')
                        ->from('likes')
                        ->where('user_id', $user->id);
                })
                ->whereNotIn('id', function($query) use ($user, $skipped_users) {
                    $query->select('encounter_user_id')
                        ->from('encounters')
                        ->whereIn('skip_user_id', $skipped_users)
                        ->where('encounter_user_id', $user->id);
                })
                ->orderBy('id', 'desc')
                ->paginate(1);
    
            return view('frontend.member.encounter', compact('encounter_users'));
        } else {
            abort(404);
        }
    }
    
    
    public function likeUser(Request $request, $id)
{
    $user = auth()->user();

    // Check if user exists and is not the current user
    $liked_user = User::where('id', $id)
        ->where('id', '<>', $user->id)
        ->where('blocked', 0)
        ->where('deactivated', 0)
        ->where('approved', 1)
        ->where('user_type', 'member')
        ->first();

    if ($liked_user) {
        // Add like to likes table
        Like::create([
            'user_id' => $user->id,
            'liked_user_id' => $liked_user->id,
        ]);
    }

    // Redirect back to encounter page
    return redirect()->route('show_encounter');
}

public function skip_user(Request $request, $id)
{
    $user = auth()->user();

    // Check if user exists and is not the current user
    $skipped_user = User::where('id', $id)
        ->where('id', '<>', $user->id)
        ->where('blocked', 0)
        ->where('deactivated', 0)
        ->where('approved', 1)
        ->where('user_type', 'member')
        ->first();

        $existingView = Encounter::where('encounter_user_id ', Auth::id())
        ->where('skip_user_id', $id)
        ->first();

    if (!$existingView) {
// If a record doesn't already exist, insert a new one
     $encounter = new Encounter([
     'encounter_user_id ' => Auth::id(),
     'skip_user_id' => $id,
      ]);

    $encounter->save();
    try {

        DB::table('user')->where('id', $id)->update($userdata);
    }catch(\Exception $e){
        //Do something when query fails. 
    }
    }
    
        // Redirect back to encounter page
        return redirect()->route('dashboard');
    }

// public function skipEncounterUser($toUserUid)
// {
//     $processReaction = $this->UserEncounterUtility->processSkipEncounterUser($toUserUid);

//     //check reaction code equal to 1
//     return $this->responseAction(
//         $this->processResponse($processReaction, [], [], true)
//     );
// }

}
