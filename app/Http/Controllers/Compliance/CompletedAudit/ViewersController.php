<?php

namespace App\Http\Controllers\Compliance\CompletedAudit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Compliance\CompletedAudit\Upload as File;
use App\Models\Compliance\CompletedAudit\Viewer;
use App\Models\Compliance\Document\Audit;
use App\Models\Staff\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class ViewersController extends Controller
{
    public function show($id)
    {
        $viewers = Viewer::where('completed_audit_id', $id)->paginate(10);
        return response()->json($viewers, 200);
    }
}
