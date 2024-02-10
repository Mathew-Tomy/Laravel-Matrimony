<?php
namespace App\Utility;
use Notification;
use App\Notifications\EmailNotification;
use App\Models\Package;
use App\User;
use App\Models\Member;
use Auth;
use Carbon\Carbon;
use App\Upload;

class EmailUtility
{
    public static function account_oppening_email($user_id = '', $pass = '')
    {
        $user           = User::where('id',$user_id)->first();
        $subject        = get_email_template('account_oppening_email','subject');
        $account_type   = $user->membership == 1 ? 'Free' : 'Premium';

        // $email_body     = get_email_template('account_oppening_email','body');
        // $email_body     = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        // // $email_body     = str_replace('[[sitename]]', get_setting('website_name'), $email_body);
        // $email_body     = str_replace('[[account_type]]', $account_type, $email_body);
        // $email_body     = str_replace('[[email]]', $user->email, $email_body);
        // $email_body     = str_replace('[[password]]', $pass, $email_body);
        // $email_body     = str_replace('[[url]]', env('APP_URL'), $email_body);
        // $email_body     = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);
        $email_body='						
        <html> 
        <head> 
            <title></title> 
        </head> 
        <body>
        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
         
            <tbody><tr>
            <td valign="top" style="font-size:0"><img src="https://sarahtobiasmatrimony.com/images/Sarah&Tobias.png" alt="" width="600" height="360" class="CToWUd" data-bit="iit"></td>
            </tr>
            <tr>
            
            <tr>
            <td valign="top" style="border-left:1px solid #ef4d74;border-right:1px solid #ef4d74">
            <table width="598" border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
            <td style="background:#ef4d74;height:45px;padding:0 20px;font:16px Arial;color:#fff;line-height:45px;">Hi '.$user->first_name.' '.$user->last_name.'</td>
            </tr>
            <tr>
            <td>
            <table width="560" border="0" align="center" cellpadding="0" cellspacing="0"> 
         <tbody><tr>
         <td>&nbsp;</td>
         </tr>
         <tr>
         <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">Thank you for choosing Sarah Tobias Matrimony.The worlds No:1 Christian Matrimonial service provider. You have chosen the most excellent way to find your dream partner.</td>
         </tr>
         <tr>
         <td>&nbsp;</td>
         </tr>
         <tr>
         <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">As per verification,Your account type is : '.$account_type.'</td>
         </tr>
         <tr>
         <td>&nbsp;</td>
         </tr>
         <tr>
         <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">
         <strong> You will be able to log in from here   : '. env('APP_URL') .'  </strong></td>
         </tr>
         <tr>
         <td>&nbsp;</td>
         </tr>
         <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">
         <strong> Please contact the administration team if you have any further questions. Best wishes. </strong></td>
         </tr>
         <tr>
         <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">&nbsp;</td>
         </tr>
         <tr>
         <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">Regards,<br>
         <strong>Team Sarah Tobias Matrimony</strong></td>
         </tr>
            <tr>
            <td>&nbsp;</td>
            </tr>
            </tbody></table> 
            </td>
            </tr>
            </tbody></table>
            
            </td>
            </tr>
            <tr>
            <td valign="top" style="font-size:0"><img src="https://sarahtobiasmatrimony.com/images/Myproject-2.png" alt="" width="600" height="60" class="CToWUd" data-bit="iit"></td>
            </tr>
           </tbody></table>
           </body>
        
           </html>
        '; 

        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function account_opening_email_to_admin($user = '', $admin = '')
    {
        $subject = get_email_template('account_opening_email_to_admin','subject');
        $email_body = get_email_template('account_opening_email_to_admin','body');
        $email_body = str_replace('[[member_name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[email]]', $user->email, $email_body);
        $email_body = str_replace('[[profile_link]]', env('APP_URL').'/admin/members/'.$user->id, $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);

        try{
            Notification::send($admin, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function account_approval_email($user = '')
    {
        $subject = get_email_template('account_approval_email','subject');
        // $email_body = get_email_template('account_approval_email','body');
        // $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        // $email_body = str_replace('[[sitename]]', get_setting('website_name'), $email_body);
        // $email_body = str_replace('[[url]]', env('APP_URL'), $email_body);
        // $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);
        $email_body='						
        <html> 
        <head> 
            <title></title> 
        </head> 
        <body>
        <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
         
            <tbody><tr>
            <td valign="top" style="font-size:0"><img src="https://sarahtobiasmatrimony.com/images/Sarah&Tobias.png" alt="" width="600" height="360" class="CToWUd" data-bit="iit"></td>
            </tr>
            <tr>
            
            <tr>
            <td valign="top" style="border-left:1px solid #ef4d74;border-right:1px solid #ef4d74">
            <table width="598" border="0" cellspacing="0" cellpadding="0">
            <tbody><tr>
            <td style="background:#ef4d74;height:45px;padding:0 20px;font:16px Arial;color:#fff;line-height:45px;">Congratulations '.$user->first_name.' '.$user->last_name.'</td>
            </tr>
            <tr>
            <td>
            <table width="560" border="0" align="center" cellpadding="0" cellspacing="0"> 
         <tbody><tr>
         <td>&nbsp;</td>
         </tr>
         <tr>
         <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">Thank you for choosing Sarah Tobias Matrimony.The worlds No:1 Christian Matrimonial service provider. You have chosen the most excellent way to find your dream partner.</td>
         </tr>
         <tr>
         <td>&nbsp;</td>
         </tr>
         <tr>
         <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">As per verification,Your account has been approved for '.get_setting('website_name').' If your profile meets our terms of use, it will go live soon</td>
         </tr>
         <tr>
         <td>&nbsp;</td>
         </tr>
         <tr>
         <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">
         <strong> You will be able to log in from here :  : '. env('APP_URL') .'  </strong></td>
         </tr>
         <tr>
         <td>&nbsp;</td>
         </tr>
         <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">
         <strong> Your Member id :  '.$user->code.'  </strong></td>
         </tr>
         <tr>
         <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">&nbsp;</td>
         </tr>
         <tr>
         <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">Regards,<br>
         <strong>Team Sarah Tobias Matrimony</strong></td>
         </tr>
            <tr>
            <td>&nbsp;</td>
            </tr>
            </tbody></table> 
            </td>
            </tr>
            </tbody></table>
            
            </td>
            </tr>
            <tr>
            <td valign="top" style="font-size:0"><img src="https://sarahtobiasmatrimony.com/images/Myproject-2.png" alt="" width="600" height="60" class="CToWUd" data-bit="iit"></td>
            </tr>
           </tbody></table>
           </body>
        
           </html>
        '; 

        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function staff_account_opening_email($user = '', $pass = '', $role_name = '')
    {
        $subject    = get_email_template('staff_account_opening_email','subject');
        $email_body = get_email_template('staff_account_opening_email','body');
        $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[site_name]]', get_setting('website_name'), $email_body);
        $email_body = str_replace('[[role_type]]', $role_name, $email_body);
        $email_body = str_replace('[[email]]', $user->email, $email_body);
        $email_body = str_replace('[[password]]', $pass, $email_body);
        $email_body = str_replace('[[url]]', env('APP_URL'), $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);
        
        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function package_purchase_email($user = '', $package_payment = '')
    {
        $account_type = $package_payment->package_id== 1 ? 'Free' : 'Preminum';
        $package_name = Package::where('id',$package_payment->package_id)->first()->name;
        $subject    = get_email_template('package_purchase_email','subject');
        $email_body = get_email_template('package_purchase_email','body');
        $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[site_name]]', get_setting('website_name'), $email_body);
        $email_body = str_replace('[[account_type]]', $account_type , $email_body);
        $email_body = str_replace('[[payment_code]]', $package_payment->payment_code, $email_body);
        $email_body = str_replace('[[package]]', $package_name, $email_body);
        $email_body = str_replace('[[amount]]', $package_payment->amount, $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);

        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function manual_payment_approval_email($user = '', $package_payment = '')
    {
        $account_type = $package_payment->package_id== 1 ? 'Free' : 'Preminum';
        $package_name = Package::where('id',$package_payment->package_id)->first()->name;
        $subject    = get_email_template('manual_payment_approval_email','subject');
        $email_body = get_email_template('manual_payment_approval_email','body');
        $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[account_type]]', $account_type , $email_body);
        $email_body = str_replace('[[payment_code]]', $package_payment->payment_code, $email_body);
        $email_body = str_replace('[[package]]', $package_name, $email_body);
        $email_body = str_replace('[[amount]]', $package_payment->amount, $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);

        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function email_on_accepting_interest($user = '', $interest = '')
    {
        $subject    = get_email_template('email_on_accepting_interest','subject');
        $email_body = get_email_template('email_on_accepting_interest','body');
        $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        $email_body = str_replace('[[member_name]]', $interest->user->first_name.' '.$interest->user->last_name , $email_body);
        $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);

        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function password_reset_email($user = '', $code = '')
    {
        $subject    = get_email_template('password_reset_email','subject');
        // $email_body = get_email_template('password_reset_email','body');
        // $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        // $email_body = str_replace('[[code]]', $code, $email_body);
        // $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);
       
        $email_body = ' 

<html> 
<head> 
    <title> Password Reset Link </title> 
</head> 
<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
 
    <tbody><tr>
    <td valign="top" style="font-size:0"><img src="https://sarahtobiasmatrimony.com//images/Sarah&Tobias.png" alt="" width="600" height="360" class="CToWUd" data-bit="iit"></td>
    </tr>
    <tr>
    
    <tr>
    <td valign="top" style="border-left:1px solid #ef4d74;border-right:1px solid #ef4d74">
    <table width="598" border="0" cellspacing="0" cellpadding="0">
    <tbody><tr>
    <td style="background:#ef4d74;height:45px;padding:0 20px;font:16px Arial;color:#fff;line-height:45px;">Password Reset Link</td>
    </tr>
    <tr>
    <td>
    <table width="560" border="0" align="center" cellpadding="0" cellspacing="0"> 
 <tbody><tr>
 <td>&nbsp;</td>
 </tr>
 <tr>
 <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">Hi, '.$user->first_name.' '.$user->last_name.' , Follow the instructions on the bellow given link to Reset your password.</td>
 </tr>
 <tr>
 <td>&nbsp;</td>
 </tr>
 <tr>
 <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">
 Your Password reset Verification Code is : '. $code .'</td>
 </tr>

 <tr>
 <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">&nbsp;</td>
 </tr>
 <tr>
 <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">Regards,<br>
 <strong>Team Sarah Tobias Matrimony</strong></td>
 </tr>
    <tr>
    <td>&nbsp;</td>
    </tr>
    </tbody></table> 
    </td>
    </tr>
    </tbody></table>
    
    </td>
    </tr>
    <tr>
    <td valign="top" style="font-size:0"><img src="https://sarahtobiasmatrimony.com//images/Myproject-2.png" alt="" width="600" height="60" class="CToWUd" data-bit="iit"></td>
    </tr>
   </tbody></table>
   </body>

   </html>
'; 

        try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

    public static function email_on_request(User $user, string $identifier)
    {   
        $auth_user  = Auth::user();
        $subject    = get_email_template($identifier,'subject');

        // $email_body = get_email_template($identifier,'body');
        // $email_body = str_replace('[[name]]', $user->first_name.' '.$user->last_name, $email_body);
        // $email_body = str_replace('[[member_name]]', $auth_user->first_name.' '.$auth_user->last_name , $email_body);
        // $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);
       
           
      
            $gender = 0; // set a default value for $gender

            $users = Member::where('user_id', $auth_user->id)->get();
  
            
           // birthday is this format 2023-03-14 00:00:00
    
            if (count($users) > 0) {
                 $gender = $users[0]->gender;
                 $dob = $users[0]->birthday;
                 $date = Carbon::parse($dob);
            
                 // Calculate the age in years using the diffInYears() method
                  $age = $date->diffInYears(Carbon::now());
            }
       
            
        $photo = $auth_user->photo;
            
        if ($photo) {
            $pic = Upload::find($photo);
    
            if ($pic) {
                $prf_pics = $pic->file_name;
                $prf_pic ='https://sarahtobiasmatrimony.com/'.$prf_pics.'';
            } else {
                if ($gender == 1) {
                    $prf_pic = asset('assets/img/avatar-place.png');
                } else {
                    $prf_pic = asset('assets/img/female-avatar-place.png');
                }
            }
        } else {
            // handle the case when $photo is null
        }
    
        // use $subject, $gender, $age, and $prf_pic to build the email body
    
        


        $email_body  = ' 

<html> 
<head> 
    <title>You have Received Interest Request </title> 
</head> 
<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
 
    <tbody><tr>
    <td valign="top" style="font-size:0"><img src="https://sarahtobiasmatrimony.com//images/Sarah&Tobias.png" alt="" width="600" height="360" class="CToWUd" data-bit="iit"></td>
    </tr>
    <tr>
    
    <tr>
    <td valign="top" style="border-left:1px solid #ef4d74;border-right:1px solid #ef4d74">
    <table width="598" border="0" cellspacing="0" cellpadding="0">
    <tbody><tr>
    <td style="background:#ef4d74;height:45px;padding:0 20px;font:16px Arial;color:#fff;line-height:45px;">You have received interest request</td>
    </tr>
    <tr>
    <td>
    <table width="560" border="0" align="center" cellpadding="0" cellspacing="0">
    <tbody><tr>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td style="font:14px Arial;font-weight:700;color:#262626;line-height:18px">Dear '. $user->first_name.' '.$user->last_name .'</td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    </tr>
    <tr>
    <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">You have Received interest request from the following profiles.</td>
    </tr>
    <tr>
    <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">&nbsp;</td>
    </tr>
    <tr>
    <td valign="top" style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px;border:1px solid #b8b8b8;border-radius:5px;background:#fafbfb;padding:10px">
    <table width="538" border="0" cellspacing="0" cellpadding="0">
    <tbody><tr>
    <td width="129" rowspan="6" valign="top"><img src='.$prf_pic .' alt="" width="119" height="128" class="CToWUd" data-bit="iit"></td>
    <td width="285" style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px"> Name: '.$auth_user->first_name.' '.$auth_user->last_name.'</td>
    <td width="124" rowspan="6" valign="top" style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">
    <form id="m_6841491210482136470m_-212191396111283620expressInterestA" action="" method="post" target="_blank">
    <table width="90" border="0" align="right" cellpadding="0" cellspacing="0">
    <tbody><tr>
    <td><input style="border:none;background:#5cb85c;border-radius:5px;padding:5px;width:90px;color:#fff" type="submit" id="m_6841491210482136470m_-212191396111283620accept2327" value="ACCEPT"></td> 
    </tr>
    <tr><td><input type="hidden" name="exiId" id="m_6841491210482136470m_-212191396111283620exiId" value="2327">
    <input type="hidden" name="rstatus" id="m_6841491210482136470m_-212191396111283620respondstatus" value="1">
    <input type="hidden" name="ci_csrf_token" value=""> 
    </td></tr></tbody></table>
    </form>
    <form id="m_6841491210482136470m_-212191396111283620expressInterestD" action="" method="post" target="_blank">
    <table width="90" border="0" align="right" cellpadding="0" cellspacing="0">
    <tbody><tr>
    <td style="padding:5px 0 0"><input style="border:none;background:#d9534f;border-radius:5px;padding:5px;width:90px;color:#fff" type="submit" id="m_6841491210482136470m_-212191396111283620decline2327" value="DECLINE"></td>
    </tr>
    <tr><td><input type="hidden" name="exiId" id="m_6841491210482136470m_-212191396111283620exiId" value="2327">
    <input type="hidden" name="rstatus" id="m_6841491210482136470m_-212191396111283620respondstatus" value="2">
    <input type="hidden" name="ci_csrf_token" value=""> 
   
    </td></tr></tbody></table>
    </form>
    </td>
    </tr>
   
    <tr>
    <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">Age : '.$age.' </td>
    </tr>
  
    <tr>
    <td valign="top" style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">
    <a style="font-style:italic;color:#008aff;font-size:12px;text-decoration:none" href="https://sarahtobiasmatrimony.com/member-profile/'. $auth_user->id .'" rel="noreferrer" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://sarahtobiasmatrimony.com/ember-profile/'. $auth_user->id .' &amp;source=gmail&amp;ust=1660119153573000&amp;usg=AOvVaw37liIRLumxzXpOfnsF-OIi">view profile</a>
    </td>
    </tr>
    </tbody></table>
    </td>
    </tr>
    <tr>
    <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">&nbsp;</td>
    </tr>
    <tr>
    <td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">Regards,<br>
    <strong>Team Sarah Tobias Matrimony</strong></td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    </tr>
    </tbody></table> 
    </td>
    </tr>
    </tbody></table>
    
    </td>
    </tr>
    <tr>
    <td valign="top" style="font-size:0"><img src="https://sarahtobiasmatrimony.com//images/Myproject-2.png" alt="" width="600" height="60" class="CToWUd" data-bit="iit"></td>
    </tr>
   </tbody></table>
   </body>

   </html>
'; 
try{
            Notification::send($user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            dd($e);
        }
    }

    public static function email_on_accept_request($notify_user, $identifier)
    {
        $auth_user  = Auth::user();
        $subject    = get_email_template($identifier,'subject');
        // $email_body = get_email_template($identifier,'body');
        // $email_body = str_replace('[[name]]', $notify_user->first_name.' '.$notify_user->last_name, $email_body);
        // $email_body = str_replace('[[member_name]]', $auth_user->first_name.' '. $auth_user->last_name , $email_body);
        // $email_body = str_replace('[[from]]', env('MAIL_FROM_NAME'), $email_body);
        
        $gender = 0; // set a default value for $gender

        $users = Member::where('user_id', $auth_user->id)->get();

        
       // birthday is this format 2023-03-14 00:00:00

        if (count($users) > 0) {
             $gender = $users[0]->gender;
             $dob = $users[0]->birthday;
             $date = Carbon::parse($dob);
        
             // Calculate the age in years using the diffInYears() method
              $age = $date->diffInYears(Carbon::now());
        }
   
        
    $photo = $auth_user->photo;
        
    if ($photo) {
        $pic = Upload::find($photo);

        if ($pic) {
            $prf_pics = $pic->file_name;
            $prf_pic ='https://sarahtobiasmatrimony.com/'.$prf_pics.'';
        } else {
            if ($gender == 1) {
                $prf_pic = asset('assets/img/avatar-place.png');
            } else {
                $prf_pic = asset('assets/img/female-avatar-place.png');
            }
        }
    } else {
        // handle the case when $photo is null
    }

    // use $subject, $gender, $age, and $prf_pic to build the email body

    


    $email_body  = ' 

<html> 
<head> 
<title>Interest Request Accepted</title> 
</head> 
<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">

<tbody><tr>
<td valign="top" style="font-size:0"><img src="https://sarahtobiasmatrimony.com//images/Sarah&Tobias.png" alt="" width="600" height="360" class="CToWUd" data-bit="iit"></td>
</tr>
<tr>

<tr>
<td valign="top" style="border-left:1px solid #ef4d74;border-right:1px solid #ef4d74">
<table width="598" border="0" cellspacing="0" cellpadding="0">
<tbody><tr>
<td style="background:#ef4d74;height:45px;padding:0 20px;font:16px Arial;color:#fff;line-height:45px;">You have received interest request</td>
</tr>
<tr>
<td>
<table width="560" border="0" align="center" cellpadding="0" cellspacing="0">
<tbody><tr>
<td>&nbsp;</td>
</tr>
<tr>
<td style="font:14px Arial;font-weight:700;color:#262626;line-height:18px">Dear '. $notify_user->first_name.' '.$notify_user->last_name .'</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">Accepted your interest request.</td>
</tr>
<tr>
<td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">&nbsp;</td>
</tr>
<tr>
<td valign="top" style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px;border:1px solid #b8b8b8;border-radius:5px;background:#fafbfb;padding:10px">
<table width="538" border="0" cellspacing="0" cellpadding="0">
<tbody><tr>
<td width="129" rowspan="6" valign="top"><img src='.$prf_pic .' alt="" width="119" height="128" class="CToWUd" data-bit="iit"></td>
<td width="285" style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px"> Name: '.$auth_user->first_name.' '.$auth_user->last_name.'</td>
<td width="124" rowspan="6" valign="top" style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">


</td>
</tr>

<tr>
<td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">Age : '.$age.' </td>
</tr>

<tr>
<td valign="top" style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">
<a style="font-style:italic;color:#008aff;font-size:12px;text-decoration:none" href="https://sarahtobiasmatrimony.com/member-profile/'. $auth_user->id .'" rel="noreferrer" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://sarahtobiasmatrimony.com/ember-profile/'. $auth_user->id .' &amp;source=gmail&amp;ust=1660119153573000&amp;usg=AOvVaw37liIRLumxzXpOfnsF-OIi">view profile</a>
</td>
</tr>
</tbody></table>
</td>
</tr>
<tr>
<td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">&nbsp;</td>
</tr>
<tr>
<td style="font:14px Arial;font-weight:normal;color:#262626;line-height:18px">Regards,<br>
<strong>Team Sarah Tobias Matrimony</strong></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
</tbody></table> 
</td>
</tr>
</tbody></table>

</td>
</tr>
<tr>
<td valign="top" style="font-size:0"><img src="https://sarahtobiasmatrimony.com//images/Myproject-2.png" alt="" width="600" height="60" class="CToWUd" data-bit="iit"></td>
</tr>
</tbody></table>
</body>

</html>
'; 
        try{
            Notification::send($notify_user, new EmailNotification($subject, $email_body));
        }
        catch(\Exception $e){
            // dd($e);
        }
    }

}

?>
