<?php

namespace App\Http\Controllers\ComplexCare;

use App\Http\Controllers\Controller;
use App\Http\Requests\ComplexCare\PostRequest;
use App\Models\ComplexCare\Competency;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    const LIVE = false;
    const TEST_EMAIL = 'isaac@warrantywise.co.uk';
    const EMAILS = [
        'isaac@warrantywise.co.uk',
        'tuvysiv@mailinator.com',
        'riqa@mailinator.com',
    ];

    public function __invoke(PostRequest $request)
    {
        $form = $request->all();
        ini_set('memory_limit', '-1');
        $uploads = $request->file('files');
        foreach ($uploads as $upload) {
            $filename = Str::random(32) . '.pdf';
            $displayname = preg_replace('/\\.[^.\\s]{3,4}$/', '', $upload->getClientOriginalName());
            $folder = 'Complex-care';
            $subFolder = 'Competencies';
            $path = $folder . '/' . $subFolder . '/' . $request->staff . '/' . $filename;
            Storage::disk('s3Competence')->put($path, (string) file_get_contents($upload));
            $document = (new Competency)->createCompetencyRecord($request, $displayname, $filename, $path);
            $mail = [
                'staff' => $request->staff,
                'nurse' => $request->nurse
            ];
            Mail::send('mail.complexcare.competency', ['form' => $form], function ($message) use ($mail) {
                $message->to(self::EMAILS)->subject('Competency Form Uploaded');
            });
        }
        return response()->json([
            'message' => 'Competency sign off upload successful'
        ], 201);
    }
}
