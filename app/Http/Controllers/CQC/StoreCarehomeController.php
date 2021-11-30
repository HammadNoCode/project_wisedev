<?php

namespace App\Http\Controllers\CQC;

use App\Http\Controllers\Controller;
use App\Models\CQC\Carehome\Specialism;
use App\Models\CQC\Carehome;
use App\Models\CQC\Carehome\Contact;
use App\Models\CQC\Carehome\Coordinates;
use App\Models\CQC\Carehome\ServiceType;
use App\Models\CQC\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StoreCarehomeController extends Controller
{
    public function storeCarehomes()
    {
        $location_ids = Location::select('location_ids')->pluck('location_ids');
        echo count($location_ids) . "\n";
        foreach ($location_ids as $id) {
            try {
                $carehome = Http::get('https://api.cqc.org.uk/public/v1/locations/' . $id . '?partnerCode=CAVALRYCARE')->json();
            } catch (\Exception $e) {
                echo 'exception caught ', $e->getMessage(), '\n';
            }
            if (Carehome::where('location_id', $carehome['locationId'])->exists()) {
                $client = Carehome::where('location_id', $carehome['locationId'])->firstOrFail();
                $client->update([
                    'provider_id' => $carehome['providerId'],
                    'location_id' => $carehome['locationId'],
                    'name' => isset($carehome['name']) ? $carehome['name'] : '',
                    'address_1' => isset($carehome['postalAddressLine1']) ? $carehome['postalAddressLine1'] : '',
                    'city' => isset($carehome['postalAddressTownCity']) ? $carehome['postalAddressTownCity'] : '',
                    'postal_code' => isset($carehome['postalCode']) ? $carehome['postalCode'] : '',
                    'region' => isset($carehome['region']) ? $carehome['region'] : '',
                    'main_contact_number' => isset($carehome['mainPhoneNumber']) ? $carehome['mainPhoneNumber'] : '',
                    'beds' => isset($carehome['numberOfBeds']) ? $carehome['numberOfBeds'] : '',
                    'rating' => isset($carehome['currentRatings']['overall']['rating']) ? $carehome['currentRatings']['overall']['rating'] : '',
                    'website' => isset($carehome['website']) ? $carehome['website'] : '',
                ]);
            } else {
                (new Carehome)->create([
                    'provider_id' => $carehome['providerId'],
                    'location_id' => $carehome['locationId'],
                    'name' => isset($carehome['name']) ? $carehome['name'] : '',
                    'address_1' => isset($carehome['postalAddressLine1']) ? $carehome['postalAddressLine1'] : '',
                    'city' => isset($carehome['postalAddressTownCity']) ? $carehome['postalAddressTownCity'] : '',
                    'postal_code' => isset($carehome['postalCode']) ? $carehome['postalCode'] : '',
                    'region' => isset($carehome['region']) ? $carehome['region'] : '',
                    'main_contact_number' => isset($carehome['mainPhoneNumber']) ? $carehome['mainPhoneNumber'] : '',
                    'beds' => isset($carehome['numberOfBeds']) ? $carehome['numberOfBeds'] : '',
                    'rating' => isset($carehome['currentRatings']['overall']['rating']) ? $carehome['currentRatings']['overall']['rating'] : '',
                    'website' => isset($carehome['website']) ? $carehome['website'] : '',
                ]);
            }
        }
    }

    public function storeCarehomeSpecialisms()
    {
        $location_ids = Location::select('location_ids')->pluck('location_ids');
        foreach ($location_ids as $id) {
            try {
                $carehome = Http::get('https://api.cqc.org.uk/public/v1/locations/' . $id . '?partnerCode=CAVALRYCARE')->json();
            } catch (\Exception $e) {
                echo 'exception caught ', $e->getMessage(), '\n';
            }
            if (isset($carehome['specialisms'])) {
                foreach ($carehome['specialisms'] as $specialism) {
                    if (Specialism::where('location_id', $carehome['locationId'])->where('specialism', $specialism['name'])->exists()) {
                        $exsisting = Specialism::where('location_id', $carehome['locationId'])->firstOrFail();
                        $exsisting->update([
                            'specialism' => $specialism['name'],
                        ]);
                    } else {
                        (new Specialism)->create([
                            'location_id' => $carehome['locationId'],
                            'specialism' => $specialism['name'],
                        ]);
                    }
                }
            }
        }
    }

    public function storeCarehomeServiceTypes()
    {
        $location_ids = Location::select('location_ids')->pluck('location_ids');
        foreach ($location_ids as $id) {
            try {
                $carehome = Http::get('https://api.cqc.org.uk/public/v1/locations/' . $id . '?partnerCode=CAVALRYCARE')->json();
            } catch (\Exception $e) {
                echo 'exception caught ', $e->getMessage(), '\n';
            }
            if (isset($carehome['gacServiceTypes'])) {
                foreach ($carehome['gacServiceTypes'] as $servicetypes) {
                    if (ServiceType::where('location_id', $carehome['locationId'])->where('type', $servicetypes['name'])->exists()) {
                        $exsisting = ServiceType::where('location_id', $carehome['locationId'])->firstOrFail();
                        $exsisting->update([
                            'type' => isset($servicetypes['name']) ? $servicetypes['name'] : '',
                            'description' => isset($servicetypes['description']) ? $servicetypes['description'] : '',
                        ]);
                    } else {
                        (new ServiceType)->create([
                            'location_id' => $carehome['locationId'],
                            'type' => $servicetypes['name'],
                            'description' => $servicetypes['description'],
                        ]);
                    }
                }
            }
        }
    }

    public function storeCarehomeContacts()
    {
        $location_ids = Location::select('location_ids')->pluck('location_ids');
        foreach ($location_ids as $id) {
            try {
                $carehome = Http::get('https://api.cqc.org.uk/public/v1/locations/' . $id . '?partnerCode=CAVALRYCARE')->json();
            } catch (\Exception $e) {
                echo 'exception caught ', $e->getMessage(), '\n';
            }
            if (isset($carehome['regulatedActivities'])) {
                foreach ($carehome['regulatedActivities'] as $regulatedActivities) {
                    foreach ($regulatedActivities['contacts'] as $contacts) {
                        // return $contacts;
                        if (Contact::where('location_id', $carehome['locationId'])->where('full_name', $contacts['personGivenName'] . ' ' . $contacts['personFamilyName'])->exists()) {
                            $exsisting = ServiceType::where('location_id', $carehome['locationId'])->firstOrFail();
                            $exsisting->update([
                                'full_name' => $contacts['personGivenName'] . ' ' . $contacts['personFamilyName'],
                                'role' => isset($contacts['personRoles'][0]) ? $contacts['personRoles'][0] : '',
                            ]);
                        } else {
                            (new Contact())->create([
                                'location_id' => $carehome['locationId'],
                                'full_name' => $contacts['personGivenName'] . ' ' . $contacts['personFamilyName'],
                                'role' => $contacts['personRoles'][0],
                            ]);
                        }
                    }
                }
            }
        }
    }
}
