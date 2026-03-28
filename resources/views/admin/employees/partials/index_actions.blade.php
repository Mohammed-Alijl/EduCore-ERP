@canany(['edit_employees', 'delete_employees'])
    <div class="teacher-actions-container">
        @can('edit_employees')
            @php
                $attachmentUrls = [];
                $attachmentConfigs = [];

                if ($row->attachments->count() > 0) {
                    foreach ($row->attachments as $attachment) {
                        $filePath = $attachment->attachment_path;
                        $fullUrl = asset('storage/' . $filePath);
                        $attachmentUrls[] = $fullUrl;

                        $fileName = basename($filePath);
                        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

                        if (in_array($extension, ['jpg', 'jpeg', 'png', 'svg'])) {
                            $type = 'image';
                        } elseif ($extension == 'pdf') {
                            $type = 'pdf';
                        } elseif (in_array($extension, ['doc', 'docx'])) {
                            $type = 'office';
                        } else {
                            $type = 'other';
                        }

                        $attachmentConfigs[] = [
                            'caption' => $fileName,
                            'type' => $type,
                            'url' => route('admin.employees.attachments.destroy', $attachment->id),
                            'key' => $attachment->id,
                        ];
                    }
                }
            @endphp
            <a class="btn btn-teacher-edit btn-sm edit-btn" href="#" data-toggle="modal" data-target="#editEmployeeModal"
               data-url="{{ route('admin.employees.update', $row->id) }}"
               data-name_ar="{{ $row->getTranslation('name', 'ar') }}"
               data-name_en="{{ $row->getTranslation('name', 'en') }}"
               data-email="{{ $row->email }}" 
               data-national_id="{{ $row->national_id }}"
               data-gender_id="{{ $row->gender_id }}" 
               data-blood_type_id="{{ $row->blood_type_id }}"
               data-nationality_id="{{ $row->nationality_id }}" 
               data-religion_id="{{ $row->religion_id }}"
               data-specialization_id="{{ $row->specialization_id }}" 
               data-department_id="{{ $row->department_id }}"
               data-designation_id="{{ $row->designation_id }}" 
               data-contract_type="{{ $row->contract_type }}"
               data-basic_salary="{{ $row->basic_salary }}" 
               data-bank_account_number="{{ $row->bank_account_number }}"
               data-joining_date="{{ $row->joining_date->format('Y-m-d') }}" 
               data-address="{{ $row->address }}"
               data-phone="{{ $row->phone }}" 
               data-status="{{ $row->status }}"
               data-image="{{ $row->image ? \Illuminate\Support\Facades\Storage::disk('public')->url($row->image) : '' }}"
               data-attachments='@json($attachmentUrls)' data-configs='@json($attachmentConfigs)'>
                <i class="las la-pen"></i> {{ trans('admin.global.edit') }}
            </a>
        @endcan
        @can('delete_employees')
            <a class="modal-effect btn btn-sm btn-teacher-archive delete-item" href="#"
               data-id="{{ $row->id }}" data-url="{{ route('admin.employees.destroy', $row->id) }}"
               data-name="{{ $row->name }}">
                <i class="las la-trash"></i> {{ trans('admin.global.archive') }}
            </a>
        @endcan
    </div>
@endcanany
