<?php

namespace App\Http\Controllers\Staff\Recruitment\Application;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{Validator, Mail, Storage};
use App\Http\Controllers\Controller;
use App\Models\Staff\Recruitment\Application\Upload;

class UploadController extends Controller
{
    /**
     * Store uploads to s3 bucket
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function store(Request $request, $id)
    {
        ini_set('memory_limit', '-1');
        $files = $request->file('files');
        foreach ($files as $file) {
            $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
            $display_name = $file->getClientOriginalName();
            $folder = 'applicant/profile-picture' . '/' . $id;
            $path = $folder . '/' . $filename;
            Storage::disk('s3')->put($path, (string) file_get_contents($file));
            $image = Upload::create([
                'applicant_id' => $id,
                'display_name' => $display_name,
                'filename' => basename($path),
                'url' => 'https://cavalry-compliance-documents.s3.eu-west-2.amazonaws.com/' . $path,
            ]);
        }
        return response()->json('Successfully uploaded');
    }

    /**
     * Retrieve uploaded files from s3
     *
     * @param int $id
     * @param string $filename
     * @return void
     */
    public function get_profile_picture($id, $filename)
    {
        return Storage::disk('s3')->response('applicant/profile-picture/' . $id . '/' . $filename);
    }

    /**
     * show profile pictures
     *
     * @param int $id
     * @return void
     */
    public function show_profile_picture($id)
    {
        $image = Upload::where('applicant_id', $id)->get();
        return response()->json($image, 200);
    }

    /**
     * Destroy record function
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $filename = Upload::where('id', $id)->pluck('filename');
        $picture_id = Upload::where('id', $id)->pluck('id');
        Storage::disk('s3')->delete('applicant/profile-picture/' . $picture_id . '/' . $filename);
        Upload::where('id', $id)->delete();
        return response()->json([
            'message' => 'Profile picture deleted'
        ], 200);
    }
}
