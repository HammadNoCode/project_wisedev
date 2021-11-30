<?php


namespace App\Traits\ExternalCareerPageApi;
use Illuminate\Support\Facades\Validator;
use App\Models\Staff\Recruitment\Application;


class ExternalCareerPageApiCvKey
{

    public function data($request){

        ini_set('memory_limit', '-1');
                 $files = $request->file('file');
                     $v = Validator::make($request->all(), [
                         'file' => 'sometimes|required|mimes:pdf,docx,doc',
                     ]);
                     if ($v->fails()) {

                         return response()->json(['message' => 'The please upload pdf or docx file'], 401);
                     }
                     $filename = 'resume' . '.' . $files->getClientOriginalExtension();
                     $image_full_name = $filename;
                     $upload_path = 'public/attachment/app_resume/';
                     $image_url = $upload_path . $image_full_name;
                     $files->move($upload_path, $image_full_name);
                     $new_candidate = new Application();
                     $new_candidate->first_name = $request->name;
                     $new_candidate->email = $request->email;
                     $new_candidate->mobile = $request->phone;
                     $new_candidate->resume_url = $image_url;
                     $new_candidate->test = '1';
                     $new_candidate->save();




    }

    public function cv_parsing($request){


        $files = $request->file('file');
            $filepath = $files;
            $handle = fopen($filepath, "r");
            $contents = fread($handle, filesize($filepath));
            fclose($handle);
            $modifiedDate = date("Y-m-d", filemtime($filepath));
            $base64str = base64_encode($contents);
            $data = ["DocumentAsBase64String" => $base64str, "DocumentLastModified" => $modifiedDate];
            $url = "https://au-rest.resumeparsing.com/v10/parser/resume";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

            $headers = [
                "accept: application/json",
                "content-type: application/json; charset=utf-8",
                "sovren-accountid: 98752817",
                "sovren-servicekey: lYNjciuLg4ntv/Z5sICXpVMNrj0BdxokKZGGb5S9"
            ];
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($curl);
            curl_close($curl);
            $dr = json_decode($result, TRUE);

            foreach ($dr as $c_t) {
                $detail_contect_info = $c_t;
            }
            foreach ($detail_contect_info['ResumeData']['ContactInformation']['Telephones'] as $contact_info) {
                $contact = $contact_info;
            }
            foreach ($detail_contect_info['ResumeData']['ContactInformation']['EmailAddresses'] as $email_info) {
                $email = $email_info;
            }
             $candidate_address = array();
             foreach($detail_contect_info['ResumeData']['ContactInformation']['Location'] as $current_location){
                 $candidate_addres = $current_location;
             }
            $name = $detail_contect_info['ResumeData']['ContactInformation']['CandidateName']['FormattedName'];
            $email = $email;
            $contact_info = $contact['Raw'];
            $new_ip = new Application();
            $new_ip->first_name = $name;
            $new_ip->email = $request->email;
            $new_ip->mobile = $contact_info;
            $new_ip->test = '1';
            $new_ip->save();





    }
}
