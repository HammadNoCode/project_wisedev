<?php

namespace App\Http\Controllers\StaffOnboarding;

use App\Http\Controllers\Controller;
use App\Models\Staff\Onboarding;
use App\Models\Staff\Onboarding\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Image;

class PostController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        foreach ($request->file('images') as $index => $image) {
            if (array_key_exists($index, $request->file('images'))) {
                $image = $image['file'];
                $fileName = str_replace(' ', '-', $request->full_name) . "-" . $index . "." . $image->getClientOriginalExtension();
                $img = Image::make($image->getRealPath());
                $img->resize(750, 750, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->stream();
                Storage::disk('local')->put('images/onboarding/national-id-card/' . str_replace(' ', '-', $request->full_name) . '/' . $fileName, $img, 'public');
            }
        }

        Mail::send('mail.staffOnboarding.email', ['data' => $request->all()], function ($message) use ($request) {
            $message->to('isaac@warrantywise.co.uk')->subject('Onboarding');

            $imageOne = storage_path('app/images/onboarding/national-id-card/' . str_replace(' ', '-', $request->full_name) . '/' . str_replace(' ', '-', $request->full_name) . "-0.png");
            $imageTwo = storage_path('app/images/onboarding/national-id-card/' . str_replace(' ', '-', $request->full_name) . '/' . str_replace(' ', '-', $request->full_name) . "-1.png");

            $message->attach($imageOne);
            $message->attach($imageTwo);
        });

        $onboarding = (new Onboarding())->createOnboarding($request->all());

        foreach ($request->file('images') as $index => $image) {
            $document = (new Document())->createDocument($onboarding->id, $image['file']->getClientOriginalName());
        }

        return response()->json(
            ['message' => 'success'],
            200
        );
    }
}
