<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\DbStoreNotification;
use Notification;
use App\Utility\EmailUtility;
use App\Utility\SmsUtility;
use App\Http\Controllers\Controller;
use App\Models\ExpressInterest;
use App\Models\ProfileView;
use App\Models\Member;
use App\Models\ChatThread;
use App\User;
use Auth;
use DB;
use Kutia\Larafirebase\Facades\Larafirebase;

class ProfileViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile_visitors()
    {
        $visitors = ProfileView::with('user')
        ->where('user_id', Auth::user()->id)
        ->latest()
        ->paginate(10);
return view('frontend.member.profile_visitors', compact('visitors'));
    }

    public function viewed_by_me()
    {
       
    $visitors = ProfileView::where('visitor_id', Auth::user()->id)
    ->with('viewer')
    ->latest()
    ->paginate(10);
return view('frontend.member.profile_viewed_me', compact('visitors'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
}
