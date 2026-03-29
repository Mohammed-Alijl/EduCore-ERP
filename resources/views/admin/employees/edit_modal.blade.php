<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ trans('admin.employees.edit') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" method="POST" class="ajax-form" data-modal-id="#editEmployeeModal"
                enctype="multipart/form-data" data-parsley-validate="">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <!-- Employee Information -->
                    <h6 class="mb-3 text-primary"><i class="fas fa-user-tie"></i>
                        {{ trans('admin.employees.employee_information') }}</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.name_ar') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name[ar]" id="edit_emp_name_ar" class="form-control"
                                    placeholder="{{ trans('admin.employees.fields.name_ar') }}" required minlength="3"
                                    maxlength="100" autocomplete="off">
                                <span class="text-danger error-text name_ar_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.name_en') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name[en]" id="edit_emp_name_en" class="form-control"
                                    placeholder="{{ trans('admin.employees.fields.name_en') }}" required minlength="3"
                                    maxlength="100" autocomplete="off">
                                <span class="text-danger error-text name_en_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.email') }} <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="edit_emp_email"
                                    placeholder="employee@edu.com" required minlength="5" maxlength="100"
                                    autocomplete="off">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.national_id') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control numeric-only" name="national_id"
                                    id="edit_emp_national_id" required minlength="10" maxlength="50" autocomplete="off">
                                <span class="text-danger error-text national_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.phone') }}</label>
                                <input type="text" class="form-control numeric-only" name="phone"
                                    id="edit_emp_phone" maxlength="20">
                                <span class="text-danger error-text phone_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.gender') }} <span
                                        class="text-danger">*</span></label>
                                <select name="gender_id" id="edit_emp_gender_id" class="form-control select2"
                                    required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text gender_id_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.password') }}</label>
                                <input type="password" class="form-control" name="password" id="edit_emp_password"
                                    minlength="8" maxlength="30">
                                <span class="text-danger error-text password_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.password_confirmation') }}</label>
                                <input type="password" name="password_confirmation" class="form-control" minlength="8"
                                    maxlength="30" data-parsley-equalto="#edit_emp_password">
                                <span class="text-danger error-text password_confirmation_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.nationality') }} <span
                                        class="text-danger">*</span></label>
                                <select name="nationality_id" id="edit_emp_nationality_id"
                                    class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
                                    @foreach ($nationalities as $nationality)
                                        <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text nationality_id_error"></span>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.religion') }} <span
                                        class="text-danger">*</span></label>
                                <select name="religion_id" id="edit_emp_religion_id" class="form-control select2"
                                    required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
                                    @foreach ($religions as $religion)
                                        <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text religion_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.blood_type') }} <span
                                        class="text-danger">*</span></label>
                                <select name="blood_type_id" id="edit_emp_blood_type_id" class="form-control select2"
                                    required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
                                    @foreach ($blood_types as $blood_type)
                                        <option value="{{ $blood_type->id }}">{{ $blood_type->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text blood_type_id_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.department') }} <span
                                        class="text-danger">*</span></label>
                                <select name="department_id" id="edit_emp_department_id" class="form-control select2"
                                    required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text department_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.designation') }} <span
                                        class="text-danger">*</span></label>
                                <select name="designation_id" id="edit_emp_designation_id"
                                    class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
                                    <!-- Options will be loaded via AJAX based on Department -->
                                </select>
                                <span class="text-danger error-text designation_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.specializations.title') ?? 'Specialization' }}</label>
                                <select name="specialization_id" id="edit_emp_specialization_id"
                                    class="form-control select2">
                                    <option value="" selected>-- {{ trans('admin.global.select') }} --</option>
                                    @foreach ($specializations as $specialization)
                                        <option value="{{ $specialization->id }}">{{ $specialization->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text specialization_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.joining_date') }} <span
                                        class="text-danger">*</span></label>
                                <input class="form-control edit-emp-fc-datepicker" id="edit_emp_joining_date"
                                    placeholder="YYYY-MM-DD" type="text" required name="joining_date"
                                    autocomplete="off">
                                <span class="text-danger error-text joining_date_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.contract_type') }} <span
                                        class="text-danger">*</span></label>
                                <select name="contract_type" id="edit_emp_contract_type" class="form-control select2"
                                    required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
                                    <option value="full_time">{{ trans('admin.employees.contract_types.full_time') }}
                                    </option>
                                    <option value="part_time">{{ trans('admin.employees.contract_types.part_time') }}
                                    </option>
                                    <option value="contract">{{ trans('admin.employees.contract_types.contract') }}
                                    </option>
                                </select>
                                <span class="text-danger error-text contract_type_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.basic_salary') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="basic_salary" id="edit_emp_basic_salary"
                                    class="form-control" step="0.01" min="0" max="999999" required>
                                <span class="text-danger error-text basic_salary_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.bank_account_number') }}</label>
                                <input type="text" name="bank_account_number" id="edit_emp_bank_account_number"
                                    class="form-control" maxlength="50">
                                <span class="text-danger error-text bank_account_number_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.status') }} <span
                                        class="text-danger">*</span></label>
                                <select name="status" id="edit_emp_status" class="form-control" required>
                                    <option value="1">{{ trans('admin.global.active') }}</option>
                                    <option value="0">{{ trans('admin.global.disabled') }}</option>
                                </select>
                                <span class="text-danger error-text status_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.address') }}</label>
                                <input type="text" name="address" id="edit_emp_address" class="form-control"
                                    maxlength="500">
                                <span class="text-danger error-text address_error"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Attachments -->
                    <h6 class="mb-3 mt-4 text-primary"><i class="fas fa-paperclip"></i>
                        {{ trans('admin.employees.fields.attachments') }}</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.image') }}</label>
                                <input type="file" class="form-control" name="image" id="employee_image_edit"
                                    accept="image/*">
                                <span class="text-danger error-text image_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('admin.employees.fields.attachments') }}</label>
                                <input type="file" class="form-control" name="attachments[]"
                                    id="employee_attachments_edit" multiple>
                                <span class="text-danger error-text attachments_error"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <span class="spinner-border spinner-border-sm d-none"></span>
                        <i class="fas fa-save"></i> {{ trans('admin.global.save') }}
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> {{ trans('admin.global.cancel') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {

            /* ===============================
            FILE INPUT INITIALIZATION
            =============================== */
            function safeJson(value, fallback = []) {
                if (Array.isArray(value)) return value;
                if (typeof value !== 'string' || value.trim() === '') return fallback;

                try {
                    const parsed = JSON.parse(value);
                    return Array.isArray(parsed) ? parsed : fallback;
                } catch (e) {
                    return fallback;
                }
            }

            function initEditFileInputs(imagePreviewUrl = [], attachmentsPreviewUrls = [], attachmentsConfig = []) {
                if ($('#employee_image_edit').data('fileinput')) {
                    $('#employee_image_edit').fileinput('destroy');
                }

                if ($('#employee_attachments_edit').data('fileinput')) {
                    $('#employee_attachments_edit').fileinput('destroy');
                }

                $('#employee_image_edit').fileinput({
                    theme: 'fa5',
                    language: '{{ app()->getLocale() }}',
                    showUpload: false,
                    showRemove: true,
                    overwriteInitial: true,
                    initialPreviewAsData: true,
                    initialPreview: imagePreviewUrl,
                    initialPreviewConfig: imagePreviewUrl.length ? [{
                        type: 'image',
                        caption: imagePreviewUrl[0].split('/').pop()
                    }] : [],
                    allowedFileExtensions: ['jpg', 'jpeg', 'png', 'svg', 'webp'],
                    maxFileSize: 2048,
                    browseOnZoneClick: true,
                });

                $('#employee_attachments_edit').fileinput({
                    theme: 'fa5',
                    language: '{{ app()->getLocale() }}',
                    showUpload: false,
                    showCaption: true,
                    overwriteInitial: false,
                    initialPreviewAsData: true,
                    initialPreview: attachmentsPreviewUrls,
                    initialPreviewConfig: attachmentsConfig,
                    deleteExtraData: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    allowedFileExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'svg', 'zip'],
                    maxFileSize: 5120,
                    maxFileCount: 5,
                    browseOnZoneClick: true,
                });
            }

            /* ===============================
            WHEN MODAL OPENS
            =============================== */
            $('#editEmployeeModal').on('shown.bs.modal', function(event) {
                let button = $(event.relatedTarget);

                let imageUrl = button.data('image');
                let imageArray = imageUrl ? [imageUrl] : [];
                let attachments = safeJson(button.attr('data-attachments'), button.data('attachments') ||
                []);
                let configs = safeJson(button.attr('data-configs'), button.data('configs') || []);

                initEditFileInputs(imageArray, attachments, configs);
            });

            /* ===============================
            HELPERS
            =============================== */
            $('#editEmployeeModal').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset');
                $('.error-text').text('');
            });

            /* ===============================
            AJAX DEPENDENT DROPDOWNS
            =============================== */
            var initialDesignationId = null;

            $('#editEmployeeModal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                initialDesignationId = button.data('designation_id');
            });

            $('#edit_emp_department_id').on('change', function() {
                var department_id = $(this).val();
                if (department_id) {
                    $.ajax({
                        url: "{{ route('admin.get_designations') }}",
                        type: "GET",
                        data: { department_id: department_id },
                        success: function(data) {
                            var designationSelect = $('#edit_emp_designation_id');
                            designationSelect.empty();
                            designationSelect.append('<option value="" disabled selected>-- {{ trans("admin.global.select") }} --</option>');
                            $.each(data, function(key, value) {
                                designationSelect.append('<option value="' + value.id + '" data-can-teach="' + value.can_teach + '">' + value.name + '</option>');
                            });

                            if (initialDesignationId) {
                                designationSelect.val(initialDesignationId);
                                initialDesignationId = null;
                            }
                            designationSelect.trigger('change');
                        }
                    });
                } else {
                    $('#edit_emp_designation_id').empty();
                    $('#edit_emp_designation_id').trigger('change');
                }
            });

            $('#edit_emp_designation_id').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var canTeach = selectedOption.data('can-teach');

                if (canTeach == 0 || !canTeach) {
                    $('#edit_emp_specialization_id').val('').trigger('change');
                    $('#edit_emp_specialization_id').prop('disabled', true);
                } else {
                    $('#edit_emp_specialization_id').prop('disabled', false);
                }
            });

            /* Datepicker */
            $('.edit-emp-fc-datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                showOtherMonths: true,
                selectOtherMonths: true,
                beforeShow: function(input, inst) {
                    setTimeout(function() {
                        inst.dpDiv.css({
                            'z-index': 999999,
                            'position': 'relative'
                        });
                    }, 0);
                }
            });

            /* Telephone Input */
            if ($("#edit_emp_phone").length) {
                var editInput = document.querySelector("#edit_emp_phone");
                window.intlTelInput(editInput, {
                    onlyCountries: ["ps", "sa", "eg", "jo", "qa", "us"],
                    initialCountry: "ps",
                    utilsScript: "{{ URL::asset('assets/admin/plugins/telephoneinput/utils.js') }}",
                });
            }
        });
    </script>
@endpush
