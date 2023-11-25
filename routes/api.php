<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api']], function () {
    Route::post('login', [API\AuthController::class, 'login']);
    Route::post('login/updateUid', [API\AuthController::class, 'updateUid']);
    Route::post('logout', [API\AuthController::class, 'logout']);
    Route::post('/login/google', [API\AuthController::class, 'redirect']);
    Route::get('/callback', [API\AuthController::class, 'callback']);
    Route::get('confirm_account/{token}', [API\AuthController::class, 'confirm_account']);
    Route::get('get_reset_token/{token}', [API\AuthController::class, 'get_reset_token']);
    Route::post('reset_password', [API\AuthController::class, 'reset_password']);
    Route::post('register', [API\AuthController::class, 'register']);

    //Route::post('refresh-token', 'Api\AuthController@refreshToken');
    Route::post('forgot_password', [API\AuthController::class, 'forgot_password']);
    Route::post('account/settings', [API\AuthController::class, 'update_records']);
    Route::post('account/change_password', [API\AuthController::class, 'change_password']);

    Route::post('current_user', [API\AuthController::class, 'get_user']);
    Route::post('current_admin', [API\AuthController::class, 'get_admin']);
    Route::post('current_school/{school_id}', [API\AuthController::class, 'get_school']);

    Route::post('contacts', [API\ContactusController::class, 'contacts']);
    Route::get('contacts/messages', [API\ContactusController::class, 'get_messages']);    
 
    Route::post('classroom', [API\ClassroomController::class, 'store']);
    Route::get('classroom/{school_id}', [API\ClassroomController::class, 'index']);
    Route::get('classteacher/{school_id}', [API\ClassroomController::class, 'getClassTeacher']);
    Route::get('classteacher/{school_id}/{class_id}', [API\ClassroomController::class, 'getClassTeacherByClass']);
    Route::get('classrooms/getNoOfStudents/{school_id}', [API\ClassroomController::class, 'getNoOfStudents']);
    Route::post('classroom/designate_class_teacher', [API\ClassroomController::class, 'designate_class_teacher']);
    Route::post('classroom/update/{school_id}', [API\ClassroomController::class, 'update']);
    Route::post('classroom/destroy/{school_id}', [API\ClassroomController::class, 'destroy']);




Route::post('course', [API\CoursesController::class, 'store']);
Route::get('course/{school_id}', [API\CoursesController::class, 'index']);
Route::get('course/{school_id}/{class_id}', [API\CoursesController::class, 'index']);
Route::post('course/update/{school_id}', [API\CoursesController::class, 'update']);
Route::post('course/search/{school_id}', [API\CoursesController::class, 'search']);
Route::post('course/destroy/{school_id}', [API\CoursesController::class, 'destroy']);

Route::post('users', [API\UsersController::class, 'store']);
Route::get('users/{school_id}', [API\UsersController::class, 'index']);
Route::post('users/{school_id}/importcsv', [API\UsersController::class, 'uploaduserscsv']);

Route::post('designated_teachers', [API\DesignatedTeachersController::class, 'store']);
Route::get('designated_teachers/{school_id}', [API\DesignatedTeachersController::class, 'index']);
Route::get('designated_teachers/{school_id}/{teacher_id}', [API\DesignatedTeachersController::class, 'class_room']);
Route::get('designated_teachers/{school_id}/{teacher_id}/{class_id}', [API\DesignatedTeachersController::class, 'courses']);
Route::get('designated_teachers/get/teachers/{school_id}/{class_id}', [API\DesignatedTeachersController::class, 'get_teachers']);
Route::post('change_teacher/{school_id}/{class_id}', [API\DesignatedTeachersController::class, 'update']);

Route::post('students', [API\StudentsController::class, 'store']);
Route::post('students/update', [API\StudentsController::class, 'update']);
Route::post('students/{school_id}/{class_id}/importcsv', [API\StudentsController::class, 'uploadstudentscsv']);
Route::get('students/{school_id}', [API\StudentsController::class, 'index']);
Route::get('student/{student_id}', [API\StudentsController::class, 'index']);
Route::get('students/{school_id}/{class_id}', [API\StudentsController::class, 'index']);
Route::get('students/{school_id}/{class_id}/{student_id}', [API\StudentsController::class, 'index']);
Route::post('students/delete/{student_id}', [API\StudentsController::class, 'destroy']);
Route::post('students/search', [API\StudentsController::class, 'search']);
Route::post('student/move', [API\StudentsController::class, 'move_students']);

