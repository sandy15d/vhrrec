@extends('layouts.master')
@section('title', 'File Copy Logs')
@section('PageContent')
<style>
    .fc-stat{background:#fff;border-radius:6px;padding:10px 14px;box-shadow:0 1px 3px rgba(0,0,0,.08);display:flex;align-items:center;gap:10px;}
    .fc-stat-icon{width:36px;height:36px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:16px;color:#fff;}
    .fc-stat-num{font-size:20px;font-weight:700;line-height:1;}
    .fc-stat-lbl{font-size:11px;color:#7f8c8d;text-transform:uppercase;letter-spacing:.3px;}
    .fc-filter{background:#fff;border-radius:6px;padding:10px 14px;box-shadow:0 1px 3px rgba(0,0,0,.08);margin-bottom:12px;}
    .fc-filter label{font-size:11px;font-weight:600;color:#555;margin-bottom:2px;}
    .fc-filter .form-control,.fc-filter .form-select{font-size:12px;padding:4px 8px;height:30px;}
    .fc-table{background:#fff;border-radius:6px;padding:12px;box-shadow:0 1px 3px rgba(0,0,0,.08);}
    .fc-table table{font-size:12px;margin:0;}
    .fc-table th{font-size:11px;font-weight:600;text-transform:uppercase;color:#555;background:#f8f9fa;padding:6px 8px !important;white-space:nowrap;}
    .fc-table td{padding:5px 8px !important;vertical-align:middle;}
    .fc-path{font-family:'Courier New',monospace;font-size:10px;color:#34495e;max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block;}
    .fc-err{font-size:10px;color:#e74c3c;max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block;}
    .fc-badge{padding:2px 7px;border-radius:3px;font-size:10px;font-weight:600;color:#fff;display:inline-block;}
    .fc-badge-ok{background:#27ae60;}
    .fc-badge-fail{background:#e74c3c;}
    .fc-badge-wait{background:#f39c12;}
    .fc-badge-type{background:#8e99a4;font-size:9px;padding:1px 6px;}
    .fc-btn{padding:2px 6px;font-size:10px;border-radius:3px;border:none;cursor:pointer;display:inline-flex;align-items:center;gap:3px;}
    .fc-btn-retry{background:#f39c12;color:#fff;}
    .fc-btn-retry:hover{background:#e67e22;color:#fff;}
    .fc-btn-del{background:#e74c3c;color:#fff;}
    .fc-btn-del:hover{background:#c0392b;color:#fff;}
    .fc-btn-filter{background:#3498db;color:#fff;padding:4px 12px;font-size:11px;}
    .fc-btn-filter:hover{background:#2980b9;color:#fff;}
    .fc-btn-reset{background:#95a5a6;color:#fff;padding:4px 8px;font-size:11px;}
    .fc-btn-reset:hover{background:#7f8c8d;color:#fff;}
</style>

<div class="page-content">
    <div class="container-fluid">

        <!-- Header + Stats in one row -->
        <div class="row mb-2 align-items-center">
            <div class="col-md-4">
                <h5 class="mb-0">File Copy Logs</h5>
                <small class="text-muted">S3 transfers: Recruitment to HRIMS</small>
            </div>
            <div class="col-md-8">
                <div class="d-flex gap-2 justify-content-end">
                    <div class="fc-stat">
                        <div class="fc-stat-icon" style="background:#3498db;"><i class="fa fa-files-o"></i></div>
                        <div><div class="fc-stat-num" style="color:#3498db;">{{ $stats['total'] }}</div><div class="fc-stat-lbl">Total</div></div>
                    </div>
                    <div class="fc-stat">
                        <div class="fc-stat-icon" style="background:#27ae60;"><i class="fa fa-check"></i></div>
                        <div><div class="fc-stat-num" style="color:#27ae60;">{{ $stats['success'] }}</div><div class="fc-stat-lbl">Success</div></div>
                    </div>
                    <div class="fc-stat">
                        <div class="fc-stat-icon" style="background:#e74c3c;"><i class="fa fa-times"></i></div>
                        <div><div class="fc-stat-num" style="color:#e74c3c;">{{ $stats['failed'] }}</div><div class="fc-stat-lbl">Failed</div></div>
                    </div>
                    <div class="fc-stat">
                        <div class="fc-stat-icon" style="background:#f39c12;"><i class="fa fa-clock-o"></i></div>
                        <div><div class="fc-stat-num" style="color:#f39c12;">{{ $stats['pending'] }}</div><div class="fc-stat-lbl">Pending</div></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="fc-filter">
            <form method="GET" action="{{ route('admin.fileCopyLogs') }}">
                <div class="row g-2 align-items-end">
                    <div class="col">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                            <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <div class="col">
                        <label>EmpCode</label>
                        <input type="text" name="emp_code" class="form-control" value="{{ request('emp_code') }}" placeholder="EmpCode">
                    </div>
                    <div class="col">
                        <label>File Type</label>
                        <input type="text" name="file_type" class="form-control" value="{{ request('file_type') }}" placeholder="e.g. Aadhar">
                    </div>
                    <div class="col">
                        <label>From</label>
                        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                    </div>
                    <div class="col">
                        <label>To</label>
                        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-auto">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn fc-btn-filter"><i class="fa fa-search"></i> Filter</button>
                            <a href="{{ route('admin.fileCopyLogs') }}" class="btn fc-btn-reset"><i class="fa fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="fc-table">
            <table class="table table-hover table-bordered mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>EmpCode</th>
                        <th>Candidate</th>
                        <th>Source Path</th>
                        <th>Dest Path</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Error</th>
                        <th>Retry</th>
                        <th>Date</th>
                        <th>Act</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr id="log-row-{{ $log->id }}">
                        <td>{{ $log->id }}</td>
                        <td><strong>{{ $log->EmpCode ?? '-' }}</strong></td>
                        <td style="max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $log->candidate_name }}">{{ $log->candidate_name ?? '-' }}</td>
                        <td><span class="fc-path" title="{{ $log->file_path }}">{{ $log->file_path }}</span></td>
                        <td><span class="fc-path" title="{{ $log->destination_path ?? '-' }}">{{ $log->destination_path ?? '-' }}</span></td>
                        <td><span class="fc-badge fc-badge-type">{{ $log->file_type }}</span></td>
                        <td>
                            @if($log->status == 'success')
                                <span class="fc-badge fc-badge-ok">OK</span>
                            @elseif($log->status == 'failed')
                                <span class="fc-badge fc-badge-fail">FAIL</span>
                            @else
                                <span class="fc-badge fc-badge-wait">WAIT</span>
                            @endif
                        </td>
                        <td><span class="fc-err" title="{{ $log->error_message }}">{{ $log->error_message ?? '-' }}</span></td>
                        <td class="text-center">{{ $log->retry_count }}</td>
                        <td style="font-size:10px;white-space:nowrap;">{{ \Carbon\Carbon::parse($log->created_at)->format('d-M-y H:i') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                @if($log->status == 'failed')
                                <button class="fc-btn fc-btn-retry retry-single" data-log-id="{{ $log->id }}" title="Retry"><i class="fa fa-refresh"></i></button>
                                @endif
                                <button class="fc-btn fc-btn-del delete-log" data-log-id="{{ $log->id }}" title="Delete"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center text-muted py-3" style="font-size:12px;">No logs found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-2">{{ $logs->appends(request()->query())->links() }}</div>
        </div>
    </div>
</div>

@endsection

@section('script_section')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('.retry-single').on('click', function() {
        const logId = $(this).data('log-id');
        const btn = $(this);
        Swal.fire({
            title: 'Retry File Copy?',
            text: 'Attempt to copy this file again',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Retry'
        }).then((result) => {
            if (result.isConfirmed) {
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');
                $.ajax({
                    url: '{{ url("admin/file-copy-retry") }}/' + logId,
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(r) {
                        if (r.status == 200) {
                            Swal.fire('Done', r.msg, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Error', r.msg, 'error');
                            btn.prop('disabled', false).html('<i class="fa fa-refresh"></i>');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Retry failed', 'error');
                        btn.prop('disabled', false).html('<i class="fa fa-refresh"></i>');
                    }
                });
            }
        });
    });

    $('.delete-log').on('click', function() {
        const logId = $(this).data('log-id');
        Swal.fire({
            title: 'Delete?',
            text: 'Remove this log entry permanently',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("admin/file-copy-delete") }}/' + logId,
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(r) {
                        if (r.status == 200) {
                            $('#log-row-' + logId).fadeOut(200, function() { $(this).remove(); });
                            Swal.fire('Deleted', r.msg, 'success');
                        } else {
                            Swal.fire('Error', r.msg, 'error');
                        }
                    },
                    error: function() { Swal.fire('Error', 'Delete failed', 'error'); }
                });
            }
        });
    });
});
</script>
@endsection
