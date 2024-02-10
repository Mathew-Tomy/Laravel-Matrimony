<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Notifications\DbStoreNotification;
use Notification;
use App\Utility\EmailUtility;
use App\Utility\SmsUtility;
use App\Http\Controllers\Controller;
use App\Models\UsersLikes;
use App\Models\UsersDisLikes;
use App\Models\UsersEncounters;
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
class UsersEncountersController extends Controller
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
                        ->from('user_likes')
                        ->where('user_id', $user->id);
                })
                ->whereNotIn('id', function($query) use ($user) {
                    $query->select('skip_user_id')
                        ->from('users_encounters')
                        ->where('encounter_user_id', $user->id);
                })
                ->whereNotIn('id', function($query) use ($user) {
                    $query->select('dislike_user_id')
                        ->from('user_dislikes')
                        ->where('user_id', $user->id);
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
            $user_likes = new UsersLikes([
                'user_id' => $user->id,
                'liked_user_id' => $liked_user->id,
            ]);
            $user_likes->save();
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
    
        if ($skipped_user) {
            // Add skip to users_encounters table
            $encounter = new UsersEncounters([
                'encounter_user_id' => $user->id,
                'skip_user_id' => $skipped_user->id,
            ]);
            $encounter->save();
    
            // Add skipped user ID to session variable
            session()->push('skipped_users', $skipped_user->id);
        }
    
        // Redirect back to encounter page
        // return redirect()->route('show_encounter');
        return redirect()->route('show_encounter');
    }
    
    public function dislikeUser(Request $request, $id)

    
    {
        $user = auth()->user();
    
        // Check if user exists and is not the current user
        $disliked_user = User::where('id', $id)
            ->where('id', '<>', $user->id)
            ->where('blocked', 0)
            ->where('deactivated', 0)
            ->where('approved', 1)
            ->where('user_type', 'member')
            ->first();
    
        if ($disliked_user) {
            // Add like to likes table
            $user_dislikes = new UsersDisLikes([
                'user_id' => $user->id,
                'dislike_user_id' => $disliked_user->id,
            ]);
            $user_dislikes->save();
        }
    
        // Redirect back to encounter page
        return redirect()->route('show_encounter');
    }

    public function View_like_User()
    {
       
    $like_users =UsersLikes::where('user_id', Auth::user()->id)
    ->with('likedUser')
    ->latest()
    ->paginate(10);



return view('frontend.member.users_likes', compact('like_users'));

    }
    
    public function View_dislike_User()
    {
       
        $dislike_users =UsersDisLikes::where('user_id', Auth::user()->id)
        ->with('dislikeUser')
        ->latest()
        ->paginate(10);
    
    
    
    return view('frontend.member.users_dislikes', compact('dislike_users'));
    
        }

}
