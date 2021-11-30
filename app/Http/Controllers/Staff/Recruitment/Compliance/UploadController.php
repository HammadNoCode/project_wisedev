<?php

namespace App\Http\Controllers\Staff\Recruitment\Compliance;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Staff\Recruitment\{DocumentCompliance as ComplianceDoc};
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    /**
     * Store compliance image uploads to s3 bucket
     *
     * @param Request $request
     * @param int $id
     * @param int $document_id
     * @return void
     */
    public function store(Request $request, $id, $document_id)
    {
        ini_set('memory_limit', '-1');
        $request->validate([
            'files.*' => 'required|mimes:jpeg,bmp,png,gif,svg,pdf,docx',
        ]);
        $files = $request->file('files');
        if(!empty($files)) {
            foreach ($files as $file) {
                $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
                $image_full_name = $filename;
                $upload_path = 'public/attachment/app_comp_files/';
                $image_url = $upload_path . $image_full_name;
                $file->move($upload_path, $image_full_name);
                $image[] = $image_url;
                $image = ComplianceDoc::create([
                    'applicant_id' => $id,
                    'document_id' => $document_id,
                    'filename' => basename($image_full_name),
                    'url' => implode('/', $image),
                ]);
            }
            return response()->json([
                'message' => 'The document has been uploaded'
            ], 200);
        }else{

            return response()->json([
                'message' => 'Please select files to upload'
            ], 401);
        }








      //  foreach ($files as $file) {
      //      $filename = Str::random(32) . '.' . $file->getClientOriginalExtension();
      //      $folder = 'document';
      //      $path = $folder . '/' . $filename;
      //      Storage::disk('s3')->put($path, (string) file_get_contents($file));
      //      $image = ComplianceDoc::create([
      //          'applicant_id' => $id,
      //          'document_id' => $document_id,
      //          'filename' => basename($path),
      //          'url' => 'https://cavalry-compliance-documents.s3.eu-west-2.amazonaws.com/' . $path,
      //      ]);
      //  }
      //  return response()->json('success');
    }

    /**
     * Retrieve compliance uploads from s3
     *
     * @param string $filename
     * @return void
     */
    public function get_document($filename)
    {
        return Storage::disk('s3')->response('document/' . $filename);
    }

    /**
     * Show uploaded compliance proof
     *
     * @param Request $request
     * @param int $applicant_id
     * @return void
     */
    public function show_documents(Request $request, $applicant_id)
    {
        $files = ComplianceDoc::whereNotNull('applicant_id')->where('applicant_id', $applicant_id)->whereHas('document', function ($query) {
            $query->whereType(1);
        })
            ->select('*', 'document_id as name')
            ->orderBy('document_id', 'asc')
            ->get();

        return response($files, 201);
    }

    /**
     * Show uploaded compliance proof
     *
     * @param Request $request
     * @param int $applicant_id
     * @return void
     */
    public function show_training(Request $request, $applicant_id)
    {
        $files = ComplianceDoc::whereNotNull('applicant_id')->where('applicant_id', $applicant_id)->whereHas('document', function ($query) {
            $query->whereType(2);
        })
            ->select('*', 'document_id as name')
            ->orderBy('document_id', 'asc')
            ->get();

        return response($files, 201);
    }

    /**
     * Destroy upload files function
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        ComplianceDoc::where('id', $id)->delete();
        return response()->json(['message' => 'Compliance item file deleted'], 200);
    }
}
