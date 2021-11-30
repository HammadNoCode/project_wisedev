<?php

namespace App\Http\Controllers\Compliance;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Compliance\Procedures;

class ProceduresController extends Controller
{
    public function store(Request $request)
    {
        ini_set('memory_limit', '-1');
        $file = $request->file('files')[0];
        $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
        $display_name = $file->getClientOriginalName();
        $folder = 'audit/procedures';
        $path = $folder . '/' . $filename;
        Storage::disk('s3')->put($path, (string) file_get_contents($file));
        $template = Procedures::create([
            'display_name' => $display_name,
            'filename' => basename($path),
            'url' => 'https://cavalry-compliance-documents.s3.eu-west-2.amazonaws.com/' . $path,
        ]);
        return response()->json('success');
    }

    public function get_procedure($filename)
    {
        return Storage::disk('s3')->response('audit/procedures/' . $filename);
    }

    public function show()
    {
        return Procedures::where('deleted', 0)->get();
    }

    public function destroy($id)
    {
        Procedures::where('id', $id)->update(['deleted' => 1]);
        return response()->json([
            'message' => 'Audit soft deleted'
        ], 200);
    }
}
