<?php

namespace Callbacks\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Callbacks\Models\Callback;
use Callbacks\Http\Requests\StoreCallbackRequest;

class CallbacksController
{

	public function store(StoreCallbackRequest $request)
	{
		return response()->json(
			Callback::create($request->validated()),
			200
		);
	}

	public function filterOutcome($calls, $outcome)
	{
		switch ($outcome) {
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
				return $calls->whereOutcome($outcome);
				break;
			default:
				return $calls;
		}
	}

	public function filterDate(Request $request, $calls)
	{
		$fromDate = Carbon::parse($request->from)->toDateTimeString();
		$toDate = Carbon::parse($request->to)->addDay()->toDateTimeString();
		if ($fromDate == $toDate) {
			return $calls->where('scheduled', 'LIKE', $fromDate . '%');
		}
		return $calls->where('scheduled', '>=', $fromDate)
			->where('scheduled', '<', $toDate);
	}

	public function filterStaff(Request $request, $calls)
	{
		$staffFilter = ($request->user == 0) ? $request->user_id : $request->user;
		if ($request->user == 0) {
			return $calls->whereIn('staff_id', $request->staff_array);
		}
		return $calls->whereStaffId($staffFilter);
	}

	public function outcomeResponse($outcome)
	{
		switch ($outcome) {
			case 1:
				return 'Call set to Pending';
			case 2:
				return 'Call set to Successful';
			case 3:
				return 'Call set to Not Interested';
			case 4:
				return 'Call set to Further Call Required';
			case 5:
				return 'Call set to Not Available';
			default:
				return 'Call updated';
		}
	}

	public function update(Request $request, $id)
	{
		Callback::whereId($request->id)->update([
			'outcome' => $request->outcome
		]);
		if ($request->nextCall) {
			Callback::create([
				'title' => $request->title,
				'staff_id' => $request->staff_id,
				'scheduled' => $request->nextCall,
				'path' => $request->path
			]);
			return response()->json([
				'message' => 'New call scheduled at ' . $request->nextCall
			], 201);
		}
		return response()->json([
			'message' => $this->outcomeResponse($request->outcome)
		], 200);
	}

	public function overview(Request $request)
	{
		$calls = $this->filterStaff($request, Callback::whereOutcome(1));
		return response()->json([
			'overdue' => (clone $calls)->where('scheduled', '<', Carbon::now()->toDateTimeString())->count(),
			'today' => (clone $calls)->where('scheduled', 'like', Carbon::now()->format('Y-m-d') . '%')->count(),
			'tomorrow' => (clone $calls)->where('scheduled', 'like', Carbon::now()->addDay()->format('Y-m-d') . '%')->count(),
		], 200);
	}

	public function index(Request $request)
	{
		$calls = $this->filterOutcome(new Callback, $request->outcome);
		$calls = $this->filterStaff($request, $calls);
		if (isset($request->overdue)) {
			$calls = $calls->where('scheduled', '<', Carbon::now()->toDateTimeString());
		} else {
			$calls = $this->filterDate($request, $calls);
		}
		return response()->json(
			$calls->with(
				'user:id,name'
			)
				->orderBy('scheduled')
				->paginate(15),
			200
		);
	}
}
