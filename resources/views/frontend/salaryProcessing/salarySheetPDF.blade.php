<!DOCTYPE html>
<html>
<head>
    <title>Salary for the month of {{ date("F Y", strtotime($month)) }}</title>
    <style type="text/css">
        body {
            font-family: Tahoma, Geneva, sans-serif;
            font-size: 14px;
        }
        @page{
            margin: 30px 10px 0px 10px;
        }
        h1 {
            font-size: 20px;
        }
        table {
            border-collapse: collapse;
            font-family: Tahoma, Geneva, sans-serif;
        }
        table td {
            padding: 6px;
        }
        table thead td {
            background-color: #f1f3f5;
            color: #000;
            font-weight: bold;
            font-size: 11px;
            border: 1px solid #54585d;
        }
        table tbody td {
            color: #000;
            border: 1px solid #54585d;
            font-size: 11px;
        }
        table tbody tr {
            background-color: #f9fafb;
        }
        table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }

        .footer {
           position: fixed;
           left: 0;
           bottom: 0;
           width: 100%;
           background-color: #f1f3f5;
           color: #000;
           text-align: center;
        }
    </style>
</head>
<body>
    
    <h1 style="text-align: center;">Salary for the month of {{ date("F Y", strtotime($month)) }}</h1>
    <p style="text-align: center; padding-bottom: 30px;">Duration : {{ date("d-m-Y", strtotime($month)) }} to {{ date("t-m-Y", strtotime($month)) }}</p>

    @foreach($departments as $dataDept)

        <h3>Department : {{$dataDept->depName}}</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td style="width:20px;">ID</td>
                    <td style="width:180px;">Employee Name</td>
                    <td style="width:180px;">Designation</td>
                    <td class="text-right">Gross Salary</td>
                    <td class="text-center">Working Days</td>
                    <td class="text-right">Salary Deducted</td>
                    <td class="text-right">Salary Paid</td>
                </tr>
            </thead>
            <tbody>
                @php
                $result = DB::table('salary_generates')
                    ->select('salary_generates.*','employees.name as empName','employees.code','designations.name as desName','departments.name as depName')
                    ->leftjoin('employees','employees.code','=','salary_generates.emp_id')
                    ->leftjoin('designations','designations.id','=','employees.designation_id')
                    ->leftjoin('departments','departments.id','=','employees.department_id')
                    ->whereBetween('salary_generates.salary_month',[$month,$month])
                    ->where('employees.department_id',$dataDept->did)
                    ->get();
                @endphp
                @foreach($result as $data)
                <tr>
                    <td>{{ $data->code }}</td>
                    <td>{{ $data->empName }}</td>
                    <td>{{ $data->desName }}</td>
                    <td class="text-right">{{ number_format($data->gross_salary,2) }}</td>
                    <td class="text-center">{{ $data->working_days }}</td>
                    <td class="text-right">{{ number_format($data->total_deduction_salary,2) }}</td>
                    <td class="text-right">{{ number_format($data->paid_salary,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @endforeach

    <div class="footer">
      <p>Weblink Communications Ltd</p>
    </div>
  
</body>
</html>