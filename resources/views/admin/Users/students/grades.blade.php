@extends('admin.layouts.master')

@section('title', trans('admin.Users.students.grades.title') . ' - ' . $student['name'])

@section('css')
    <link href="{{ URL::asset('assets/admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/admin/css/Users/student/grades.css') }}" rel="stylesheet">
@endsection

@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <div class="mr-3 ml-3">
                    <span class="avatar-initial bg-gradient-primary shadow-sm">
                        <i class="las la-chart-bar"></i>
                    </span>
                </div>
                <div>
                    <h4 class="content-title mb-0 my-auto font-weight-bold">{{ trans('admin.Users.students.grades.title') }}</h4>
                    <span class="text-muted mt-1 tx-13 d-block">{{ $student['name'] }}</span>
                </div>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center">
            <div class="mb-3 mb-xl-0 ml-2">
                <a class="btn btn-modern btn-outline-secondary" href="{{ route('admin.Users.students.index') }}">
                    <i class="las la-arrow-left tx-16 mr-1 ml-1"></i>
                    {{ trans('admin.global.back') }}
                </a>
            </div>
            <div class="mb-3 mb-xl-0 ml-2">
                <button class="btn btn-modern btn-primary shadow-sm" onclick="window.print()">
                    <i class="las la-print tx-16 mr-1 ml-1"></i>
                    {{ trans('admin.global.print') }}
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="grades-report-container">
        <div class="grades-header-card">
            <div class="grades-student-info">
                <div class="grades-avatar-wrapper">
                    <img src="{{ $student['image_url'] }}" alt="{{ $student['name'] }}" class="grades-avatar-img">
                </div>
                <div class="grades-student-details">
                    <h3 class="grades-student-name">{{ $student['name'] }}</h3>
                    <div class="grades-student-meta">
                        <span class="grades-meta-item">
                            <i class="las la-barcode"></i>
                            {{ $student['student_code'] }}
                        </span>
                        @if ($student['grade'])
                            <span class="grades-meta-item">
                                <i class="las la-layer-group"></i>
                                {{ $student['grade'] }}
                            </span>
                        @endif
                        @if ($student['classroom'])
                            <span class="grades-meta-item">
                                <i class="las la-chalkboard"></i>
                                {{ $student['classroom'] }}
                            </span>
                        @endif
                        @if ($student['section'])
                            <span class="grades-meta-item">
                                <i class="las la-users"></i>
                                {{ $student['section'] }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grades-year-selector">
                <label class="grades-year-label">{{ trans('admin.Users.students.grades.academic_year') }}</label>
                <select class="form-control" id="academic_year_select">
                    @foreach ($academic_years as $year)
                        <option value="{{ $year->id }}"
                            {{ $academic_year && $year->id === $academic_year->id ? 'selected' : '' }}>
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grades-summary-section">
            <div class="grades-summary-grid">
                <div class="grades-summary-card grades-card-overall {{ $summary['overall_color'] }}">
                    <div class="grades-summary-icon">
                        <i class="las la-trophy"></i>
                    </div>
                    <div class="grades-summary-content">
                        <span class="grades-summary-label">{{ trans('admin.Users.students.grades.overall_grade') }}</span>
                        <span class="grades-summary-value">
                            @if ($summary['overall_grade'])
                                {{ $summary['overall_grade'] }}
                            @else
                                —
                            @endif
                        </span>
                        <span class="grades-summary-percentage">
                            @if ($summary['overall_percentage'] !== null)
                                {{ $summary['overall_percentage'] }}%
                            @else
                                {{ trans('admin.Users.students.grades.no_exams') }}
                            @endif
                        </span>
                    </div>
                </div>

                <div class="grades-summary-card grades-card-subjects">
                    <div class="grades-summary-icon">
                        <i class="las la-book"></i>
                    </div>
                    <div class="grades-summary-content">
                        <span class="grades-summary-label">{{ trans('admin.Users.students.grades.subjects') }}</span>
                        <span
                            class="grades-summary-value">{{ $summary['subjects_with_exams'] }}/{{ $summary['total_subjects'] }}</span>
                        <span class="grades-summary-hint">{{ trans('admin.Users.students.grades.with_exams') }}</span>
                    </div>
                </div>

                <div class="grades-summary-card grades-card-exams">
                    <div class="grades-summary-icon">
                        <i class="las la-file-alt"></i>
                    </div>
                    <div class="grades-summary-content">
                        <span class="grades-summary-label">{{ trans('admin.Users.students.grades.total_exams') }}</span>
                        <span class="grades-summary-value">{{ $summary['total_exams'] }}</span>
                        <span class="grades-summary-hint">{{ trans('admin.Users.students.grades.completed') }}</span>
                    </div>
                </div>

                <div class="grades-summary-card grades-card-score">
                    <div class="grades-summary-icon">
                        <i class="las la-calculator"></i>
                    </div>
                    <div class="grades-summary-content">
                        <span class="grades-summary-label">{{ trans('admin.Users.students.grades.total_score') }}</span>
                        <span
                            class="grades-summary-value">{{ $summary['overall_score'] }}/{{ $summary['overall_marks'] }}</span>
                        <span class="grades-summary-hint">{{ trans('admin.Users.students.grades.points') }}</span>
                    </div>
                </div>
            </div>

            @if ($summary['subjects_with_exams'] > 0)
                <div class="grades-distribution-card">
                    <h5 class="grades-distribution-title">
                        <i class="las la-chart-pie"></i>
                        {{ trans('admin.Users.students.grades.grade_distribution') }}
                    </h5>
                    <div class="grades-distribution-bars">
                        @foreach ($summary['grade_distribution'] as $letter => $count)
                            @php
                                $color = match ($letter) {
                                    'A+', 'A' => 'success',
                                    'B+', 'B' => 'primary',
                                    'C+', 'C' => 'info',
                                    'D' => 'warning',
                                    'F' => 'danger',
                                };
                            @endphp
                            <div class="grades-distribution-item {{ $count > 0 ? 'has-count' : '' }}">
                                <div class="grades-distribution-bar bg-{{ $color }}"
                                    style="height: {{ $count > 0 ? min($count * 25, 100) : 5 }}%"></div>
                                <span class="grades-distribution-letter">{{ $letter }}</span>
                                <span class="grades-distribution-count">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="grades-subjects-section">
            <h4 class="grades-section-title">
                <i class="las la-book-open"></i>
                {{ trans('admin.Users.students.grades.subjects_breakdown') }}
            </h4>

            @if ($subjects->isEmpty())
                <div class="grades-empty-state">
                    <div class="grades-empty-icon">
                        <i class="las la-book"></i>
                    </div>
                    <p class="grades-empty-message">{{ trans('admin.Users.students.grades.no_subjects') }}</p>
                </div>
            @else
                <div class="grades-subjects-grid">
                    @foreach ($subjects as $subject)
                        <div class="grades-subject-card {{ $subject['exam_count'] > 0 ? 'has-exams' : 'no-exams' }}">
                            <div class="grades-subject-header">
                                <div class="grades-subject-info">
                                    <h5 class="grades-subject-name">{{ $subject['name'] }}</h5>
                                    <span class="grades-exam-count">
                                        {{ $subject['exam_count'] }} {{ trans('admin.Users.students.grades.exams') }}
                                    </span>
                                </div>
                                @if ($subject['average_percentage'] !== null)
                                    <div class="grades-subject-grade">
                                        <span class="grades-grade-letter badge-{{ $subject['grade_color'] }}">
                                            {{ $subject['grade_letter'] }}
                                        </span>
                                        <span class="grades-grade-percentage">{{ $subject['average_percentage'] }}%</span>
                                    </div>
                                @else
                                    <div class="grades-subject-grade">
                                        <span class="grades-no-grade">—</span>
                                    </div>
                                @endif
                            </div>

                            @if ($subject['exam_count'] > 0)
                                <div class="grades-progress-wrapper">
                                    <div class="grades-progress-bar">
                                        <div class="grades-progress-fill bg-{{ $subject['grade_color'] }}"
                                            style="width: {{ $subject['average_percentage'] }}%"></div>
                                    </div>
                                    <span
                                        class="grades-progress-text">{{ $subject['total_score'] }}/{{ $subject['total_marks'] }}</span>
                                </div>

                                <div class="grades-exams-list">
                                    @foreach ($subject['exams'] as $exam)
                                        <div class="grades-exam-item">
                                            <div class="grades-exam-info">
                                                <span class="grades-exam-title">{{ $exam['title'] }}</span>
                                                <span class="grades-exam-date">{{ $exam['date'] }}</span>
                                            </div>
                                            <div class="grades-exam-score">
                                                <span class="grades-score-badge badge-{{ $exam['grade_color'] }}">
                                                    {{ $exam['score'] }}/{{ $exam['total_marks'] }}
                                                </span>
                                                <span class="grades-score-letter">{{ $exam['grade_letter'] }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="grades-no-exams-message">
                                    <i class="las la-info-circle"></i>
                                    {{ trans('admin.Users.students.grades.no_exams_for_subject') }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    </div>
    </div>
@endsection

@section('js')
    <script src="{{ URL::asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#academic_year_select').on('change', function() {
                var yearId = $(this).val();
                var url = "{{ route('admin.Users.students.grades', $student['id']) }}";
                url += '?academic_year_id=' + yearId;
                window.location.href = url;
            });
        });
    </script>
@endsection
