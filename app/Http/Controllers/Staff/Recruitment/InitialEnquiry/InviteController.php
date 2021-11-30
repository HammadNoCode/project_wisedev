<?php

namespace App\Http\Controllers\Staff\Recruitment\InitialEnquiry;

use App\Actions\SendEmailAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApplicationInvite\StoreInviteRequest;
use App\Models\Staff\Recruitment\Application\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class InviteController extends Controller
{
    const LIVE = false;
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = null;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Invite::where('converted', 0)
            ->select('*', 'referred_by as username')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInviteRequest $request, SendEmailAction $action)
    {
        if ($request->referral == 'Yes') {
            $referred_by = session('staff_id');
        } else {
            $referred_by = NULL;
        }
        $invite = (new Invite())->createInvite($request, $referred_by);
        $action->execute('invite', $invite);
        return response()->json(['message' => 'Invite sent']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
