<table class="table table-bordered">
    <tr>
        <th>Emp ID</th>
        <th>Emp Name</th>
        <th>Designation</th>
        <th>Gross Salary</th>
        <th>Working Days</th>
        <th>Salary Deducted</th>
        <th>Salary Paid</th>
    </tr>
    @foreach($result as $data)
    <tr>
        <td>{{ $data->code }}</td>
        <td>{{ $data->empName }}</td>
        <td>{{ $data->desName }}</td>
        <td>{{ $data->gross_salary }}</td>
        <td>{{ $data->working_days }}</td>
        <td>{{ $data->total_deduction_salary }}</td>
        <td>{{ $data->paid_salary }}</td>
    </tr>
    @endforeach
</table>