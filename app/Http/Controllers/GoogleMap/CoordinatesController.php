<?php

namespace App\Http\Controllers\GoogleMap;

use App\Http\Controllers\Controller;
use App\Models\CQC\Carehome\Coordinates as CarehomeCoordinates;
use App\Models\CQC\Location;
use App\Models\Staff\Map\ApplicantMap as ApplicantCoordinates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CoordinatesController extends Controller
{
    public function applicant_coordinates_calculator()
    {
        $old = ApplicantCoordinates::where('applicant_id', '!=', null)->pluck('applicant_id');
        $applicants = ApplicantCoordinates::where('address_line_1', '!=', null)->whereNotNull('declaration')->whereNotIn('id', $old)->get();
        echo count($applicants) . "\n";
        foreach ($applicants as $applicant) {
            try {
                if ($applicant->address_line_2 == null) {
                    $address = str_replace(" ", "+", $applicant->address_line_1) . ",+" . str_replace(" ", "+", $applicant->city) . ",+" . str_replace(" ", "+", $applicant->postcode) . ",+UK";
                } else {
                    $address = str_replace(" ", "+", $applicant->address_line_1) . ",+" . str_replace(" ", "+", $applicant->address_line_2) . ",+" . str_replace(" ", "+", $applicant->city) . ",+" . str_replace(" ", "+", $applicant->postcode) . ",+UK";
                }
                $geocode = Http::get('https://maps.googleapis.com/maps/api/geocode/json?address="' . $address . '"&sensor=false&key=AIzaSyBdwDVYeELQ4eB5COg-TQqvtD_PEykKTyE');
                $jsonData = $geocode->json();
                $lat = $jsonData['results'][0]['geometry']['location']['lat'];
                $lng = $jsonData['results'][0]['geometry']['location']['lng'];
                ApplicantCoordinates::updateOrInsert([
                    'applicant_id' => $applicant->id,
                    'lat' => $lat,
                    'lng' => $lng,
                    'test' => $applicant->test,
                ]);
            } catch (\Exception $e) {
            }
        }
    }

    public function carehome_coordinates_calculator()
    {
        $location_ids = Location::select('location_ids')->pluck('location_ids');
        foreach ($location_ids as $id) {
            try {
                $carehome = Http::get('https://api.cqc.org.uk/public/v1/locations/' . $id . '?partnerCode=CAVALRYCARE')->json();
            } catch (\Exception $e) {
                echo 'exception caught ', $e->getMessage(), '\n';
            }
            if (isset($carehome['onspdLatitude'])) {
                if (CarehomeCoordinates::where('location_id', $carehome['locationId'])->exists()) {
                    $coordinates = CarehomeCoordinates::where('location_id', $carehome['locationId'])->firstOrFail();
                    $coordinates->update([
                        'location_id' => $carehome['locationId'],
                        'lat' => isset($carehome['onspdLatitude']) ? $carehome['onspdLatitude'] : '',
                        'lng' => isset($carehome['onspdLongitude']) ? $carehome['onspdLongitude'] : '',
                    ]);
                } else {
                    (new CarehomeCoordinates)->create([
                        'location_id' => $carehome['locationId'],
                        'lat' => isset($carehome['onspdLatitude']) ? $carehome['onspdLatitude'] : '',
                        'lng' => isset($carehome['onspdLongitude']) ? $carehome['onspdLongitude'] : '',
                    ]);
                }
            }
        }
    }
}
