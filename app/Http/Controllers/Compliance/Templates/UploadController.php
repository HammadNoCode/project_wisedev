<?php

namespace App\Http\Controllers\Compliance\Templates;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Compliance\Document\Audit;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{

    public function store(Request $request, $group)
    {
        ini_set('memory_limit', '-1');
        $file = $request->file('files')[0];
        $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
        $display_name = $file->getClientOriginalName();
        $folder = 'audit/templates';
        $path = $folder . '/' . $filename;
        Storage::disk('s3')->put($path, (string) file_get_contents($file));
        $template = Audit::create([
            'group_id' => $group,
            'display_name' => $display_name,
            'filename' => basename($path),
            'url' => 'https://cavalry-compliance-documents.s3.eu-west-2.amazonaws.com/' . $path,
            'weight' => $request->weight,
            'max_score' => $request->max_score,
        ]);
        return response()->json('success');
    }

    public function get_template($filename)
    {
        return Storage::disk('s3')->response('audit/templates/' . $filename);
    }
}
