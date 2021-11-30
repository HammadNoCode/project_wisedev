<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['CareersCandidateCvParsingKey']], function () {
Route::post('/api/cdata', 'Staff\Recruitment\CareersDataController@postdata');
});
Route::group(['middleware' => ['staff-logged-out']], function () {
	// API
	Route::prefix('auth')->group(function () {
		Route::post('login', 'Staff\Auth\UserController@login');
		Route::post('register', 'Staff\Auth\UserController@register');
		Route::post('reset', 'Staff\Auth\UserController@passwordReset');
		Route::post('recover', 'Staff\Auth\UserController@validateRecovery');
		Route::patch('recover', 'Staff\Auth\UserController@updateRecovery');
	});
	// Vue
	Route::get('login', 'Staff\Auth\UserController@index');
	Route::get('register', 'Staff\Auth\UserController@index');
	Route::get('reset', 'Staff\Auth\UserController@index');
	Route::get('recover/{token}', 'Staff\Auth\UserController@index');
});

Route::group(['middleware' => ['staff-logged-in']], function () {
	Route::prefix('api')->group(function () {

		// api/user
		Route::prefix('user')->group(function () {
			Route::get('', 'Staff\Auth\UserController@show');
			// api/user/profile
			Route::prefix('settings')->group(function () {
				Route::patch('update', 'Staff\User\SettingsController@profile');
				Route::patch('password', 'Staff\User\SettingsController@password');
			});
		});

		// api/calls
		Route::prefix('call-schedule')->group(function () {
			Route::get('staff', 'Staff\StaffController@departmentStaff');
		});

		// api/logout
		Route::get('logout', 'Staff\Auth\UserController@logout');

		// api/auth
		Route::prefix('auth')->group(function () {
			Route::get('manager', 'Staff\Management\ManagementController@read_manager');
			Route::get('{department}', 'Staff\StaffController@auth');
		});

		// api/branch
		Route::prefix('branch')->group(function () {

			Route::prefix('reporting')->group(function () {
				Route::apiResource('report', 'Branch\ReportingController')->only(['store']);
				Route::get('pie_chart', 'Branch\ReportingController@pie_chart');
				Route::get('pipeline_hours', 'Branch\ReportingController@pipeline_hours');
			});
		});

		// api/recruitment
		Route::prefix('recruitment')->group(function () {

			// api/recruitment/applications
			Route::prefix('applications')->group(function () {
				Route::get('', 'Staff\Recruitment\ApplicationsController@index');
				Route::get('{id}', 'Staff\Recruitment\ApplicationsController@show');
				Route::post('create', 'Staff\Recruitment\ApplicationsController@create');
                Route::get('sub_status/{id}', 'Staff\Recruitment\ApplicationsController@sub_status');
                Route::get('sub_status_alph/{data}', 'Staff\Recruitment\ApplicationsController@sub_status_alph');

				Route::post('{id}', 'Staff\Recruitment\ApplicationsController@update');
                Route::post('resume/{id}', 'Staff\Recruitment\ApplicationsController@resume_upload');
				Route::delete('{id}', 'Staff\Recruitment\ApplicationsController@destroy');

				Route::patch('status/{id}', 'Staff\Recruitment\ApplicationsController@update_status');

				// api/recruitment/applications/about-me
				Route::prefix('about-me')->group(function () {
					Route::post('{id}', 'Staff\Recruitment\Application\ProfileController@store');
					Route::get('get/{id}', 'Staff\Recruitment\Application\ProfileController@show');
					Route::patch('{id}', 'Staff\Recruitment\Application\ProfileController@update');

					// api/recruitment/applications/about-me/upload
					Route::prefix('upload')->group(function () {
						Route::post('image/{id}', 'Staff\Recruitment\Application\UploadController@store');
						Route::get('get/{id}/{filename}', 'Staff\Recruitment\Application\UploadController@get_profile_picture');
						Route::get('picture/{id}', 'Staff\Recruitment\Application\UploadController@show_profile_picture');
						Route::delete('profile-picture/{id}', 'Staff\Recruitment\Application\UploadController@destroy');
					});
				});
			});

			// api/recruitment/employment
			Route::prefix('employment')->group(function () {
				Route::get('', 'Staff\Recruitment\Application\EmploymentController@index');
				Route::get('{id}', 'Staff\Recruitment\Application\EmploymentController@show');
				Route::patch('{id}', 'Staff\Recruitment\Application\EmploymentController@store');
			});

			// api/recruitment/notes
			Route::prefix('notes')->group(function () {
				Route::post('create/{id}', 'Staff\Recruitment\Application\NotesController@create_note');
				Route::get('read/{id}/', 'Staff\Recruitment\Application\NotesController@read_notes');
			});

			// api/recruitment/interviews
			Route::prefix('interviews')->group(function () {
				Route::get('', 'Staff\Recruitment\InterviewController@index');
				Route::get('active', 'Staff\Recruitment\InterviewController@activeInterviewers');
				Route::apiResource('invite', 'Staff\Recruitment\InterviewController')->only(['show']);
			});

			// api/recruitment/interviews
			Route::prefix('interviews')->group(function () {
				Route::get('all', 'Staff\Recruitment\InterviewsController@get_all_staff');
				Route::get('{id}', 'Staff\Recruitment\InterviewsController@show');
				Route::post('{id}', 'Staff\Recruitment\InterviewsController@store');
				Route::patch('{id}', 'Staff\Recruitment\InterviewsController@update');
				Route::patch('contacted/{id}', 'Staff\Recruitment\Interview\UpdateContactedController');
				Route::put('{id}', 'Staff\Recruitment\InterviewsController@remind');
				Route::delete('{id}', 'Staff\Recruitment\InterviewsController@destroy');

				// api/recruitment/interviews/update
				Route::prefix('update')->group(function () {
					Route::patch('{id}', 'Staff\Recruitment\InterviewsController@reschedule');
				});

				// api/recruitment/interviews/complete
				Route::prefix('complete')->group(function () {
					Route::patch('{id}', 'Staff\Recruitment\InterviewsController@completed');
				});

				// api/recruitment/interviews/success
				Route::prefix('success')->group(function () {
					Route::patch('{id}', 'Staff\Recruitment\InterviewsController@successful');
				});

				// api/recruitment/interviews/reject
				Route::prefix('reject')->group(function () {
					Route::patch('{id}', 'Staff\Recruitment\InterviewsController@reject');
				});

				Route::prefix('no-show')->group(function () {
					Route::patch('{id}', 'Staff\Recruitment\InterviewsController@noShow');
				});

				// api/recruitment/interviews/questionnaire
				Route::prefix('questionnaire')->group(function () {
					Route::get('{id}', 'Staff\Recruitment\Interview\QuestionnaireController@show');
					Route::post('{id}', 'Staff\Recruitment\Interview\QuestionnaireController@store');
					Route::patch('{id}', 'Staff\Recruitment\Interview\QuestionnaireController@update');
				});
			});

			// api/recruitment/reference
			Route::prefix('reference')->group(function () {
				Route::get('', 'Staff\Recruitment\ReferenceController@index');
				Route::apiResource('invites', 'Staff\Recruitment\ReferenceController');
				Route::post('invite/reminder/{id}', 'Staff\Recruitment\ReferenceController@reminder');
				Route::post('invite/request/{id}', 'Staff\Recruitment\ReferenceController@request');
			});

			// api/recruitment/conversion-tracker
			Route::prefix('conversion_tracker')->group(function () {
				Route::get('pie_chart', 'Staff\Recruitment\Conversion\DashboardController@applicationStatusTracker');

				Route::prefix('status')->group(function () {
					Route::get('live', 'Staff\Recruitment\Conversion\DashboardController@averageLiveApplicationConversionTracker');
					Route::get('accepted', 'Staff\Recruitment\Conversion\DashboardController@averageAcceptedApplicationConversionTracker');
				});
			});

			// api/recruitment/logs
			Route::prefix('logs')->group(function () {
				Route::get('{id}', 'Staff\Recruitment\LogsController@show');
			});

			// api/recruitment/compliance
			Route::prefix('compliance')->group(function () {
				Route::get('', 'Staff\Recruitment\Compliance\AppComplianceController@index');
				Route::get('{applicant}', 'Staff\Recruitment\Compliance\AppComplianceController@get_compliance_documents');
				Route::post('upload', 'Staff\Recruitment\Compliance\AppComplianceController@document_upload');
				Route::post('{id}/{applicant_id}', 'Staff\Recruitment\Compliance\AppComplianceController@store');
				Route::patch('{applicant_id}/{id}', 'Staff\Recruitment\Compliance\AppComplianceController@update');
				Route::delete('{applicant_id}/{id}', 'Staff\Recruitment\Compliance\AppComplianceController@destroy');

				// api/recruitment/compliance/training
				Route::prefix('training')->group(function () {
					Route::get('{applicant}', 'Staff\Recruitment\Compliance\AppComplianceController@get_compliance_training');
				});

				// api/recruitment/compliance/upload
				Route::prefix('upload')->group(function () {
					Route::get('get/{filename}', 'Staff\Recruitment\Compliance\UploadController@get_document');
					Route::get('document/{id}', 'Staff\Recruitment\Compliance\UploadController@show_documents');
					Route::get('training/{id}', 'Staff\Recruitment\Compliance\UploadController@show_training');
					Route::post('image/{id}/{document_id}', 'Staff\Recruitment\Compliance\UploadController@store');
					Route::delete('delete/{id}', 'Staff\Recruitment\Compliance\UploadController@destroy');
				});

				// api/recruitment/compliance/details
				Route::prefix('details')->group(function () {
					Route::get('docs/{id}', 'Staff\Recruitment\Compliance\DetailsController@getDocuments');
					Route::get('referees/{id}', 'Staff\Recruitment\Compliance\DetailsController@getReferees');
					Route::get('induction/{id}', 'Staff\Recruitment\Compliance\DetailsController@induction_attendance');
					Route::get('training/{id}', 'Staff\Recruitment\Compliance\DetailsController@training_attendance');
					Route::get('{applicant_id}/{id}', 'Staff\Recruitment\Compliance\DetailsController@show');
					Route::post('{applicant_id}/{id}', 'Staff\Recruitment\Compliance\DetailsController@store');
					Route::patch('update/{id}/{applicant_id}', 'Staff\Recruitment\Compliance\DetailsController@update');
				});

				// api/recruitment/compliance/renewals
				Route::get('renewals/{id}', 'Staff\Recruitment\Compliance\AppComplianceController@auto_fill_renewal');

				// api/recruitment/notes
				Route::prefix('notes')->group(function () {
					Route::post('create/{id}', 'Staff\Recruitment\Compliance\NotesController@create_note');
					Route::get('read/{id}/', 'Staff\Recruitment\Compliance\NotesController@read_notes');
				});
			});

			// api/recruitment/retrievals
			Route::prefix('retrievals')->group(function () {
				Route::get('', 'Staff\Recruitment\RetrievalsLogController@show');
			});

			// api/recruitment/pipeline
			Route::prefix('pipeline')->group(function () {
				Route::apiResource('applicant', 'Staff\Recruitment\PipelineController')->only(['index', 'update']);
				Route::get('stats', 'Staff\Recruitment\PipelineController@stats');
				Route::get('missing_compliance/{id}', 'Staff\Recruitment\PipelineController@getMissingCompliance');
			});

			// api/recruitment/enquiry-form
			Route::prefix('enquiry-form')->group(function () {
				Route::apiResource('invite', 'Staff\Recruitment\InitialEnquiry\InviteController')->only(['index', 'store']);

				// api/recruitment/enquiry-form/reporing
				Route::prefix('reporting')->group(function () {
					Route::get('conversion', 'Staff\Recruitment\InitialEnquiry\ReportsController@inviteConversionPieChart');
					Route::get('average-time', 'Staff\Recruitment\InitialEnquiry\ReportsController@conversionTimePieChart');
					Route::get('leaderboard', 'Staff\Recruitment\InitialEnquiry\ReportsController@referralLeaderboard');
				});

				// api/recruitment/enquiry-form/reporing
				Route::prefix('email')->group(function () {
					Route::post('reminder', 'Staff\Recruitment\InitialEnquiry\EmailController@email_all');
				});
			});

			// api/recruitment/mass-emails
			Route::prefix('mass-emails')->group(function () {
				Route::get('applications', 'Staff\Recruitment\MassEmailController@index');
				Route::post('send-mail', 'Staff\Recruitment\MassEmailController@sendMail');
			});
            // api/recruitment/mass-sms
            Route::prefix('mass-sms')->group(function () {
                Route::get('applications', 'Staff\Recruitment\MassSmsController@index');
                Route::post('send-sms', 'Staff\Recruitment\MassSmsController@sendSms');
            });
            // api/recruitment/communication
            Route::prefix('communication')->group(function () {
                Route::post('/get_dp', 'Staff\Recruitment\CommunicationController@get_dsecreption');
                Route::post('/sendMsg', 'Staff\Recruitment\CommunicationController@sendMsg');
                Route::get('/gt_temp', 'Staff\Recruitment\CommunicationController@get_template');

            });
            // api/recruitment/smstemplate
            Route::prefix('smstemplate')->group(function () {
                Route::delete('/dty/{id}', 'Staff\Recruitment\SmsTempController@destroy');
                Route::post('/actvtmp/{id}', 'Staff\Recruitment\SmsTempController@update');
                Route::get('/gettmp', 'Staff\Recruitment\SmsTempController@get_temp');
                Route::post('/createNtemp', 'Staff\Recruitment\SmsTempController@create_temp');
                Route::get('/getlog', 'Staff\Recruitment\SmsTempController@getlog');

            });
		});

		// api/covid
		Route::prefix('covid')->group(function () {

			// api/covid/test
			Route::prefix('test')->group(function () {
				Route::get('uploads', 'Covid\Results\ResultsController@index');
				Route::get('all/uploads', 'Covid\Results\ResultsController@show');
				Route::get('image/get/{id}/{filename}', 'Covid\Results\ResultsController@get_image');
				Route::post('reminder/{id}', 'Covid\Results\EmailController@covid_test_upload_reminder_manual');
			});

			// api/covid/vaccination
			Route::prefix('vaccination')->group(function () {
				Route::get('uploads', 'Covid\Vaccination\VaccinationController@index');
				Route::get('{id}', 'Covid\Vaccination\VaccinationController@show');
				Route::get('evidence/{id}/{filename}', 'Covid\Vaccination\VaccinationController@vaccinationEvidence');
			});
		});

		// api/compliance
		Route::prefix('compliance')->group(function () {

			Route::get('types', 'Staff\Compliance\CreateController@getTypes');

			// api/compliance/create
			Route::prefix('create')->group(function () {
				Route::get('', 'Staff\Compliance\CreateController@index');
				Route::post('{id}', 'Staff\Compliance\CreateController@store');
				Route::patch('update/{id}', 'Staff\Compliance\CreateController@update');
				Route::delete('{id}', 'Staff\Compliance\CreateController@destroy');
			});

			// api/compliance/matrix
			Route::prefix('matrix')->group(function () {
				Route::prefix('document')->group(function () {
					Route::get('documents', 'Staff\Compliance\MatrixController@get_documents');
					Route::get('', 'Staff\Compliance\MatrixController@show');
				});

				// api/compliance/training
				Route::prefix('training')->group(function () {
					Route::get('training', 'Staff\Compliance\MatrixController@get_training');
					Route::get('', 'Staff\Compliance\MatrixController@training_index');
				});
			});

			// api/compliance/tracker
			Route::prefix('tracker')->group(function () {
				Route::get('', 'Staff\Compliance\TrackerController@show');
				Route::get('names', 'Staff\Compliance\TrackerController@get_compliance_names');
			});
		});

		// api/compliance-staff
		Route::prefix('compliance-staff')->group(function () {

			Route::get('clinical', 'Compliance\CompletedAudit\UploadController@unique_clinical_staff');

			// api/compliance-staff/dashboard
			Route::prefix('dashboard')->group(function () {
				Route::get('clinical', 'Compliance\Dashboard\DashboardController@get_clinical_staff');
				Route::get('all', 'Compliance\Dashboard\DashboardController@all_audits');
				Route::prefix('{period}')->group(function () {
					Route::prefix('{filter}')->group(function () {
						Route::get('{query}', 'Compliance\Dashboard\DashboardController@get_query');
					});
				});

				// api/compliance-staff/dashboard/tracker
				Route::prefix('tracker')->group(function () {
					Route::get('', 'Compliance\Dashboard\TableController@show_tracker');
				});
			});

			// api/compliance-staff/procedure
			Route::prefix('procedure')->group(function () {

				// api/compliance-staff/procedure/upload
				Route::post('file', 'Compliance\ProceduresController@store');
				Route::get('get', 'Compliance\ProceduresController@show');
				Route::get('get/{filename}', 'Compliance\ProceduresController@get_procedure');
				Route::delete('{id}', 'Compliance\ProceduresController@destroy');
			});

			// api/compliance-staff/template
			Route::prefix('template')->group(function () {

				// api/compliance-staff/template/upload
				Route::prefix('upload')->group(function () {
					Route::post('image/{group}', 'Compliance\Templates\UploadController@store');
					Route::get('get/{filename}', 'Compliance\Templates\UploadController@get_template');
				});

				// api/compliance-staff/template/group
				Route::prefix('group')->group(function () {
					Route::post('', 'Compliance\Templates\GroupsController@store');
					Route::get('', 'Compliance\Templates\GroupsController@show');
					Route::get('get', 'Compliance\Templates\GroupsController@show_groups');
					Route::delete('{id}', 'Compliance\Templates\GroupsController@destroy');
					Route::delete('clear/{id}', 'Compliance\Templates\GroupsController@clear');
				});

				// api/compliance-staff/template/audit
				Route::prefix('audit')->group(function () {
					Route::delete('{id}', 'Compliance\Templates\AuditController@destroy');
				});
			});

			// api/compliance-staff/checkout
			Route::prefix('checkout')->group(function () {

				// api/compliance-staff/checkout/upload
				Route::prefix('upload')->group(function () {
					Route::post('file/{id}', 'Compliance\CompletedAudit\UploadController@store');
					Route::get('get/{filename}', 'Compliance\CompletedAudit\UploadController@get_file');
					Route::get('audits', 'Compliance\CompletedAudit\UploadController@get_audit');
				});

				// api/compliance-staff/checkout/viewers
				Route::prefix('viewers')->group(function () {
					Route::get('file/{id}', 'Compliance\CompletedAudit\ViewersController@show');
				});

				Route::get('', 'Compliance\CompletedAudit\UploadController@show');
				Route::get('files/{id}', 'Compliance\CompletedAudit\TableController@show');
				Route::patch('{id}', 'Compliance\CompletedAudit\TableController@update');
				Route::delete('file/{id}', 'Compliance\CompletedAudit\TableController@destroy');
			});
		});

		// api/clinical
		Route::prefix('clinical')->group(function () {
			Route::get('', 'Staff\Clinical\ClinicalStaffController@index');

			Route::get('{id}', 'Staff\Clinical\ClinicalStaffController@show');
			Route::patch('{id}', 'Staff\Clinical\ClinicalStaffController@update');
			Route::delete('{id}', 'Staff\Clinical\ClinicalStaffController@destroy');

			// api/clinical/compliance/
			Route::prefix('compliance')->group(function () {
				Route::get('{applicant}', 'Staff\Recruitment\Compliance\AppComplianceController@get_compliance_documents');
				Route::post('{id}/{applicant_id}', 'Staff\Recruitment\Compliance\AppComplianceController@store');
				Route::patch('{applicant_id}/{id}', 'Staff\Recruitment\Compliance\AppComplianceController@update');
				Route::delete('{applicant_id}/{id}', 'Staff\Recruitment\Compliance\AppComplianceController@destroy');
			});
		});

		// api/live-staff
		Route::prefix('live-staff')->group(function () {
			Route::get('name', 'Staff\LiveStaff\ProfileController@getStaff');
			Route::get('{id}', 'Staff\LiveStaff\ProfileController@document_data');
			Route::get('pdf/{id}', 'Staff\LiveStaff\ProfileController@create_pdf');
		});

		// api/events
		Route::prefix('events')->group(function () {

			// api/events/training
			Route::prefix('training')->group(function () {

				// api/events/training/booking
				Route::prefix('booking')->group(function () {
					Route::get('', 'Staff\Events\Training\EventsController@index');
					Route::get('{id}', 'Staff\Events\Training\EventsController@show');
					Route::post('create', 'Staff\Events\Training\EventsController@create');
					Route::patch('{id}', 'Staff\Events\Training\EventsController@update');
					Route::delete('{id}', 'Staff\Events\Training\EventsController@destroy');
				});

				// api/events/training/attendee
				Route::prefix('attendee')->group(function () {
					Route::get('applicant', 'Staff\Events\Training\AttendeeController@get_applicant');
					Route::get('staff', 'Staff\Events\Training\AttendeeController@get_staff');
					Route::get('', 'Staff\Events\Training\AttendeeController@index');
					Route::get('all/{id}/', 'Staff\Events\Induction\AttendeeController@show');
					Route::post('{id}', 'Staff\Events\Training\AttendeeController@store');
					Route::patch('{id}', 'Staff\Events\Training\AttendeeController@update');
					Route::delete('{id}', 'Staff\Events\Training\AttendeeController@destroy');

					Route::prefix('confirm')->group(function () {
						Route::patch('{id}', 'Staff\Events\Training\AttendeeController@confirmation');
					});
				});
			});

			// api/events/induction
			Route::prefix('induction')->group(function () {

				// api/events/induction/booking
				Route::prefix('booking')->group(function () {
					Route::get('', 'Staff\Events\Induction\EventsController@index');
					Route::get('{id}', 'Staff\Events\Induction\EventsController@show');
					Route::post('create', 'Staff\Events\Induction\EventsController@create');
					Route::patch('{id}', 'Staff\Events\Induction\EventsController@update');
					Route::delete('{id}', 'Staff\Events\Induction\EventsController@destroy');
				});

				// api/events/induction/attendee
				Route::prefix('attendee')->group(function () {
					Route::get('applicant', 'Staff\Events\Induction\AttendeeController@get_applicant');
					Route::get('staff', 'Staff\Events\Induction\AttendeeController@get_staff');
					Route::get('', 'Staff\Events\Induction\AttendeeController@index');
					Route::get('all/{id}', 'Staff\Events\Induction\AttendeeController@show');
					Route::post('{id}', 'Staff\Events\Induction\AttendeeController@store');
					Route::patch('{id}', 'Staff\Events\Induction\AttendeeController@update');
					Route::delete('{id}', 'Staff\Events\Induction\AttendeeController@destroy');

					// api/events/induction/confirm
					Route::prefix('confirm')->group(function () {
						Route::patch('{id}', 'Staff\Events\Training\AttendeeController@confirmation');
					});
				});
			});
		});

		Route::prefix('dashboard')->group(function () {

			// api/dashboard/overall
			Route::prefix('overall')->group(function () {
				Route::prefix('{table}')->group(function () {

					Route::prefix('{period}')->group(function () {
						Route::prefix('{filter}')->group(function () {
							Route::prefix('simple')->group(function () {
								Route::get('{query}', 'Staff\Dashboard\DashboardController@get_query');
							});
							Route::prefix('bar')->group(function () {
								Route::get('{query}', 'Staff\Dashboard\DashboardController@bar_chart_query');
							});
						});
						Route::prefix('pie')->group(function () {
							Route::get('{query}', 'Staff\Dashboard\DashboardController@pie_chart_query');
						});
						Route::prefix('stacked')->group(function () {
							Route::get('tracker', 'Staff\Dashboard\DashboardController@stacked_chart_query');
						});
					});
				});
			});

			// api/dashboard/live-staff/
			Route::prefix('live-staff')->group(function () {
				Route::prefix('{table}')->group(function () {
					Route::prefix('{filter}')->group(function () {
						Route::prefix('simple')->group(function () {
							Route::get('{query}', 'Staff\Clinical\DashboardController@get_query');
						});
					});
				});

				Route::get('bar', 'Staff\Clinical\DashboardController@bar_chart_query');
			});
		});

		// api/business
		Route::prefix('business')->group(function () {
			Route::get('organisations', 'Staff\Business\Client\ClientController@get_organisations');

			// api/business/client
			Route::prefix('client')->group(function () {
				Route::post('new', 'Staff\Business\Client\ClientController@store');
				Route::get('list/', 'Staff\Business\Client\ClientController@show');
				Route::delete('{id}', 'Staff\Business\Client\ClientController@destroy');

				// api/business/client/details
				Route::prefix('details')->group(function () {
					Route::get('{id}', 'Staff\Business\Client\DetailsController@show');
					Route::patch('{id}', 'Staff\Business\Client\DetailsController@update');
				});

				// api/business/client/contacts
				Route::prefix('contacts')->group(function () {
					Route::post('{id}', 'Staff\Business\Client\ContactController@store');
					Route::get('get/{id}', 'Staff\Business\Client\ContactController@show');
					Route::patch('update/{id}', 'Staff\Business\Client\ContactController@update');
					Route::delete('delete/{id}', 'Staff\Business\Client\ContactController@destroy');
				});

				// api/business/client/communication
				Route::prefix('communication')->group(function () {
					Route::post('{id}', 'Staff\Business\Client\CommunicationController@store');
					Route::get('get/{id}/', 'Staff\Business\Client\CommunicationController@show');
					Route::patch('update/{id}', 'Staff\Business\Client\CommunicationController@update');
					Route::delete('delete/{id}', 'Staff\Business\Client\CommunicationController@destroy');
				});

				// api/business/client/actions
				Route::prefix('actions')->group(function () {
					Route::post('{id}', 'Staff\Business\Client\ActionController@store');
					Route::get('get/{id}', 'Staff\Business\Client\ActionController@show');
					Route::patch('update/{id}', 'Staff\Business\Client\ActionController@update');
					Route::delete('delete/{id}', 'Staff\Business\Client\ActionController@destroy');
				});

				// api/business/client/hours
				Route::prefix('hours')->group(function () {
					Route::post('{id}', 'Staff\Business\Client\HoursController@store');
					Route::get('get/{id}/', 'Staff\Business\Client\HoursController@show');
					Route::patch('update/{id}', 'Staff\Business\Client\HoursController@update');
					Route::delete('delete/{id}', 'Staff\Business\Client\HoursController@destroy');
				});

				// api/business/client/dashboard
				Route::prefix('dashboard')->group(function () {
					Route::get('{id}/line', 'Staff\Business\Client\DashboardController@line_chart_query');
				});

				// api/business/client/notes
				Route::prefix('notes')->group(function () {
					Route::post('{id}', 'Staff\Business\Client\NotesController@store');
					Route::get('get/{id}/', 'Staff\Business\Client\NotesController@show');
					Route::delete('delete/{id}', 'Staff\Business\Client\NotesController@destroy');
				});
			});

			// api/business/organisation
			Route::prefix('organisation')->group(function () {
				Route::post('new', 'Staff\Business\Organisation\OrganisationController@store');
				Route::get('list/', 'Staff\Business\Organisation\OrganisationController@show');
			});
		});

		// api/management
		Route::prefix('management')->group(function () {

			// api/management/staff
                Route::prefix('staff')->group(function () {

				// api/management/staff/departments
				Route::prefix('departments')->group(function () {
					Route::get('', 'Staff\Management\Staff\UsersController@read_departments');
				});

				// api/management/staff/branches
				Route::prefix('branches')->group(function () {
					Route::get('', 'Staff\Management\Staff\UsersController@read_branches');
				});

				// api/management/staff/awaiting
				Route::prefix('awaiting')->group(function () {
					Route::get('', 'Staff\Management\Staff\UsersController@read_awaiting_activation');
					Route::patch('{id}', 'Staff\Management\Staff\UsersController@update_awaiting_activation');
					Route::delete('{id}', 'Staff\Management\Staff\UsersController@delete_awaiting_activation');
				});

				// api/management/staff/active
				Route::prefix('active')->group(function () {
                    Route::get('', 'Staff\Management\Staff\UsersController@read_active_users');
					Route::patch('{id}', 'Staff\Management\Staff\UsersController@update_active_users');
					Route::delete('{id}', 'Staff\Management\Staff\UsersController@delete_active_user');
				});
                    Route::prefix('access')->group(function () {
                        Route::get('get_all', 'Staff\Management\Staff\IpAccessController@all_user');
                        Route::post('create_authorise_ip', 'Staff\Management\Staff\IpAccessController@create_ip');
                        Route::post('get_all/ip_update/{id}', 'Staff\Management\Staff\IpAccessController@user_ip_update');
                        Route::delete('ip_delete/{id}', 'Staff\Management\Staff\IpAccessController@delete_user_ip');
                        Route::patch('ip_active/{id}', 'Staff\Management\Staff\IpAccessController@reset_user_ip');

                    });
				Route::get('login/{id}', 'Staff\Management\Staff\UsersController@login_as_user');
			});
		});

		// api/productivity
		Route::prefix('productivity')->group(function () {
			Route::prefix('tasks')->group(function () {
				Route::get('staff', 'Staff\Productivity\TaskController@show_staff');
				Route::get('{staff}', 'Staff\Productivity\TaskController@show_tasks');
				Route::post('', 'Staff\Productivity\TaskController@create_task');
				Route::patch('{id}', 'Staff\Productivity\TaskController@update_task');
				Route::delete('{id}', 'Staff\Productivity\TaskController@delete_task');
			});
		});

		// api/pulse-records
		Route::prefix('pulse-records')->group(function () {
			Route::get('', 'Pulse\StaffController@show');
			Route::delete('{id}', 'Pulse\StaffController@destroy');
		});

		// Complex care
		Route::prefix('complex-care')->group(function () {
			Route::post('submit', 'ComplexCare\PostController');
			Route::get('read', 'ComplexCare\ReadController@show');
			Route::get('pdf/{staffname}/{filename}', 'ComplexCare\ReadController@get_form');
		});

		// IT support form
		Route::prefix('contact')->group(function () {
			Route::prefix('support')->group(function () {
				Route::post('submit', 'ITSupport\ContactController@store');
                Route::post('cv_parse', 'ITSupport\ContactController@cv_parse');
			});
		});

		// api/carehome
		Route::prefix('carehome')->group(function () {

			Route::get('ratings', 'CQC\Carehome\GetRatingsController');
			Route::apiResource('detail', 'CQC\CarehomeController')->only(['index', 'show', 'update']);
			Route::apiResource('agency', 'CQC\Carehome\AgencyController')->only(['show', 'store', 'update', 'destroy']);

			// api/carehome/contacts
			Route::prefix('contacts')->group(function () {
				Route::get('{id}', 'CQC\Carehome\ContactsController@index');
			});

			// api/carehome/key-contacts
			Route::prefix('key-contacts')->group(function () {
				Route::post('{id}', 'CQC\Carehome\KeyContactsController@store');
				Route::get('{id}', 'CQC\Carehome\KeyContactsController@index');
			});

			// api/carehome/notes
			Route::prefix('notes')->group(function () {
				Route::post('{id}', 'CQC\Carehome\NotesController@store');
				Route::get('{id}', 'CQC\Carehome\NotesController@index');
				Route::delete('{id}', 'CQC\Carehome\NotesController@soft_destroy');
			});

			// api/carehome/call-history
			Route::prefix('call-history')->group(function () {
				Route::post('{id}', 'CQC\Carehome\CallHistoryController@store');
				Route::get('{id}', 'CQC\Carehome\CallHistoryController@index');
				Route::patch('update/{id}', 'CQC\Carehome\CallHistoryController@update');
			});

			// api/carehome/onboarding
			Route::prefix('onboarding')->group(function () {
				Route::get('stages/{id}', 'CQC\Carehome\OnboardingController@index');
				Route::post('{id}/{stage}', 'CQC\Carehome\OnboardingController@store');
				Route::delete('{id}/{stage}', 'CQC\Carehome\OnboardingController@destroy');
			});

			// api/carehome/dashboard
			Route::prefix('dashboard')->group(function () {
				Route::get('pie', 'CQC\Dashboard\PieController@pie_chart_query');

				Route::prefix('stats')->group(function () {
					Route::get('visits', 'CQC\Dashboard\StatsController@carehome_visits_leaderboard');
					Route::get('merchandise', 'CQC\Dashboard\StatsController@carehome_merchandise_leaderboard');
					Route::get('calls', 'CQC\Dashboard\StatsController@carehome_phonecall_leaderboard');
				});
			});
		});

		// api/map
		Route::prefix('map')->group(function () {
			Route::get('applicant', 'GoogleMap\MarkerController@getApplicantCoordinates');
			Route::get('carehome', 'GoogleMap\MarkerController@getCarehomeCoordinates');
		});


		// Staff-onboarding
		Route::post('staff-onboarding', 'StaffOnboarding\PostController');
		Route::post('staff-offboarding', 'StaffOffboarding\PostController');


		// single action controllers
		Route::get('staff', 'Staff\GetStaffController');
		Route::get('{id}/contacts', 'Staff\GetContactsController');
		Route::get('branches', 'Staff\GetBranchesController');
		Route::get('portal-staff', 'Staff\GetPortalStaffController');
		Route::get('pulse-staff', 'Staff\GetPulseStaffController');



	});


	Route::get('/{view}', 'Staff\StaffController@show')->where('view', '.*');
	Route::get('/', 'Staff\StaffController@show');

});