Route::post('marks', [API\MarksController::class, 'store']);
Route::post('marks/update', [API\MarksController::class, 'update']);
Route::get('marks/{school_id}', [API\MarksController::class, 'index']);
Route::get('marks/{school_id}/{class_id}/{course_id}', [API\MarksController::class, 'index']);
Route::get('report_form/{school_id}/{class_id}', [API\MarksController::class, 'report_form']);
Route::post('report_form_search/{school_id}/{class_id}', [API\MarksController::class, 'report_form_search']);
Route::get('marks/{school_id}/{class_id}/{course_id}/{student_id}', [API\MarksController::class, 'index']);
Route::get('get_marks/all_classes/{school_id}/{class_id}', [API\MarksController::class, 'all_class']);
Route::get('assessment/{school_id}/{class_id}', [API\MarksController::class, 'marks_assessment']);
Route::post('marks/search', [API\MarksController::class, 'search']);
Route::post('marks/update', [API\MarksController::class, 'update']);
Route::post('marks/average/', [API\MarksController::class, 'display_average']);

Route::get('out_of_marks/{school_id}/{class_id}/{course_id}', [API\OutOfMarksController::class, 'index']);
Route::get('out_of_marks/{school_id}/{class_id}', [API\OutOfMarksController::class, 'index']);
Route::post('out_of_marks', [API\OutOfMarksController::class, 'store']);
Route::post('out_of_marks/convert', [API\OutOfMarksController::class, 'convert']);

Route::post('discipline', [API\DisciplineController::class, 'store']);
Route::post('discipline/update', [API\DisciplineController::class, 'update']);
Route::post('discipline/bulk_edit', [API\DisciplineController::class, 'update_selected']);
Route::get('discipline/{school_id}', [API\DisciplineController::class, 'index']);
Route::get('discipline/{school_id}/{class_id}', [API\DisciplineController::class, 'index']);
Route::get('discipline/{school_id}/{class_id}/{student_id}', [API\DisciplineController::class, 'index']);
Route::post('discipline/search', [API\DisciplineController::class, 'search']);

Route::post('schoolfees', [API\SchoolfeesController::class, 'store']);
Route::post('schoolfees/update', [API\SchoolfeesController::class, 'update']);
Route::get('schoolfees/{school_id}', [API\SchoolfeesController::class, 'index']);
Route::get('schoolfees/{school_id}/{class_id}', [API\SchoolfeesController::class, 'index']);
Route::get('schoolfees/{school_id}/{class_id}/{student_id}', [API\SchoolfeesController::class, 'index']);
Route::post('schoolfees/search', [API\SchoolfeesController::class, 'search']);
Route::post('schoolfees/bank_slip/upload', [API\SchoolfeesController::class, 'upload_bank_slip']);
   

Route::get('schoolfees/bank/slip/get/{class_id}/{student_id}', [API\SchoolfeesController::class, 'get_bank_slips']);
Route::post('schoolfees/bank/slip/search/{school_id}', [API\SchoolfeesController::class, 'search_bank_slips']);
Route::post('schoolfees/bank/slip/delete/{id}', [API\SchoolfeesController::class, 'delete_bank_slips']);
Route::get('schoolfees/bank/slip/seen/{school_id}/{id}', [API\SchoolfeesController::class, 'mark_as_seen']);
Route::post('user_roles', [API\user_roles_controller::class, 'store']);
Route::get('user_roles/{school_id}', [API\user_roles_controller::class, 'index']);
Route::get('user_roles/{school_id}/{account_id}', [API\user_roles_controller::class, 'show']);
Route::get('user_roles/{school_id}/{account_id}/{user_role}', [API\user_roles_controller::class, 'show']);

Route::get('academic_year', [API\AcademicYearController::class, 'index']);


Route::post('school/settings', [API\SchoolController::class, 'update']);
Route::get('school/null', [API\SchoolController::class, 'index']);
Route::post('delete/user', [API\UsersController::class, 'destroy']);



Route::get('authentication/{school_id}', [API\AuthenticationsController::class, 'index']);
Route::get('authentication/null/{account_id}', [API\AuthenticationsController::class, 'index']);
Route::post('authentication/update/{school_id}', [API\AuthenticationsController::class, 'update']);
Route::post('authentication/search/{school_id}', [API\AuthenticationsController::class, 'search']);


Route::get('verification/{account_id}/{verification_code}', [API\VerificationController::class, 'index']);
Route::post('verification_code/resend/{account_id}', [API\VerificationController::class, 'resend']);
Route::post('sms/send/single/{school_id}/{class_id}', [API\SMSController::class, 'send_single_sms']);
Route::post('change_school/{school_id}', [API\UsersController::class, 'change_school']);

Route::get('designated_parent', [API\DesignatedParentsController::class, 'index']);

