<div class="attendance-page">
    <form id="attendanceForm" method="POST" data-parsley-validate>
        @csrf

        <input type="hidden" name="attendance_date" value="{{ request('attendance_date', now()->toDateString()) }}">
        <input type="hidden" name="academic_year_id" value="{{ request('academic_year_id') }}">
        <input type="hidden" name="grade_id" value="{{ request('grade_id') }}">
        <input type="hidden" name="classroom_id" value="{{ request('classroom_id') }}">
        <input type="hidden" name="section_id" value="{{ request('section_id') }}">

        <div class="glass-card students-card">
            <div class="glass-card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h5 class="mb-2 mb-md-0 font-weight-bold">{{ trans('admin.HR.attendances.students_list') }}</h5>
                    <span class="badge badge-primary px-3 py-2">{{ $students->count() }}
                        {{ trans('admin.HR.attendances.student') }}</span>
                </div>

                <div class="students-table-wrap table-responsive">
                    <table class="table students-table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>{{ trans('admin.HR.attendances.student_details') }}</th>
                                <th style="min-width: 340px;">{{ trans('admin.HR.attendances.attendance_status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                @php
                                    $currentStatus = (int) optional($student->attendances->first())->attendance_status;
                                    if (!$currentStatus) {
                                        $currentStatus = 1;
                                    }

                                    $avatar = $student->image ? asset('storage/' . $student->image) : null;
                                    $initial = mb_substr($student->name ?? 'S', 0, 1);
                                @endphp

                                <tr>
                                    <td>
                                        <span class="font-weight-bold text-muted">{{ $loop->iteration }}</span>
                                    </td>

                                    <td>
                                        <div class="student-meta">
                                            @if ($avatar)
                                                <img src="{{ $avatar }}" alt="{{ $student->name }}"
                                                    class="student-avatar">
                                            @else
                                                <span class="student-avatar">{{ $initial }}</span>
                                            @endif

                                            <div>
                                                <p class="student-name">{{ $student->name }}</p>
                                                <p class="student-code">{{ $student->student_code }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <input type="hidden" name="attendances[{{ $loop->index }}][student_id]"
                                            value="{{ $student->id }}">

                                        <div class="status-pills">
                                            <div>
                                                <input class="status-radio" type="radio"
                                                    id="status_present_{{ $student->id }}"
                                                    name="attendances[{{ $loop->index }}][attendance_status]"
                                                    value="1" {{ $currentStatus === 1 ? 'checked' : '' }}>
                                                <label class="status-pill present"
                                                    for="status_present_{{ $student->id }}">
                                                    {{ trans('admin.HR.attendances.present') }}
                                                </label>
                                            </div>

                                            <div>
                                                <input class="status-radio" type="radio"
                                                    id="status_absent_{{ $student->id }}"
                                                    name="attendances[{{ $loop->index }}][attendance_status]"
                                                    value="2" {{ $currentStatus === 2 ? 'checked' : '' }}>
                                                <label class="status-pill absent"
                                                    for="status_absent_{{ $student->id }}">
                                                    {{ trans('admin.HR.attendances.absent') }}
                                                </label>
                                            </div>

                                            <div>
                                                <input class="status-radio" type="radio"
                                                    id="status_late_{{ $student->id }}"
                                                    name="attendances[{{ $loop->index }}][attendance_status]"
                                                    value="3" {{ $currentStatus === 3 ? 'checked' : '' }}>
                                                <label class="status-pill late" for="status_late_{{ $student->id }}">
                                                    {{ trans('admin.HR.attendances.late') }}
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted font-weight-bold">
                                        {{ trans('admin.HR.attendances.no_students') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @can('create_attendances')
                    <div class="submit-bar">
                        <button type="submit" class="btn save-attendance-btn" id="saveAttendanceBtn">
                            <span class="spinner-border spinner-border-sm d-none" id="saveAttendanceSpinner"></span>
                            <i class="las la-save mr-1 ml-1"></i>
                            {{ trans('admin.HR.attendances.save') }}
                        </button>
                    </div>
                @endcan

            </div>
        </div>
    </form>
</div>
