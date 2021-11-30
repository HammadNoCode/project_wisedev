<?php

namespace App\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailAction
{

  protected Request $request;

  public function __construct(Request $request)
  {
    $this->request = $request;
  }

  const LIVE = true;
  const TEST_EMAIL = 'isaac@warrantywise.co.uk';
  const TEST_MOBILE = null;

  public function execute($type, $data)
  {
    switch ($type) {
      case ('invite'):
        $template = 'mail.staff.application.invite';
        $subject = 'Application Invite';
        break;
      case ('24hr_reminder'):
        $template = 'mail.staff.application.invite_reminder';
        $subject = 'Application Reminder';
        break;
    }
    $mail_data = [
      'first_name' => $data->first_name,
      'last_name' => $data->last_name,
      'email' => $data->email,
      'token' => $data->token,
    ];
    Mail::send($template, $mail_data, function ($message) use ($mail_data, $subject) {
      $message->from('join@cavalrycare.co.uk');
      if (self::LIVE) {
        $message->to($mail_data['email'], $mail_data['first_name'])->subject($subject);
      } else {
        $message->to(self::TEST_EMAIL, $mail_data['first_name'])->subject($subject);
      }
    });
  }
}
