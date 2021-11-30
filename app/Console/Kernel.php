<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected function schedule(Schedule $schedule)
    {

        Log::channel('branch_id')->info('Application branch ids updated', [
            $schedule->call('App\Http\Controllers\Staff\Recruitment\BranchController@assign_application_branch_id')->everyFifteenMinutes()->sendOutputTo(storage_path('logs/branch_ids.log'))
        ]);

        Log::channel('reference_reminder')->info('Reference reminders sent', [
            $schedule->call('App\Http\Controllers\Staff\Recruitment\Reference\Email\ReminderController@automated_reminder')->weekdays()->at('10:00')->sendOutputTo(storage_path('logs/reference_reminder.log'))->emailOutputTo('isaac@warrantywise.co.uk')
        ]);

        /**
         * Reminders
         */

        // 24 hour prior interview reminder
        $schedule->call('App\Http\Controllers\Staff\Recruitment\InterviewsController@one_day_reminder')->dailyAt('17:00');

        // Covid-19 upload result reminder (captured from application)
        // $schedule->call('App\Http\Controllers\Covid\Results\EmailController@covid_test_upload_reminder')->cron('00 09 * * 1,5');

        // Incomplete application reminder (initial enquiry)
        // $schedule->call('App\Http\Controllers\Staff\Recruitment\InitialEnquiry\EmailController@email_24hr_reminder')->everyMinute();

        /**
         * Update
         */

        // Assign branch to application

        // Assign branch to events
        $schedule->call('App\Http\Controllers\Staff\Events\Induction\EventsController@auto_assign_branch')->everyTenMinutes();

        $schedule->call('App\Http\Controllers\Staff\Events\Training\EventsController@auto_assign_branch')->everyTenMinutes();

        // Assign induction events expiry date
        $schedule->call('App\Http\Controllers\Staff\Events\Induction\EventsController@auto_update_expired')->dailyAt('20:00');

        // Carehome branch assign
        // $schedule->call('App\Http\Controllers\CQC\CarehomeController@assign_branch')->everyMinute();


        /**
         * Google Map
         */

        // applicant coordinates
        // $schedule->call('App\Http\Controllers\GoogleMap\CoordinatesController@applicant_coordinates_calculator')->everyMinute();

        // // carehome coordinates
        // $schedule->call('App\Http\Controllers\GoogleMap\CoordinatesController@carehome_coordinates_calculator')->everyMinute();

        // // Convert shifts to hours
        // $schedule->call('App\Http\Controllers\Staff\Recruitment\PipelineController@convert_shifts_to_hours_per_week')->everyMinute();


        /**
         * Misc
         */

        // compliance expiry update -> tracker
        $schedule->call('App\Http\Controllers\Staff\Recruitment\Compliance\AppComplianceController@update_expired')->everyTenMinutes();

        // Vaccination upload alert (portal)
        // $schedule->call('App\Http\Controllers\Covid\VaccinationController@portal_invite')->cron('00 08 * * 1,3,5');

        // Vaccination upload alert (pulse)
        // $schedule->call('App\Http\Controllers\Covid\VaccinationController@pulse_invite')->cron('00 08 * * 1,3,5');


        /**
         * CQC api calls

         * General info
         * $schedule->call('App\Http\Controllers\CQC\StoreCarehomeController@storeCarehomes')->everyMinute();

         * Specialisms
         * $schedule->call('App\Http\Controllers\CQC\StoreCarehomeController@storeCarehomeSpecialisms')->everyMinute();

         * Service types
         * $schedule->call('App\Http\Controllers\CQC\StoreCarehomeController@storeCarehomeServiceTypes')->everyMinute();

         * Contacts
         * $schedule->call('App\Http\Controllers\CQC\StoreCarehomeController@storeCarehomeContacts')->everyMinute();
         */
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
