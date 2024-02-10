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
use App\Models\Likes;
use App\Models\Encounter;
class UserEncounterUtility
{
    public function processSkipEncounterUser($toUserUid)
    {
        //delete old encounter User
        $this->userEncounterRepository->deleteOldEncounterUser();

        // fetch User by toUserUid
        $user = $this->userRepository->fetch($toUserUid);

        // check if user exists
        if (__isEmpty($user)) {
            return $this->engineReaction(2, null, __tr('User does not exists.'));
        }

        //store encounter User Data
        $storeData = [
            'status' => 1,
            'to_users__id' => $user->_id,
            'by_users__id' => getUserID()
        ];

        //store encounter user
        if ($this->userEncounterRepository->storeEncounterUser($storeData)) {
            return $this->engineReaction(1, null, __tr('Skip user successfully.'));
        }

        return $this->engineReaction(2, null, __tr('Something went wrong.'));
    }

   

}

?>
