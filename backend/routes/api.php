<?php

use App\Http\Controllers\AnnouncementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\Archive;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\RoleDepController;
use App\Http\Controllers\ViewPDF;
use App\Http\Controllers\WorkInstructionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Protected routes (authentication required)
Route::middleware('auth.sanctum')->group(function () {

    // Add department
    Route::post('/department', [DepartmentController::class, 'addDepartment']);

    // Add announcement
    Route::post('/announcement', [AnnouncementController::class, 'addAnnouncement']);

    // Policies
    Route::post('/upload-policy', [PolicyController::class, 'uploadPolicy']);
    Route::get('/retrieve-policies', [PolicyController::class, 'getPolicies']);

    // Procedures
    Route::post('/upload-procedure', [ProcedureController::class, 'uploadProcedure']);
    Route::get('/retrieve-procedures', [ProcedureController::class, 'getProcedure']);

    //Work Instructions
    Route::post('/upload-work', [WorkInstructionsController::class, 'uploadWorkInstructions']);
    Route::get('/retrieve-instructions', [WorkInstructionsController::class, 'getWork']);

    //Records
    Route::post('/upload-record', [RecordController::class, 'uploadRecord']);
    Route::get('/retrieve-record', [RecordController::class, 'getRecord']);

    // Retrieve department
    Route::get('/retrieve', [DepartmentController::class, 'getDepartments']);

    // Add forms
    Route::post('/form', [FormController::class, 'submitForm']);

    // Retrieve Forms per ID
    Route::get('/retrieve-forms/{data}', [FormController::class, 'retrieve_forms']);

    // Retrieve forms
    Route::get('/retrieve-forms', [FormController::class, 'getForms']);

    // Archive
    Route::put('/archive/{id}', [Archive::class, 'archiveDepartment']);
    Route::put('/archive-forms/{id}', [Archive::class, 'archiveForms']);

    // Upload Files
    Route::post('/upload', [FileController::class, 'upload']);
    Route::get('/retrieve-upload/{formId}', [FileController::class, 'retrieveUploads']);

    // View PDF
    Route::get('/get-file-content/{fileId}', [ViewPDF::class, 'getFileContent']);
    Route::get('/retrieve-policies/{polId}', [ViewPDF::class, 'getContentPolicies']);
    Route::get('/retrieve-procedures/{procId}', [ViewPDF::class, 'getContentProcedures']);
    Route::get('/retrieve-workins/{workId}', [ViewPDF::class, 'getWorkInstructions']);
    Route::get('/retrieve-records/{recId}', [ViewPDF::class, 'getRecord']);

    // Form Viewing  
    Route::post('increment-views', [FormController::class, 'incrementViewCount']);

    // Form Download
    Route::post('increment-views-dowload', [FormController::class, 'incrementDownloadCount']);
    
    // Users
    Route::get('/user-retrieve', [UserController::class, 'getUsers']);

    // Role & Department
    // Route::post('upload-roledep', [RoleDepController::class, 'addRoleDep']);
    // Route::get('/roledep-retrieve', [RoleDepController::class, 'getRoleDep']);

});
