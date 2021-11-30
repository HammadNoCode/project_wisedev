<?php

namespace App\Http\Controllers\Compliance\Templates;

use App\Models\Compliance\Document\Group;
use App\Http\Controllers\Controller;
use App\Models\Compliance\Document\Audit;

class AuditController extends Controller
{
    public function destroy($id)
    {
        Audit::where('id', $id)->update(['deleted' => 1]);
        return response()->json([
            'message' => 'Audit soft deleted'
        ], 200);
    }
}
