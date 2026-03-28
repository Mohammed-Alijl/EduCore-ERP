<a href="#" class="text-primary font-weight-bold emp-show-btn"
   data-toggle="modal"
   data-target="#showEmployeeModal"
   data-employee_code="{{ $row->employee_code }}"
   data-designation="{{ optional($row->designation)->name }}"
   data-name_ar="{{ $row->getTranslation('name', 'ar') }}"
   data-name_en="{{ $row->getTranslation('name', 'en') }}"
   data-email="{{ $row->email }}"
   data-national_id="{{ $row->national_id }}"
   data-gender="{{ optional($row->gender)->name }}"
   data-blood_type="{{ optional($row->bloodType)->name }}"
   data-nationality="{{ optional($row->nationality)->name }}"
   data-religion="{{ optional($row->religion)->name }}"
   data-specialization="{{ optional($row->specialization)->name ?? '-' }}"
   data-joining_date="{{ $row->joining_date->format('Y-m-d') }}"
   data-address="{{ $row->address }}"
   data-phone="{{ $row->phone }}"
   data-status="{{ $row->status ? trans('admin.global.active') : trans('admin.global.disabled') }}"
   data-image="{{ $row->imageUrl }}"
   data-attachments='@json($row->attachments->map(function($att) {
       return [
           "url" => asset("storage/" . $att->attachment_path),
           "name" => basename($att->attachment_path)
       ];
   }))'>
    {{ $row->employee_code }}
</a>
