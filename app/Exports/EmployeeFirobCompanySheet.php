<?php

namespace App\Exports;

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeFirobCompanySheet implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    public function __construct(
        private int $companyId,
        private string $companyCode,
        private array $filters = []
    ) {
    }

    public function collection(): Collection
    {
        $firobSummary = DB::table('firob_user')
            ->select(
                'userid',
                DB::raw('COUNT(DISTINCT FirobId) as answer_count'),
                DB::raw('MAX(SubDate) as firob_date')
            )
            ->groupBy('userid');

        $employeeSubDepartment = $this->employeeSubDepartmentSummary();

        $query = DB::table('master_employee as employee')
            ->leftJoinSub($firobSummary, 'firob_summary', function ($join) {
                $join->on('firob_summary.userid', '=', 'employee.CandidateId');
            })
            ->leftJoin('core_company as company', 'company.id', '=', 'employee.CompanyId')
            ->leftJoin('core_grade as grade', 'grade.id', '=', 'employee.GradeId')
            ->leftJoin('core_designation as designation', 'designation.id', '=', 'employee.DesigId')
            ->leftJoin('core_department as department', 'department.id', '=', 'employee.DepartmentId')
            ->leftJoinSub($employeeSubDepartment, 'employee_sub_department', function ($join) {
                $join->on('employee_sub_department.EmpCode', '=', 'employee.EmpCode');
            })
            ->leftJoin('core_sub_department as sub_department', 'sub_department.id', '=', 'employee_sub_department.SubDepartmentId')
            ->where('employee.EmpStatus', 'A')
            ->where('employee.CompanyId', $this->companyId)
            ->select(
                'employee.EmployeeID',
                'employee.EmpCode',
                'employee.Fname',
                'employee.Sname',
                'employee.Lname',
                'employee.DOJ',
                'company.company_code',
                'grade.grade_name',
                'designation.designation_name',
                'department.department_name',
                'sub_department.sub_department_name',
                'employee.CandidateId as JCId',
                DB::raw('COALESCE(firob_summary.answer_count, 0) as answer_count'),
                'firob_summary.firob_date'
            )
            ->orderBy('employee.EmpCode');

        $this->applyFilters($query);

        $employees = $query->get()->values();
        $scoreMap = $this->buildScoreMap(
            $employees->where('answer_count', '>=', 54)->pluck('JCId')->filter()->all()
        );
        $yarmsScoreMap = $this->buildYarmsScoreMap(
            $employees->where('answer_count', '<', 54)
        );

        return $employees->map(function ($employee, $index) use ($scoreMap, $yarmsScoreMap) {
            $answerCount = (int) $employee->answer_count;
            $resultUrl = null;
            $yarmsScores = $yarmsScoreMap[$employee->EmployeeID] ?? null;
            $hasCompleteYarmsScores = $yarmsScores
                && collect(['EI', 'EC', 'EA', 'WI', 'WC', 'WA'])->every(function ($scoreKey) use ($yarmsScores) {
                    return array_key_exists($scoreKey, $yarmsScores)
                        && $yarmsScores[$scoreKey] !== null
                        && $yarmsScores[$scoreKey] !== '';
                })
                && collect(['EI', 'EC', 'EA', 'WI', 'WC', 'WA'])->contains(function ($scoreKey) use ($yarmsScores) {
                    return (int) $yarmsScores[$scoreKey] !== 0;
                });

            if ($answerCount >= 54 && $employee->JCId) {
                $resultUrl = route('firob_result', ['jcid' => $employee->JCId]);
            } elseif ($yarmsScores && $employee->EmployeeID && $employee->EmpCode) {
                $resultUrl = 'https://www.yarms.in/reg/vspl/findtreslt.php?'.http_build_query([
                    'tid' => 2,
                    'ei' => $employee->EmployeeID,
                    'ut' => 'intvi',
                    'ec' => $employee->EmpCode,
                ]);
            }

            $scores = $scoreMap[$employee->JCId] ?? $yarmsScores ?? [
                'EI' => '-', 'EC' => '-', 'EA' => '-',
                'WI' => '-', 'WC' => '-', 'WA' => '-',
            ];
            $resultCell = $answerCount > 0 && $answerCount < 54 && ! $yarmsScores
                ? 'Incomplete ('.$answerCount.'/54)'
                : ($resultUrl ? '=HYPERLINK("'.str_replace('"', '""', $resultUrl).'","View Result")' : 'Not Available');
            $resultStatus = $answerCount >= 54 || $hasCompleteYarmsScores ? 'Completed' : null;

            return [
                $index + 1,
                $employee->EmpCode,
                trim(implode(' ', array_filter([$employee->Fname, $employee->Sname, $employee->Lname]))),
                $employee->company_code ?: '-',
                $employee->grade_name ?: '-',
                $employee->designation_name ?: '-',
                $employee->department_name ?: '-',
                $employee->sub_department_name ?: '-',
                $employee->DOJ ? date('d-m-Y', strtotime($employee->DOJ)) : '-',
                $employee->firob_date ? date('d-m-Y', strtotime($employee->firob_date)) : '-',
                $scores['EI'],
                $scores['EC'],
                $scores['EA'],
                $scores['WI'],
                $scores['WC'],
                $scores['WA'],
                $resultStatus,
                $resultCell,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Employee Code',
            'Employee Name',
            'Company',
            'Grade',
            'Designation',
            'Department',
            'Sub Department',
            'DOJ',
            'FIRO B Date',
            'EI',
            'EC',
            'EA',
            'WI',
            'WC',
            'WA',
            'FIRO B Status',
            'FIRO B Result',
        ];
    }

    public function title(): string
    {
        $title = preg_replace('~[\\/?*\[\]:]~', '-', $this->companyCode) ?: 'Company-'.$this->companyId;

        return substr($title, 0, 31);
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->freezePane('A2');
        $sheet->setAutoFilter($sheet->calculateWorksheetDimension());

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    private function applyFilters($query): void
    {
        if (! empty($this->filters['Department'])) {
            $query->where('employee.DepartmentId', $this->filters['Department']);
        }
        if (! empty($this->filters['SubDepartment'])) {
            $query->where('employee_sub_department.SubDepartmentId', $this->filters['SubDepartment']);
        }
        if (! empty($this->filters['Grade'])) {
            $query->where('employee.GradeId', $this->filters['Grade']);
        }
        if (! empty($this->filters['Designation'])) {
            $query->where('employee.DesigId', $this->filters['Designation']);
        }

        $status = $this->filters['FirobStatus'] ?? null;
        if ($status === 'completed') {
            $query->where('firob_summary.answer_count', '>=', 54);
        } elseif ($status === 'incomplete') {
            $query->whereBetween('firob_summary.answer_count', [1, 53]);
        } elseif ($status === 'not_taken') {
            $query->whereNull('firob_summary.answer_count');
        }
    }

    private function employeeSubDepartmentSummary()
    {
        return DB::table('candjoining as joining')
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
    }

    private function buildScoreMap(array $candidateIds): array
    {
        if (empty($candidateIds)) {
            return [];
        }

        $questionToSet = [];
        foreach (DB::table('firob_qset')->get() as $questionSet) {
            for ($index = 1; $index <= 9; $index++) {
                $questionId = $questionSet->{'q'.$index};
                if ($questionId) {
                    $questionToSet[$questionId] = $questionSet->FiroSetN;
                }
            }
        }

        $questionMap = [];
        foreach (DB::table('firob')->whereIn('FirobId', array_keys($questionToSet))->get() as $question) {
            $questionMap[$question->FirobId] = [
                'set' => $questionToSet[$question->FirobId],
                'valid_answers' => array_map('intval', [
                    $question->ns1,
                    $question->ns2,
                    $question->ns3,
                    $question->ns4,
                ]),
            ];
        }

        $scoreMap = [];
        foreach ($candidateIds as $candidateId) {
            $scoreMap[$candidateId] = ['EI' => 0, 'EC' => 0, 'EA' => 0, 'WI' => 0, 'WC' => 0, 'WA' => 0];
        }

        $answers = DB::table('firob_user')->whereIn('userid', $candidateIds)->get();
        foreach ($answers as $answer) {
            $question = $questionMap[$answer->FirobId] ?? null;
            $answerValue = (int) $answer->FirobUVal;
            if ($question && $answerValue !== 0 && $answerValue !== 9
                && in_array($answerValue, $question['valid_answers'], true)) {
                $scoreMap[$answer->userid][$question['set']]++;
            }
        }

        return $scoreMap;
    }

    private function buildYarmsScoreMap(Collection $employees): array
    {
        $scoreMap = [];
        $pendingEmployees = collect();

        foreach ($employees as $employee) {
            if (! $employee->EmployeeID || ! $employee->EmpCode) {
                continue;
            }

            $cacheKey = $this->yarmsCacheKey($employee->EmployeeID, $employee->EmpCode);
            $cached = Cache::get($cacheKey);
            if (is_array($cached)) {
                $scoreMap[$employee->EmployeeID] = $cached;
            } elseif ($cached === null) {
                $pendingEmployees->push($employee);
            }
        }

        foreach ($pendingEmployees->chunk(50) as $chunk) {
            $responses = Http::pool(function (Pool $pool) use ($chunk) {
                $requests = [];
                foreach ($chunk as $employee) {
                    $requests[] = $pool
                        ->as((string) $employee->EmployeeID)
                        ->withOptions(['verify' => false])
                        ->timeout(12)
                        ->get('https://www.yarms.in/reg/vspl/findtreslt.php', [
                            'tid' => 2,
                            'ei' => $employee->EmployeeID,
                            'ut' => 'intvi',
                            'ec' => $employee->EmpCode,
                        ]);
                }

                return $requests;
            });

            foreach ($chunk as $employee) {
                $response = $responses[(string) $employee->EmployeeID] ?? null;
                $scores = $response && method_exists($response, 'successful') && $response->successful()
                    ? $this->parseYarmsScores($response->body())
                    : null;

                Cache::put(
                    $this->yarmsCacheKey($employee->EmployeeID, $employee->EmpCode),
                    $scores ?: false,
                    $scores ? now()->addDays(30) : now()->addDay()
                );

                if ($scores) {
                    $scoreMap[$employee->EmployeeID] = $scores;
                }
            }
        }

        return $scoreMap;
    }

    private function parseYarmsScores(string $html): ?array
    {
        libxml_use_internal_errors(true);
        $document = new \DOMDocument();
        if (! $document->loadHTML($html)) {
            libxml_clear_errors();
            return null;
        }

        $scores = [];
        foreach (['EI' => 1, 'EC' => 2, 'EA' => 3, 'WI' => 4, 'WC' => 5, 'WA' => 6] as $name => $group) {
            $score = 0;
            for ($index = 1; $index <= 9; $index++) {
                $field = $document->getElementById('t'.$group.$index);
                if (! $field) {
                    libxml_clear_errors();
                    return null;
                }
                $score += (float) $field->getAttribute('value');
            }
            $scores[$name] = (int) round($score);
        }
        libxml_clear_errors();

        return $scores;
    }

    private function yarmsCacheKey($employeeId, $employeeCode): string
    {
        return 'employee_firob_yarms_v2_'.md5($employeeId.'|'.$employeeCode);
    }
}
