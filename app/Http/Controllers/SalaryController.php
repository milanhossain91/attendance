<?php

namespace App\Http\Controllers;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Auth;
use DB;
use PDF;

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function pageIndex()
    {
        return view('frontend/salaryProcessing/salaryProcessingPage');
    }

    public function salaryProcessingSubmit(Request $request)
    {
        $start  = $request->get('month');
        $end    = date("Y-m-t", strtotime($request->get('month')));
        $days   = date("t", strtotime($request->get('month')));

        $checkExisting = DB::table('salary_generates')
            ->where('salary_month',$start)
            ->count();

        if($checkExisting==0){

            $result = DB::table('final_attendances')
            ->select('final_attendances.*','employees.salary')
            ->leftJoin('employees','employees.code','=','final_attendances.emp_id')
            ->whereBetween('date',[$start,$end])
            ->whereIn('emp_id',[55,66,67])
            ->groupBy('emp_id')
            ->get();        
            
            foreach($result as $data)
            {
                $totalLate=0;      
                $totalPresent=0;
                $totalEarlyout=0;
                $totalAbsent=0; 
                $totalDays=0; 
                $totalWeekend=0; 
                $totalHoliday=0; 

                $employee = DB::table('final_attendances')
                ->select('final_attendances.*','employees.salary')
                ->leftJoin('employees','employees.code','=','final_attendances.emp_id')
                ->where('emp_id',$data->emp_id)
                ->whereBetween('date',[$start,$end])
                ->get();

                //'Present','Present & Earlyout','Late & Earlyout','Late','Absent'
                foreach($employee as $dataEmployee)
                {                
                    if($dataEmployee->attendance_type=='Late' || $dataEmployee->attendance_type=='Late & Earlyout')
                    {
                        $totalLate = $totalLate+1;
                    }
                    else if($dataEmployee->attendance_type=='Present' || $dataEmployee->attendance_type=='Present & Earlyout')
                    {
                        $totalPresent = $totalPresent+1;
                    }
                    else if($dataEmployee->attendance_type=='Absent')
                    {
                        $totalAbsent= $totalAbsent+1;
                    }
                    else if($dataEmployee->attendance_type=='Weekend')
                    {
                        $totalWeekend= $totalWeekend+1;
                    }
                    else if($dataEmployee->attendance_type=='National Holiday')
                    {
                        $totalHoliday= $totalHoliday+1;
                    }
                    if($dataEmployee->adjustment_type=='Leave')
                    {
                        $totalAbsent = $totalAbsent+1;
                    }                
                }

                $salaryPerDay   = round($dataEmployee->salary/$days);
                $totalAttend    = $totalPresent + $totalLate + $totalWeekend + $totalHoliday;
                $salaryPaid     = round($salaryPerDay*$totalAttend);
                $salaryDeducted = round($dataEmployee->salary - $salaryPaid);

                //echo 'Emp-'.$dataEmployee->emp_id.'<br /> Total Attedance-'.$totalAttend.'<br /> Total Present-'.$totalPresent.'<br /> Total Absent-'.$totalAbsent.'<br /> Total Late-'.$totalLate.'<br /> Total Weekend-'.$totalWeekend.'<br /> Total Holiday-'.$totalHoliday.'<br /> Total Deducted-'.$salaryDeducted.'<br /> Total Paid Salary-'.$salaryPaid.'<br />';

                $this->generated($dataEmployee->emp_id,$dataEmployee->salary,$salaryPerDay,$days,$totalPresent,$totalLate,$totalAbsent,$start,$salaryPaid,$salaryDeducted,$totalAttend);

                // $result = DB::table('salary_generates')
                // ->select('salary_generates.*','employees.name as empName','employees.code','designations.name as desName','departments.name as depName')
                // ->leftjoin('employees','employees.code','=','salary_generates.emp_id')
                // ->leftjoin('designations','designations.id','=','employees.designation_id')
                // ->leftjoin('departments','departments.id','=','employees.department_id')
                // ->get();

                // return view('frontend/salaryProcessing/salarySheet', compact('result'));
            }            
        }
        else{
            return 1; // already exist
        }                
    }

    public function generated($emp_id,$gross_salary,$salaryPerDay,$days,$totalPresent,$totalLate,$totalAbsent,$month,$salaryPaid,$salaryDeducted,$totalAttend)
    {
        DB::table('salary_generates')->insert([
            'emp_id'                => $emp_id,
            'gross_salary'          => $gross_salary,
            'per_day_salary'        => $salaryPerDay,
            'paid_salary'           => $salaryPaid,
            'total_deduction_salary'=> $salaryDeducted,
            'total_absent_deduction'=> $totalAbsent,
            'total_late_deduction'  => $totalLate,
            'working_days'          => $totalAttend,
            'salary_month_days'     => $days,
            'salary_month'          => $month,
            'salary_generate_date'  => date('Y-m-d H:i:s')
        ]);

        return 0;
    }


    public function salaryProcessingDelete(Request $request)
    {
        $salary = DB::table('salary_generates')
            ->where('salary_month',$request->get('month'))
            ->delete();

        return 1;    
    }

    public function salarySheetgPdf(Request $request)
    {
        $month  = $request->get('month');

        $departments = DB::table('salary_generates')
            ->select('departments.name as depName','departments.id as did')
            ->leftjoin('employees','employees.code','=','salary_generates.emp_id')
            ->leftjoin('departments','departments.id','=','employees.department_id')
            ->whereBetween('salary_generates.salary_month',[$month,$month])
            ->groupBy('employees.department_id')
            ->get();

        $pdf = PDF::loadView('frontend/salaryProcessing/salarySheetPDF', compact('month','departments'));
        return $pdf->setPaper('a4', 'portrait')->setWarnings(false)->stream('salary-sheet.pdf');
    }
}