Route::get('user/tracker/', [API\UserTrackersController::class, 'index']);
Route::post('user/tracker/', [API\UserTrackersController::class, 'store']);
Route::get('user/tracker/ip_address', [API\UserTrackersController::class, 'IpAddr']);
Route::get('user/tracker/active', [API\UserTrackersController::class, 'inactive_users']);

Route::get('license/{school_id}/', [API\LicenseKeyController::class, 'index']);
Route::get('license/request/{school_id}', [API\LicenseKeyController::class, 'get_license_requests']);
Route::get('license/key/delete/{request_id}', [API\LicenseKeyController::class, 'delete_license_key']);
Route::post('license/activate/license', [API\LicenseKeyController::class, 'activate_license_key']);
Route::post('license/request/', [API\LicenseKeyController::class, 'store_license_requests']);
Route::post('license', [API\LicenseKeyController::class, 'store']);

Route::get('sms/request/{school_id}', [API\LicenseKeyController::class, 'get_sms_requests']);
Route::post('sms/request/', [API\LicenseKeyController::class, 'store_sms_requests']);
Route::get('sms/request/delete/{request_id}', [API\LicenseKeyController::class, 'delete_sms']);
Route::post('sms/activate', [API\LicenseKeyController::class, 'activate_sms']);

Route::get('statistics/schoolfees/{school_id}', [API\SchoolStatisticsController::class, 'schoolfees_statistics']);
Route::get('statistics/marks/{school_id}', [API\SchoolStatisticsController::class, 'marks_statistics']);
Route::get('statistics/students/{school_id}', [API\SchoolStatisticsController::class, 'students_statistics']);
Route::get('statistics/dashboard/{school_id}', [API\SchoolStatisticsController::class, 'dashboardStatistics']);


Route::get('file_manager/', [API\FileManagersController::class, 'index']);
Route::post('file_manager/', [API\FileManagersController::class, 'store']);
Route::post('file_manager/search/', [API\FileManagersController::class, 'search_records']);
Route::get('file_manager/delete/{file_id}', [API\FileManagersController::class, 'destroy']);

Route::get('registration/request/{id}', [API\SchoolRegistrationRequestsController::class, 'index']);
Route::post('registration/request/send', [API\SchoolRegistrationRequestsController::class, 'store']);
Route::post('registration/request/accept/{id}', [API\SchoolRegistrationRequestsController::class, 'update']);
Route::get('registration/request/{request_id}/delete', [API\SchoolRegistrationRequestsController::class, 'destroy']);

Route::post('student/attendances', [API\StudentAttendancesController::class, 'store']);
Route::post('student/attendances/import', [API\StudentAttendancesController::class, 'import_students']);
Route::get('daily/attendance/{school_id}/{class_id}', [API\StudentAttendancesController::class, 'attendance_daily_statistics']);
Route::get('student/attendances/{school_id}/{class_id}', [API\StudentAttendancesController::class, 'index']);

Route::post('privacy', [API\PrivacyController::class, 'store']);
Route::get('privacy', [API\PrivacyController::class, 'index']);
Route::get('privacy/{id}', [API\PrivacyController::class, 'show']);
Route::post('privacy/{id}', [API\PrivacyController::class, 'update']);

Route::post('pointsRanges/get', [API\PointsRangesController::class, 'index']);
Route::post('pointsRanges/post', [API\PointsRangesController::class, 'store']);
Route::post('pointsRanges/update', [API\PointsRangesController::class, 'update']);
Route::post('pointsRanges/delete', [API\PointsRangesController::class, 'destroy']);

Route::post('/scs/create_folder', [API\ScsController::class, 'create_folder']);
Route::post('/scs/download_file/{school_id}', [API\ScsController::class, 'download']);
Route::get('/scs/get_files_folders/{school_id}/{file_hierarchy}', [API\ScsController::class, 'index']);
Route::get('/scs/get_files_byId/{school_id}/{folder_file_id}', [API\ScsController::class, 'getFileById']);
Route::post('/scs/get_files_byId/{school_id}/{folder_file_id}/rename', [API\ScsController::class, 'update']);
Route::post('/scs/get_files_byId/{school_id}/{folder_file_id}/delete', [API\ScsController::class, 'destroy']);
Route::post('/scs/get_files_folders/{school_id}/{file_hierarchy}/upload', [API\ScsController::class, 'upload_to_AWS']);
Route::get('/scs/get_files/{school_id}/all', [API\ScsController::class, 'get_all']);
Route::post('/scs/search_files/{school_id}', [API\ScsController::class, 'search_files']);


Route::post('donating/mobile_money', [API\AuthController::class, 'donating_by_mobile_money']);
Route::post('sms_transaction/approve/{transaction_id}', [API\AuthController::class, 'approve_transaction']);

});




