<?php

namespace App\Http\Controllers\Compliance\CompletedAudit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Compliance\CompletedAudit\Upload as File;
use App\Models\Compliance\Document\Audit;
use App\Models\Staff\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class TableController extends Controller
{
    public function show($id, Request $request)
    {
        $user = User::where('id', session('staff_id'))->firstOrFail();
        if ((int) $user->compliance_manager === 1) {
            $filtered = $this->filter($request->filter);
            $files = $filtered->where('audit_id', $id)->with('audit')->withCount('viewers')->paginate(10);
        } else {
            $files = File::where('audit_id', $id)->where('staff_id', session('staff_id'))->with('audit')->withCount('viewers')->paginate(10);
        }
        return response()->json($files, 200);
    }

    public function filter($filter)
    {
        if ($filter == 'all') {
            return new File();
        }
        return File::where('staff_id', $filter);
    }

    public function update(Request $request, $id)
    {
        $file = File::where('id', $id)->firstOrFail();
        $file->update(['score' => $request->score]);
        return response()->json([
            'message' => 'File score stored'
        ], 201);
    }

    public function destroy($id)
    {
        $filename = File::where('id', $id)->pluck('filename');
        Storage::disk('s3')->delete('completed/audit-documents/' . session('staff_id') . '/' . $filename);
        File::where('id', $id)->delete();
        return response()->json([
            'message' => 'Audit deleted'
        ], 200);
    }
}
