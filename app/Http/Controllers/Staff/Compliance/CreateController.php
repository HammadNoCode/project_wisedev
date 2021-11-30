<?php

namespace App\Http\Controllers\Staff\Compliance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator, Mail};
use App\Models\Staff\Recruitment\{Compliance as Documents, ApplicantCompliance as AppDocuments, Application};
use App\Models\Staff\User\{Branches, User};
use App\Http\Controllers\Controller;

class CreateController extends Controller
{
    const LIVE = true;
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const TEST_MOBILE = null;

    public static function env()
    {
        return (bool) User::whereId(session('staff_id'))->value('test');
    }

    /**
     * Index function
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $filtered = $this->filter($request->filter);
        $all = $filtered->select('*', 'name', 'type', 'required')
            ->orderBy('type', 'asc')
            // ->whereTest($this->env())
            ->where('deleted', '!=', 1)
            ->paginate(15);
        return response()->json($all, 200);
    }
    /**
     * Filter index data
     *
     * @param [type] $filter
     * @return void
     */
    public function filter($filter)
    {
        if ($filter == 'all') {
            return new Documents();
        }
        return Documents::where('type', $filter);
    }

    /**
     * Store new compliance requirements
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
      //  dd($request->all());
        $document = (new Documents())->createDocument($request);
        return response()->json([
            'message' => 'Document created'
        ], 201);
    }

    /**
     * Update existing compliance requirements
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $record = Documents::whereId($id)->firstOrFail();
        $record->update([
            'name' => $request->name,
            'type' => $request->type,
            'required' => $request->required,
        ]);
        return response()->json([
            'message' => 'Compliance item updated'
        ], 201);
    }

    /**
     * Destroy existing compliance requirements
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        Documents::where('id', $id)->update(['deleted' => 1]);
        return response()->json([
            'message' => 'The document has been removed from the list'
        ], 200);
    }
}
