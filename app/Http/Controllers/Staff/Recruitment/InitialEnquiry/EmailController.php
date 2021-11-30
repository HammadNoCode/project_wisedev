<?php

namespace App\Http\Controllers\Staff\Recruitment\InitialEnquiry;

use App\Actions\SendEmailAction;
use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application\Invite;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    const LIVE = false;
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = null;

    /**
     * Email all invitees - manually triggered
     *
     * @return void
     */
    public function email_all(SendEmailAction $action)
    {
        $data = Invite::where('converted', 0)
            ->get();
        foreach ($data as $invite) {
            $action->execute('24hr_reminder', $invite);
        }
        return response()->json(['message' => 'Emails sent'], 200);
    }

    /**
     * Send a 24hr email reminder
     * Update 24hr reminder column => 1
     *
     * @return void
     */
    public function email_24hr_reminder(SendEmailAction $action)
    {
        $data = Invite::where('converted', 0)
            ->where('24hr_reminder', 0)
            ->where('created_at', '<', Carbon::now()->subDays(1))
            ->get();
        echo count($data) . "\n";
        foreach ($data as $invite) {
            $action->execute('24hr_reminder', $invite);
            Invite::where('id', $invite->id)
                ->update([
                    '24hr_reminder' => 1,
                ], 200);
            $invite->save();
        }
    }
}
