<!-- Add Teacher Modal -->
<div class="modal fade" id="addModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">{{ trans('admin.Users.teachers.add') }}</h6>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('admin.Users.teachers.store') }}" method="POST" class="ajax-form"
                data-modal-id="#addModal" enctype="multipart/form-data" data-parsley-validate="">
                @csrf

                <div class="modal-body">

                    <!-- Teacher Information -->
                    <h6 class="mb-3 text-primary"><i class="fas fa-user-tie"></i>
                        {{ trans('admin.Users.teachers.teacher_information') }}</h6>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.name_ar') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name[ar]" id="name_ar" class="form-control"
                                    placeholder="{{ trans('admin.Users.teachers.fields.name_ar') }}" required minlength="3"
                                    maxlength="100" autocomplete="off">
                                <span class="text-danger error-text name_ar_error"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.name_en') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name[en]" id="name_en" class="form-control"
                                    placeholder="{{ trans('admin.Users.teachers.fields.name_en') }}" required minlength="3"
                                    maxlength="100" autocomplete="off">
                                <span class="text-danger error-text name_en_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.email') }} <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="teacher@edu.com" required minlength="5" maxlength="100"
                                    autocomplete="off">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.national_id') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control numeric-only" name="national_id"
                                    id="national_id" required minlength="10" maxlength="10" autocomplete="off">
                                <span class="text-danger error-text national_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.password') }} <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" id="password" required
                                    minlength="8" maxlength="30">
                                <span class="text-danger error-text password_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.password_confirmation') }} <span
                                        class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required
                                    minlength="8" maxlength="30" data-parsley-equalto="#password">
                                <span class="text-danger error-text password_confirmation_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.gender') }} <span
                                        class="text-danger">*</span></label>
                                <select name="gender_id" class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
                                    @foreach ($genders as $gender)
                                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text gender_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.blood_type') }} <span
                                        class="text-danger">*</span></label>
                                <select name="blood_type_id" class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
                                    @foreach ($blood_types as $blood_type)
                                        <option value="{{ $blood_type->id }}">{{ $blood_type->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text blood_type_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.nationality') }} <span
                                        class="text-danger">*</span></label>
                                <select name="nationality_id" class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
                                    @foreach ($nationalities as $nationality)
                                        <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text nationality_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.religion') }} <span
                                        class="text-danger">*</span></label>
                                <select name="religion_id" class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
                                    @foreach ($religions as $religion)
                                        <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text religion_id_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.employees.fields.department') }} <span
                                        class="text-danger">*</span></label>
                                <select name="department_id" class="form-control select2" required>
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
                                <label>{{ trans('admin.Users.employees.fields.designation') }} <span
                                        class="text-danger">*</span></label>
                                <select name="designation_id" class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
                                    @foreach ($designations as $designation)
                                        @if ($designation->can_teach)
                                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <span class="text-danger error-text designation_id_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.HR.specializations.title') ?? 'Specialization' }} <span
                                        class="text-danger">*</span></label>
                                <select name="specialization_id" class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
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
                                <label>{{ trans('admin.Users.teachers.fields.joining_date') }} <span
                                        class="text-danger">*</span></label>
                                <input class="form-control fc-datepicker" placeholder="YYYY-MM-DD" type="text"
                                    required name="joining_date" autocomplete="off">
                                <span class="text-danger error-text joining_date_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.employees.fields.contract_type') }} <span
                                        class="text-danger">*</span></label>
                                <select name="contract_type" class="form-control select2" required>
                                    <option value="" disabled selected>-- {{ trans('admin.global.select') }} --
                                    </option>
                                    <option value="full_time">{{ trans('admin.Users.employees.contract_types.full_time') }}
                                    </option>
                                    <option value="part_time">{{ trans('admin.Users.employees.contract_types.part_time') }}
                                    </option>
                                    <option value="contract">{{ trans('admin.Users.employees.contract_types.contract') }}
                                    </option>
                                </select>
                                <span class="text-danger error-text contract_type_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.employees.fields.basic_salary') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="basic_salary" class="form-control" step="0.01"
                                    min="0" required>
                                <span class="text-danger error-text basic_salary_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.employees.fields.bank_account_number') }}</label>
                                <input type="text" name="bank_account_number" class="form-control"
                                    maxlength="255">
                                <span class="text-danger error-text bank_account_number_error"></span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.phone') }}</label>
                                <input type="text" class="form-control numeric-only" name="phone"
                                    id="phone" maxlength="20">
                                <span class="text-danger error-text phone_error"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.address') }}</label>
                                <input type="text" name="address" class="form-control" maxlength="500">
                                <span class="text-danger error-text address_error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.status') }} <span
                                        class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="1" selected>{{ trans('admin.global.active') }}</option>
                                    <option value="0">{{ trans('admin.global.disabled') }}</option>
                                </select>
                                <span class="text-danger error-text status_error"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Attachments with Krajee -->
                    <h6 class="mb-3 mt-4 text-primary"><i class="fas fa-paperclip"></i>
                        {{ trans('admin.Users.teachers.fields.attachments') }}</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.image') }}</label>
                                <input type="file" class="form-control" name="image" id="teacher_image"
                                    accept="image/*">
                                <span class="text-danger error-text image_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('admin.Users.teachers.fields.attachments') }}</label>
                                <input type="file" class="form-control" name="attachments[]"
                                    id="teacher_attachments" multiple>
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
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/buffer.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/filetype.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/piexif.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/plugins/sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/fileinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/themes/fa5/theme.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.2/js/locales/ar.js"></script>
    <script src="{{ URL::asset('assets/admin/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

    <script>
        $(function() {

            /* ===============================
            FILE INPUT INITIALIZATION
            =============================== */

            function initFileInputs() {

                if (!$('#teacher_image').data('fileinput')) {

                    $('#teacher_image').fileinput({
                        theme: 'fa5',
                        language: '{{ app()->getLocale() }}',

                        uploadUrl: '#',
                        showUpload: false,
                        showCancel: false,
                        showRemove: true,
                        showClose: false,

                        browseOnZoneClick: true,

                        fileActionSettings: {
                            showUpload: false,
                            showRemove: true,
                            showZoom: true,
                            showDrag: true,
                            showRotate: true
                        },

                        layoutTemplates: {
                            actionUpload: ''
                        },

                        allowedFileExtensions: ['jpg', 'jpeg', 'png', 'svg'],
                        maxFileSize: 2048,
                        maxFileCount: 1,

                        overwriteInitial: false,
                        initialPreviewAsData: true
                    });

                }

                if (!$('#teacher_attachments').data('fileinput')) {

                    $('#teacher_attachments').fileinput({
                        theme: 'fa5',
                        language: '{{ app()->getLocale() }}',

                        uploadUrl: '#',
                        showUpload: false,
                        showCaption: true,
                        showCancel: false,
                        showClose: false,
                        browseOnZoneClick: true,
                        overwriteInitial: false,
                        initialPreviewAsData: true,

                        allowedFileExtensions: ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'svg', 'zip'],
                        maxFileSize: 5120,
                        maxFileCount: 5,

                        fileActionSettings: {
                            showUpload: false,
                            showRemove: true,
                            showRotate: true,
                            showZoom: true,
                            showDrag: false
                        }
                    });


                }
            }


            /* ===============================
            WHEN MODAL OPEN
            =============================== */

            $('#addModal').on('shown.bs.modal', function() {

                initFileInputs();

            });


            /* ===============================
            RESET MODAL WHEN CLOSE
            =============================== */

            $('#addModal').on('hidden.bs.modal', function() {

                let form = $(this).find('form');

                form.trigger('reset');

                $('.error-text').text('');

                clearFileInputs();

            });

            function clearFileInputs() {

                if ($('#teacher_image').data('fileinput')) {
                    $('#teacher_image').fileinput('clear');
                }

                if ($('#teacher_attachments').data('fileinput')) {
                    $('#teacher_attachments').fileinput('clear');
                }

            }

            /* Numeric Only */

            $(document).on('input', '.numeric-only', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            /* Datepicker */
            $('.fc-datepicker').datepicker({
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
            if ($("#phone").length) {
                var input = document.querySelector("#phone");
                window.intlTelInput(input, {
                    onlyCountries: ["ps", "sa", "eg", "jo", "qa", "us"],
                    initialCountry: "ps",
                    utilsScript: "{{ URL::asset('assets/admin/plugins/telephoneinput/utils.js') }}",
                });
            }

        });
    </script>
@endpush
