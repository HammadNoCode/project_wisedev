<?php

namespace App\Http\Controllers\Compliance\CompletedAudit;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Compliance\CompletedAudit\Upload as File;
use App\Http\Controllers\Controller;
use App\Models\Compliance\CompletedAudit\Viewer;
use App\Models\Compliance\Document\Group;
use App\Models\Compliance\Document\Audit as Template;
use App\Models\Staff\User\User;
use Illuminate\Database\Eloquent\Builder;

class UploadController extends Controller
{
    public function store(Request $request, $id)
    {
        ini_set('memory_limit', '-1');
        $files = $request->file('files');
        foreach ($files as $file) {
            $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
            $display_name = $file->getClientOriginalName();
            $folder = 'completed/audit-documents' . '/' . session('staff_id');
            $path = $folder . '/' . $filename;
            Storage::disk('s3')->put($path, (string) file_get_contents($file));
            $document = File::create([
                'staff_id' => session('staff_id'),
                'audit_id' => $id,
                'display_name' => $display_name,
                'filename' => basename($path),
                'url' => 'https://cavalry-compliance-documents.s3.eu-west-2.amazonaws.com/' . $path,
            ]);
        }
        return response()->json('success');
    }

    public function get_file($filename)
    {
        $audit_id = File::where('filename', $filename)->value('id');
        Viewer::create([
            'completed_audit_id' => $audit_id,
            'viewer_id' => session('staff_id'),
        ]);
        return Storage::disk('s3')->response('completed/audit-documents/' . session('staff_id') . '/' . $filename);
    }

    public function show(Request $request)
    {
        $user = User::where('id', session('staff_id'))->firstOrFail();
        if ((int) $user->compliance_manager === 1) {
            $filtered = $this->filter($request->filter);
            $files = $filtered->with('audits.completed_audits')->groupBy('id')->get();
        } else {
            $files = Group::with('audits.completed_audits')->get();
            // $files = Group::with('templates')->get();
        }
        return response()->json($files, 200);
    }

    public function filter($filter)
    {
        return new Group();
    }

    public function unique_clinical_staff()
    {
        $unique = File::whereNotNull('staff_id')->distinct()->pluck('staff_id');
        $clinical = User::whereIn('name', $unique)->select('id', 'name')->get();
        return response()->json($clinical, 200);
    }

    public function get_audit()
    {
        $audits = Template::all()->unique('display_name');
        return response()->json($audits, 200);
    }
}
