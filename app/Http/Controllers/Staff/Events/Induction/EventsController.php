<?php

namespace App\Http\Controllers\Staff\Events\Induction;

use App\Models\Staff\Events\Event;
use App\Models\Staff\Recruitment\{Application, Interview, Log, Postcodes};
use App\Models\Staff\User\{User};
use App\Http\Requests\Event\{UpdateRequest};
use Illuminate\Support\Facades\{Validator, Mail};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class EventsController extends Controller
{
    const LIVE = true; // change to TRUE before committing
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = null;

    public function index(Request $request)
    {
        $filteredBranch = $this->filter_branch($request->filterBranch);
        $searched = $this->search((clone $filteredBranch), $request->search);
        $sorted = $this->sort($searched, $request->sort);
        $selected = $sorted
            ->select(
                '*',
                'type as event_name',
                'attendee_type',
                'date as scheduled_date',
                'time as scheduled_time'
            )
            ->whereType('1')
            ->orderBy('expired', 'asc')
            ->paginate(15);
        return response()->json($selected, 200);
    }

    public function filter_branch($filterBranch)
    {
        if ($filterBranch == 0) {
            return new Event();
        } else {
            return Event::where('branch_id', $filterBranch);
        }
    }

    public function sort($events, $sort)
    {
        switch ($sort) {
            case 'upcoming':
                return $events->where('date', '>=', Carbon::now());
            case 'previous':
                return $events->where('date', '<', Carbon::now());
            default:
                return $events;
        }
    }

    public function search($events, $search)
    {
        return $events->where(function ($query) use ($search) {
            $query->orWhere("agenda", 'LIKE', "%{$search}%");
            $query->orWhere("type", 'LIKE', "%{$search}%");
            $query->orWhere("location", 'LIKE', "%{$search}%");
        });
    }

    public function show($id)
    {
        $events = Event::where('id', $id)->firstOrFail();
        return response()->json($events, 200);
    }

    public function update($id, UpdateRequest $request)
    {
        $events = Event::where('id', $id)->firstOrFail();
        $events->update($request->all());
        return response()->json([
            'message' => 'Event successfully created'
        ], 200);
    }

    public function destroy($id)
    {
        Event::where('id', $id)->delete();
        return response()->json([
            'message' => 'The event has been deleted'
        ], 200);
    }

    public function create()
    {
        return response()->json([
            'id' => Event::insertGetId([]),
        ], 200);
    }

    public function auto_assign_branch()
    {
        $events = Event::whereNull('branch_id')->whereType('1')
            ->select('id', 'postcode')
            ->get();
        echo count($events) . "\n";
        foreach ($events as $event) {
            $postcodeArray = str_split($event->postcode);
            if (is_int($postcodeArray[1])) {
                $postcode = $postcodeArray[0];
            } else {
                $postcode = $postcodeArray[0] . $postcodeArray[1];
            }
            $branchId = Postcodes::wherePostcodePrefix($postcode)->value('branch_id');
            if (!$branchId) {
                $branchId = 2;
            }
            Event::whereId($event->id)->update(['branch_id' => $branchId]);
        }
    }

    public function auto_update_expired()
    {
        $events = Event::get();
        echo count($events) . "\n";
        foreach ($events as $event) {
            if ($event->date >= Carbon::now()) {
                Event::whereId($event->id)->update(['expired' => null]);
            } else {
                Event::where('date', '<', Carbon::now())->update(['expired' => 1]);
            }
        }
    }
}
