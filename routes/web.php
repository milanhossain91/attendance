<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\EmployeeController;

use App\Http\Controllers\LeaveCategoryController;
use App\Http\Controllers\LeaveManageController;
use App\Http\Controllers\ShiftManageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\AdjustmentController;

use App\Http\Controllers\ZkController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\DataMigrationController;

use App\Http\Controllers\RosterController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ConveyanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [App\Http\Controllers\LoginController::class, 'pageIndex'])->name('/');
Route::post('post-login', [App\Http\Controllers\LoginController::class, 'postLogin'])->name('login.user');
Route::get('password', [LoginController::class, 'password'])->name('password');
Route::post('password', [LoginController::class, 'password_action'])->name('password.action');
Route::get('logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'pageIndex'])->name('dashboard');
Route::get('theme-change', [App\Http\Controllers\DashboardController::class, 'themeChange'])->name('theme-change');

Route::get('department', [DepartmentController::class, 'pageIndex'])->name('department');
Route::get('department-result', [DepartmentController::class, 'pageIndexResult'])->name('department-result');
Route::get('department-create', [DepartmentController::class, 'create'])->name('department-create');
Route::post('department-submit', [DepartmentController::class, 'submit'])->name('department-submit');
Route::get('department-update/{id}', [DepartmentController::class, 'update'])->name('department-update');
Route::post('department-update-submit', [DepartmentController::class, 'submit_edit'])->name('department-update-submit');
Route::get('department-delete/{id}', [DepartmentController::class, 'delete'])->name('department-delete');


Route::get('designation', [DesignationController::class, 'pageIndex'])->name('designation');
Route::get('designation-result', [DesignationController::class, 'pageIndexResult'])->name('designation-result');
Route::get('designation-create', [DesignationController::class, 'create'])->name('designation-create');
Route::post('designation-submit', [DesignationController::class, 'submit'])->name('designation-submit');
Route::get('designation-update/{id}', [DesignationController::class, 'update'])->name('designation-update');
Route::post('designation-update-submit', [DesignationController::class, 'submit_edit'])->name('designation-update-submit');
Route::get('designation-delete/{id}', [DesignationController::class, 'delete'])->name('designation-delete');


Route::get('holidays', [HolidayController::class, 'pageIndex'])->name('holidays');
Route::get('holidays-result', [HolidayController::class, 'pageIndexResult'])->name('holidays-result');
Route::get('holidays-create', [HolidayController::class, 'create'])->name('holidays-create');
Route::post('holidays-submit', [HolidayController::class, 'submit'])->name('holidays-submit');
Route::get('holidays-update/{id}', [HolidayController::class, 'update'])->name('holidays-update');
Route::post('holidays-update-submit', [HolidayController::class, 'submit_edit'])->name('holidays-update-submit');
Route::get('holidays-delete/{id}', [HolidayController::class, 'delete'])->name('holidays-delete');

Route::get('employee', [EmployeeController::class, 'pageIndex'])->name('employee');
Route::get('employee-result', [EmployeeController::class, 'pageIndexResult'])->name('employee-result');
Route::get('employee-create', [EmployeeController::class, 'create'])->name('employee-create');
Route::post('employee-submit', [EmployeeController::class, 'submit'])->name('employee-submit');
Route::get('employee-update/{id}', [EmployeeController::class, 'update'])->name('employee-update');
Route::post('employee-update-submit', [EmployeeController::class, 'submit_edit'])->name('employee-update-submit');
Route::get('employee-delete/{id}', [EmployeeController::class, 'delete'])->name('employee-delete');


Route::get('leave-type', [LeaveCategoryController::class, 'pageIndex'])->name('leave-type');
Route::get('leave-type-result', [LeaveCategoryController::class, 'pageIndexResult'])->name('leave-type-result');
Route::get('leave-type-create', [LeaveCategoryController::class, 'create'])->name('leave-type-create');
Route::post('leave-type-submit', [LeaveCategoryController::class, 'submit'])->name('leave-type-submit');
Route::get('leave-type-edit/{id}', [LeaveCategoryController::class, 'edit'])->name('leave-type-edit');
Route::post('leave-type-edit-submit', [LeaveCategoryController::class, 'update'])->name('leave-type-edit-submit');
Route::get('leave-type-delete/{id}', [LeaveCategoryController::class, 'delete'])->name('leave-type-delete');

Route::get('leave', [LeaveManageController::class, 'pageIndex'])->name('leave');
Route::get('leave-result', [LeaveManageController::class, 'pageIndexResult'])->name('leave-result');
Route::get('leave-create', [LeaveManageController::class, 'create'])->name('leave-create');
Route::post('leave-submit', [LeaveManageController::class, 'submit'])->name('leave-submit');
Route::get('leave-edit/{id}', [LeaveManageController::class, 'edit'])->name('leave-edit');
Route::post('leave-update', [LeaveManageController::class, 'update'])->name('leave-update');
Route::get('leave-delete/{id}', [LeaveManageController::class, 'delete'])->name('leave-delete');

Route::get('leave-list', [LeaveManageController::class, 'waitingLeave'])->name('leave-list');
Route::get('leave-list-result', [LeaveManageController::class, 'waitingLeaveResult'])->name('leave-list-result');
Route::get('leave-approved/{type}/{id}', [LeaveManageController::class, 'approved'])->name('leave-approved');

Route::get('shift', [ShiftManageController::class, 'pageIndex'])->name('shift');
Route::get('shift-result', [ShiftManageController::class, 'pageIndexResult'])->name('shift-result');
Route::get('shift-create', [ShiftManageController::class, 'create'])->name('shift-create');
Route::post('shift-submit', [ShiftManageController::class, 'submit'])->name('shift-submit');
Route::get('shift-edit/{id}', [ShiftManageController::class, 'edit'])->name('shift-edit');
Route::post('shift-update', [ShiftManageController::class, 'update'])->name('shift-update');
Route::get('shift-delete/{id}', [ShiftManageController::class, 'delete'])->name('shift-delete');


Route::get('attendance', [DashboardController::class, 'pageIndex'])->name('attendance');
Route::get('attendance-upload', [DashboardController::class, 'pageIndex'])->name('attendance-upload');

Route::get('notice', [NoticeController::class, 'pageIndex'])->name('notice');
Route::get('notice-create', [NoticeController::class, 'create'])->name('notice-create');
Route::post('notice-submit', [NoticeController::class, 'submit'])->name('notice-submit');
Route::get('notice-update/{id}', [NoticeController::class, 'update'])->name('notice-update');
Route::post('notice-update-submit', [NoticeController::class, 'submit_edit'])->name('notice-update-submit');
Route::get('notice-delete/{id}', [NoticeController::class, 'delete'])->name('notice-delete');
Route::get('notice-all', [NoticeController::class, 'noticeAll'])->name('notice-all');

Route::get('adjustment', [AdjustmentController::class,'pageIndex'])->name('adjustment');
Route::get('adjustment-result', [AdjustmentController::class,'pageIndexResult'])->name('adjustment-result');
Route::get('adjustment-create', [AdjustmentController::class,'create'])->name('adjustment-create');
Route::post('adjustment-submit', [AdjustmentController::class,'submit'])->name('adjustment-submit');
Route::get('adjustment-update/{id}', [AdjustmentController::class,'update'])->name('adjustment-update');
Route::post('adjustment-update-submit', [AdjustmentController::class,'submit_edit'])->name('adjustment-update-submit');
Route::get('adjustment-delete/{id}', [AdjustmentController::class,'delete'])->name('adjustment-delete');

Route::get('adjustment-approved/{type}/{id}', [AdjustmentController::class,'approvedOrReject'])->name('adjustment-approved');

Route::get('adjustment-approval', [AdjustmentController::class,'adjustmentApproval'])->name('adjustment-approval');
Route::get('adjustment-approval-result', [AdjustmentController::class,'adjustmentApprovalResult'])->name('adjustment-approval-result');

// Salary
Route::get('migration', [DataMigrationController::class,'attedanceDataMigration'])->name('migration');

Route::get('salary-processing', [SalaryController::class,'pageIndex'])->name('salary-processing');
Route::post('salary-processing-submit', [SalaryController::class,'salaryProcessingSubmit'])->name('salary-processing-submit');
Route::post('salary-processing-delete', [SalaryController::class,'salaryProcessingDelete'])->name('salary-processing-delete');

Route::post('salary-sheet-pdf', [SalaryController::class,'salarySheetgPdf'])->name('salary-sheet-pdf');

//
Route::get('zklist', [ZkController::class, 'show'])->name('manual-upload');
Route::post('post-att', [ZkController::class, 'postAttDevice'])->name('post-att');
Route::get('employeewise-attendance/{get}', [AttendanceController::class, 'employeeWiseAttendance'])->name('employeewise-attendance');
Route::post('post-employeewise-attendance', [AttendanceController::class, 'postEmployeeWiseAttendance'])->name('post-employeewise-attendance');
Route::post('api/fetch-employee', [AttendanceController::class, 'fetchEmployee']);

// Roster
Route::get('rostersetup', [RosterController::class, 'index'])->name('home');
Route::post('rostersetup', [RosterController::class, 'store'])->name('store');

Route::post('/postajax_set_rschedule', [AjaxController::class, 'rSchedule'])->name('rSchedule');
Route::post('/postajax_reset_roster', [AjaxController::class, 'rosterReset']);

Route::get('roster-schedule', [RosterController::class, 'rosterSchedule'])->name('roster-schedule');



//Conveyances
Route::get('conveyances', [ConveyanceController::class, 'pageIndex'])->name('conveyances');
Route::get('conveyances-result', [ConveyanceController::class, 'pageIndexResult'])->name('conveyances-result');
Route::get('conveyances-create', [ConveyanceController::class, 'create'])->name('conveyances-create');
Route::post('conveyances-submit', [ConveyanceController::class, 'submit'])->name('conveyances-submit');
Route::get('conveyances-update/{id}', [ConveyanceController::class, 'update'])->name('conveyances-update');
Route::post('conveyances-update-submit', [ConveyanceController::class, 'submit_edit'])->name('conveyances-update-submit');
//Route::get('conveyances-delete/{id}', [ConveyanceController::class, 'delete'])->name('conveyances-delete')


Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
