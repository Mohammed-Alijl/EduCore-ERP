@extends('admin.layouts.master')

@section('title', trans('admin.exams.attempts.title'))

@section('css')
    {{-- DataTables CSS --}}
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    {{-- SweetAlert2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
    {{-- Exam CRUD Styles --}}
    <link href="{{ URL::asset('assets/admin/css/exam/crud-exam.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between exam-page">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <div class="mr-3 ml-3">
                    <span class="avatar-initial bg-gradient-primary shadow-sm">
                        <i class="las la-clipboard-list"></i>
                    </span>
                </div>
                <div>
                    <h4 class="content-title mb-0 my-auto font-weight-bold">{{ trans('admin.exams.attempts.title') }}</h4>
                    <span class="text-muted mt-1 tx-13 d-block">{{ trans('admin.exams.attempts.subtitle') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="exam-page">
        <div class="row row-sm">
            <div class="col-xl-12">

                {{-- ═══════════════════════════════════════════
                     Exam Info Banner
                ═══════════════════════════════════════════ --}}
                <div class="exam-info-banner">
                    <div class="d-flex flex-wrap justify-content-between align-items-start mb-2">
                        <div>
                            <h3>{{ $exam->title }}</h3>
                            <p class="exam-subtitle mb-0">
                                {{ $exam->subject->name ?? '-' }} &mdash; {{ $exam->academicYear->name ?? '-' }}
                            </p>
                        </div>
                        <a href="{{ route('admin.exams.index') }}" class="btn-back-exams mt-2 mt-md-0">
                            <i class="las la-arrow-left"></i>
                            {{ trans('admin.exams.attempts.back_to_exams') }}
                        </a>
                    </div>

                    <div class="exam-info-stats">
                        <div class="exam-stat-chip">
                            <i class="las la-chalkboard-teacher"></i>
                            {{ trans('admin.exams.attempts.info.teacher') }}: {{ $exam->teacher->name ?? '-' }}
                        </div>
                        <div class="exam-stat-chip">
                            <i class="las la-book-open"></i>
                            {{ trans('admin.exams.attempts.info.subject') }}: {{ $exam->subject->name ?? '-' }}
                        </div>
                        <div class="exam-stat-chip">
                            <i class="las la-question-circle"></i>
                            {{ trans('admin.exams.attempts.info.total_questions') }}: {{ $exam->total_questions }}
                        </div>
                        <div class="exam-stat-chip">
                            <i class="las la-redo-alt"></i>
                            {{ trans('admin.exams.attempts.info.max_attempts') }}: {{ $exam->max_attempts }}
                        </div>
                        <div class="exam-stat-chip">
                            <i class="las la-clock"></i>
                            {{ trans('admin.exams.attempts.info.duration') }}: {{ $exam->duration_minutes }}
                            {{ trans('admin.exams.attempts.info.minutes') }}
                        </div>
                    </div>
                </div>

                {{-- ═══════════════════════════════════════════
                     Attempts Table Card
                ═══════════════════════════════════════════ --}}
                <div class="glass-card">
                    <div class="glass-card-header">
                        <div class="d-flex align-items-center">
                            <div class="card-title-icon bg-gradient-info">
                                <i class="las la-users"></i>
                            </div>
                            <div class="card-title-text">
                                <h5>{{ trans('admin.exams.attempts.table.title') }}</h5>
                                <span>{{ trans('admin.exams.attempts.table.subtitle', ['count' => $attempts->count()]) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card-body">
                        @if ($attempts->count() > 0)
                            <div class="table-responsive">
                                <table class="table text-md-nowrap" id="attempts_table">
                                    <thead>
                                        <tr>
                                            <th class="wd-5p border-bottom-0">#</th>
                                            <th class="wd-20p border-bottom-0">
                                                {{ trans('admin.exams.attempts.table.student_name') }}</th>
                                            <th class="wd-15p border-bottom-0">
                                                {{ trans('admin.exams.attempts.table.started_at') }}</th>
                                            <th class="wd-15p border-bottom-0">
                                                {{ trans('admin.exams.attempts.table.completed_at') }}</th>
                                            <th class="wd-10p border-bottom-0 text-center">
                                                {{ trans('admin.exams.attempts.table.score') }}</th>
                                            <th class="wd-10p border-bottom-0 text-center">
                                                {{ trans('admin.exams.attempts.table.status') }}</th>
                                            @can('reset-attempts_exams')
                                                <th class="wd-15p border-bottom-0 text-center">
                                                    {{ trans('admin.global.actions') }}</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attempts as $attempt)
                                            <tr id="attempt-row-{{ $attempt->id }}">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div>
                                                            <span
                                                                class="font-weight-bold">{{ $attempt->student->name ?? '-' }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $attempt->started_at ? $attempt->started_at->format('Y-m-d H:i') : '-' }}
                                                </td>
                                                <td>
                                                    {{ $attempt->completed_at ? $attempt->completed_at->format('Y-m-d H:i') : '-' }}
                                                </td>
                                                <td class="text-center">
                                                    <span class="score-display">
                                                        {{ $attempt->score !== null ? $attempt->score : '-' }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @switch($attempt->status)
                                                        @case(\App\Models\ExamAttempt::STATUS_IN_PROGRESS)
                                                            <span class="badge-exam badge-in-progress">
                                                                <i class="las la-spinner"></i>
                                                                {{ trans('admin.exams.attempts.statuses.in_progress') }}
                                                            </span>
                                                        @break

                                                        @case(\App\Models\ExamAttempt::STATUS_COMPLETED)
                                                            <span class="badge-exam badge-completed">
                                                                <i class="las la-check-circle"></i>
                                                                {{ trans('admin.exams.attempts.statuses.completed') }}
                                                            </span>
                                                        @break

                                                        @case(\App\Models\ExamAttempt::STATUS_TIMEOUT)
                                                            <span class="badge-exam badge-timeout">
                                                                <i class="las la-hourglass-end"></i>
                                                                {{ trans('admin.exams.attempts.statuses.timeout') }}
                                                            </span>
                                                        @break
                                                    @endswitch
                                                </td>
                                                @can('reset-attempts_exams')
                                                    <td class="text-center">
                                                        <button type="button" class="btn-reset-attempt"
                                                            data-exam-id="{{ $exam->id }}"
                                                            data-student-id="{{ $attempt->student_id }}"
                                                            data-student-name="{{ $attempt->student->name ?? '' }}">
                                                            <i class="las la-undo-alt"></i>
                                                            {{ trans('admin.exams.attempts.reset_attempt') }}
                                                        </button>
                                                    </td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="las la-inbox d-block"></i>
                                <p>{{ trans('admin.exams.attempts.no_attempts') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('admin.layouts.scripts.datatable_config')

    <script>
        $(document).ready(function() {

            // ═══════════════════════════════════════════
            //  Initialize DataTable (client-side)
            // ═══════════════════════════════════════════
            @if ($attempts->count() > 0)
                $('#attempts_table').DataTable({
                    ...globalTableConfig,
                    language: $.extend({}, datatable_lang),
                    paging: true,
                    ordering: true,
                    info: true,
                    columnDefs: [{
                        orderable: false,
                        targets: [-1]
                    }]
                });
            @endif

            // ═══════════════════════════════════════════
            //  Reset Attempt — SweetAlert2 Confirmation
            // ═══════════════════════════════════════════
            $(document).on('click', '.btn-reset-attempt', function() {
                var btn = $(this);
                var examId = btn.data('exam-id');
                var studentId = btn.data('student-id');
                var studentName = btn.data('student-name');

                Swal.fire({
                    title: '{{ trans('admin.exams.attempts.swal.title') }}',
                    html: '{!! trans('admin.exams.attempts.swal.text') !!}' +
                        '<br><strong class="text-danger">' + studentName + '</strong>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="las la-undo-alt mr-1 ml-1"></i> {{ trans('admin.exams.attempts.swal.confirm') }}',
                    cancelButtonText: '{{ trans('admin.global.cancel') }}',
                    reverseButtons: true,
                    customClass: {
                        popup: 'shadow-lg',
                        confirmButton: 'rounded-pill px-4',
                        cancelButton: 'rounded-pill px-4'
                    }
                }).then(function(result) {
                    if (result.isConfirmed) {

                        // Show loading
                        Swal.fire({
                            title: '{{ trans('admin.exams.attempts.swal.processing') }}',
                            allowOutsideClick: false,
                            didOpen: function() {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: "{{ route('admin.exams.resetAttempt', ':exam') }}"
                                .replace(':exam', examId),
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                student_id: studentId
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: '{{ trans('admin.exams.attempts.swal.success_title') }}',
                                    text: response.message ||
                                        '{{ trans('admin.exams.messages.success.attempt_reset') }}',
                                    icon: 'success',
                                    confirmButtonColor: '#6366f1',
                                    confirmButtonText: '{{ trans('admin.global.ok') }}',
                                    customClass: {
                                        confirmButton: 'rounded-pill px-4'
                                    }
                                });

                                // Fade-out the row
                                btn.closest('tr').fadeOut(500, function() {
                                    $(this).remove();
                                });
                            },
                            error: function(xhr) {
                                var errorMsg = xhr.responseJSON ?
                                    xhr.responseJSON.message :
                                    '{{ trans('admin.exams.messages.failed.attempt_reset') }}';

                                Swal.fire({
                                    title: '{{ trans('admin.global.error_title') }}',
                                    text: errorMsg,
                                    icon: 'error',
                                    confirmButtonColor: '#6366f1',
                                    confirmButtonText: '{{ trans('admin.global.ok') }}',
                                    customClass: {
                                        confirmButton: 'rounded-pill px-4'
                                    }
                                });
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
