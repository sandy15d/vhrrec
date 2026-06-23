<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EmployeeFirobReportExport implements WithMultipleSheets
{
    public function __construct(private array $filters = [])
    {
    }

    public function sheets(): array
    {
        $employeeSubDepartment = DB::table('candjoining as joining')
            ->join('offerletterbasic as offer', 'offer.JAId', '=', 'joining.JAId')
            ->whereNotNull('joining.EmpCode')
            ->whereNotNull('offer.SubDepartment')
            ->where('offer.SubDepartment', '<>', '')
            ->where('offer.SubDepartment', '<>', 0)
            ->select(
                'joining.EmpCode',
                DB::raw('MAX(offer.SubDepartment) as SubDepartmentId')
            )
            ->groupBy('joining.EmpCode');

        $companies = DB::table('master_employee as employee')
            ->join('core_company as company', 'company.id', '=', 'employee.CompanyId')
            ->leftJoinSub($employeeSubDepartment, 'employee_sub_department', function ($join) {
                $join->on('employee_sub_department.EmpCode', '=', 'employee.EmpCode');
            })
            ->where('employee.EmpStatus', 'A')
            ->when($this->filters['Company'] ?? null, function ($query, $companyId) {
                $query->where('employee.CompanyId', $companyId);
            })
            ->when($this->filters['Department'] ?? null, function ($query, $departmentId) {
                $query->where('employee.DepartmentId', $departmentId);
            })
            ->when($this->filters['SubDepartment'] ?? null, function ($query, $subDepartmentId) {
                $query->where('employee_sub_department.SubDepartmentId', $subDepartmentId);
            })
            ->when($this->filters['Grade'] ?? null, function ($query, $gradeId) {
                $query->where('employee.GradeId', $gradeId);
            })
            ->when($this->filters['Designation'] ?? null, function ($query, $designationId) {
                $query->where('employee.DesigId', $designationId);
            })
            ->select('employee.CompanyId', 'company.company_code')
            ->distinct()
            ->orderBy('company.company_code')
            ->get();

        return $companies->map(function ($company) {
            return new EmployeeFirobCompanySheet(
                (int) $company->CompanyId,
                (string) $company->company_code,
                $this->filters
            );
        })->all();
    }
}
