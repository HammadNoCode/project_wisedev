<?php

namespace App\Http\Controllers\Staff\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application;
use App\Models\Staff\Recruitment\Postcodes;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * get applications where first_name != null, select postcode and id
     * lop throught each piece of data and split postcode into a string
     * if the second value of the postcode is an int use the first letter else use the first & second
     * select the correct prefix from postcode table
     * update application branch_id 
     *
     * @return void
     */
    public function assign_application_branch_id()
    {
        $applications = Application::where('branch_id', null)
            ->where('postcode', '!=', null)
            ->get();

        foreach ($applications as $application) {

            try {
                $postcodeArray = str_split($application->postcode);

                if (is_numeric($postcodeArray[1])) {
                    $postcode = $postcodeArray[0];
                } else {
                    $postcode = $postcodeArray[0] . $postcodeArray[1];
                }

                $branch_id = Postcodes::where('postcode_prefix', $postcode)->value('branch_id');

                if (!$branch_id) {
                    $branch_id = 2;
                }

                $application = Application::whereId($application->id)->first();

                $application->update([
                    'branch_id' => (int) $branch_id,
                ]);
            } catch (\Exception $e) {
                echo 'exception caught ', $e->getMessage(), '\n';
            }
        }
    }
}
