<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editGuardianModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editGuardianModalLabel">
                    <i class="fas fa-user-edit"></i> {{ trans('admin.guardians.edit') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" method="POST" class="ajax-form" id="editGuardianForm" data-modal-id="#editModal" enctype="multipart/form-data" data-parsley-validate>
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_id">

                    <div id="editGuardianWizard">

                        <h3><i class="fas fa-male"></i> {{ trans('admin.guardians.father_information') }}</h3>
                        <section>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.name_father_ar') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name_father[ar]" id="edit_name_father_ar" required minlength="3" maxlength="30" data-parsley-group="edit-step-1">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.name_father_en') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name_father[en]" id="edit_name_father_en" required minlength="3" maxlength="30" pattern="[a-zA-Z\s]+" data-parsley-group="edit-step-1">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.national_id_father') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control numeric-only" name="national_id_father" id="edit_national_id_father" maxlength="10" required data-parsley-length="[9, 10]" data-parsley-group="edit-step-1">
                                        <span class="text-danger error-text national_id_father_error"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.passport_id_father') }}</label>
                                        <input type="text" class="form-control numeric-only" name="passport_id_father" id="edit_passport_id_father" minlength="8" maxlength="10" data-parsley-group="edit-step-1">
                                        <span class="text-danger error-text passport_id_father_error"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.phone_father') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="edit_phone_father_input" required minlength="10" maxlength="20" data-parsley-group="edit-step-1">
                                        <input type="hidden" name="phone_father" id="edit_phone_father_hidden">
                                        <span class="text-danger error-text phone_father_error"></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.job_father_ar') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="job_father[ar]" id="edit_job_father_ar" required minlength="3" maxlength="30" data-parsley-group="edit-step-1">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.job_father_en') }} <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="job_father[en]" id="edit_job_father_en" required minlength="3" maxlength="30" pattern="[a-zA-Z\s]+" data-parsley-group="edit-step-1">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.nationality_father_id') }} <span class="text-danger">*</span></label>
                                        <select class="form-control" name="nationality_father_id" id="edit_nationality_father_id" required data-parsley-group="edit-step-1">
                                            <option value="">{{ trans('admin.global.select') }}</option>
                                            @foreach($nationalities as $nationality)
                                                <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.blood_type_father_id') }} <span class="text-danger">*</span></label>
                                        <select class="form-control" name="blood_type_father_id" id="edit_blood_type_father_id" required data-parsley-group="edit-step-1">
                                            <option value="">{{ trans('admin.global.select') }}</option>
                                            @foreach($blood_types as $blood_type)
                                                <option value="{{ $blood_type->id }}">{{ $blood_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.religion_father_id') }} <span class="text-danger">*</span></label>
                                        <select class="form-control" name="religion_father_id" id="edit_religion_father_id" required data-parsley-group="edit-step-1">
                                            <option value="">{{ trans('admin.global.select') }}</option>
                                            @foreach($religions as $religion)
                                                <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.address_father') }} <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="address_father" id="edit_address_father" rows="3" required maxlength="100" data-parsley-group="edit-step-1"></textarea>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3><i class="fas fa-female"></i> {{ trans('admin.guardians.mother_information') }}</h3>
                        <section>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.name_mother_ar') }}</label>
                                        <input type="text" class="form-control" name="name_mother[ar]" id="edit_name_mother_ar" required minlength="3" maxlength="30" data-parsley-group="edit-step-2">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.name_mother_en') }}</label>
                                        <input type="text" class="form-control" name="name_mother[en]" id="edit_name_mother_en" required minlength="3" maxlength="30" pattern="[a-zA-Z\s]+" data-parsley-group="edit-step-2">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.national_id_mother') }}</label>
                                        <input type="text" class="form-control numeric-only" name="national_id_mother" id="edit_national_id_mother" maxlength="10" data-parsley-group="edit-step-2">
                                        <span class="text-danger error-text national_id_mother_error"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.passport_id_mother') }}</label>
                                        <input type="text" class="form-control numeric-only" name="passport_id_mother" id="edit_passport_id_mother" minlength="8" maxlength="10" data-parsley-group="edit-step-2">
                                        <span class="text-danger error-text passport_id_mother_error"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.phone_mother') }}</label>
                                        <input type="text" class="form-control" id="edit_phone_mother_input" minlength="10" maxlength="20" data-parsley-group="edit-step-2">
                                        <input type="hidden" name="phone_mother" id="edit_phone_mother_hidden">
                                        <span class="text-danger error-text phone_mother_error"></span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.job_mother_ar') }}</label>
                                        <input type="text" class="form-control" name="job_mother[ar]" id="edit_job_mother_ar" minlength="3" maxlength="30" data-parsley-group="edit-step-2">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.job_mother_en') }}</label>
                                        <input type="text" class="form-control" name="job_mother[en]" id="edit_job_mother_en" minlength="3" maxlength="30" data-parsley-group="edit-step-2">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.nationality_mother_id') }}</label>
                                        <select class="form-control" name="nationality_mother_id" id="edit_nationality_mother_id" data-parsley-group="edit-step-2" required>
                                            <option value="">{{ trans('admin.global.select') }}</option>
                                            @foreach($nationalities as $nationality)
                                                <option value="{{ $nationality->id }}">{{ $nationality->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.blood_type_mother_id') }}</label>
                                        <select class="form-control" name="blood_type_mother_id" id="edit_blood_type_mother_id" data-parsley-group="edit-step-2" required>
                                            <option value="">{{ trans('admin.global.select') }}</option>
                                            @foreach($blood_types as $blood_type)
                                                <option value="{{ $blood_type->id }}">{{ $blood_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.religion_mother_id') }}</label>
                                        <select class="form-control" name="religion_mother_id" id="edit_religion_mother_id" data-parsley-group="edit-step-2" required>
                                            <option value="">{{ trans('admin.global.select') }}</option>
                                            @foreach($religions as $religion)
                                                <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.address_mother') }}</label>
                                        <textarea class="form-control" name="address_mother" id="edit_address_mother" rows="3" maxlength="100" data-parsley-group="edit-step-2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <h3><i class="fas fa-check-circle"></i> {{ trans('admin.guardians.auth_and_attachments') }}</h3>
                        <section>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.email') }} <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="edit_email" required maxlength="50" data-parsley-group="edit-step-3">
                                        <span class="text-danger error-text email_error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.password') }}</label>
                                        <input type="password" class="form-control" name="password" id="edit_password" minlength="8" maxlength="30" data-parsley-group="edit-step-3" placeholder="{{ __('admin.guardians.fields.password') }}">
                                        <span class="text-danger error-text password_error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.password_confirmation') }}</label>
                                        <input type="password" name="password_confirmation" id="edit_password_confirmation" class="form-control" data-parsley-equalto="#edit_password" data-parsley-group="edit-step-3" placeholder="{{ __('admin.guardians.fields.password_confirmation') }}">
                                        <span class="text-danger error-text password_confirmation_error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.image') }}</label>
                                        <input type="file" class="dropify edit_dropify" name="image" id="edit_image" accept="image/jpeg, image/png, image/jpg" data-height="150" data-parsley-group="edit-step-3"/>
                                        <span class="text-danger error-text image_error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('admin.guardians.fields.attachments') }}</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="attachments[]" id="edit_attachments" accept=".jpg, .png, .pdf" multiple data-parsley-group="edit-step-3">
                                            <label class="custom-file-label" for="edit_attachments">{{__('admin.global.dropify.drag_drop')}}</label>
                                        </div>
                                        <small class="text-muted mt-2 d-block">{{ trans('admin.guardians.attachments_help') }}</small>
                                        <span class="text-danger error-text attachments_error"></span>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {

            var itiFatherEdit, itiMotherEdit;
            var formEdit = $('#editGuardianForm');

            $("#editGuardianWizard").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                autoFocus: true,
                titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
                labels: {
                    finish: "{{ trans('admin.global.save') }}",
                    next: "{{ trans('admin.global.next') }}",
                    previous: "{{ trans('admin.global.previous') }}"
                },
                onStepChanging: function (event, currentIndex, newIndex) {
                    forceSyncPhonesEdit();
                    if (currentIndex > newIndex) { return true; }
                    var currentGroup = 'edit-step-' + (currentIndex + 1);
                    formEdit.parsley().validate({ group: currentGroup });
                    return formEdit.parsley().isValid({ group: currentGroup });
                },
                onFinishing: function (event, currentIndex) {
                    formEdit.parsley().validate({ group: 'edit-step-3' });
                    return formEdit.parsley().isValid({ group: 'edit-step-3' });
                },
                onFinished: function (event, currentIndex) {
                    forceSyncPhonesEdit();
                    formEdit.submit();
                }
            });

            var inputFatherEdit = document.querySelector("#edit_phone_father_input");
            itiFatherEdit = window.intlTelInput(inputFatherEdit, {
                onlyCountries: ["ps", "sa", "eg", "jo", "qa", "us"],
                initialCountry: "ps",
                utilsScript: "{{ URL::asset('assets/admin/plugins/telephoneinput/utils.js') }}",
            });

            var inputMotherEdit = document.querySelector("#edit_phone_mother_input");
            itiMotherEdit = window.intlTelInput(inputMotherEdit, {
                onlyCountries: ["ps", "sa", "eg", "jo", "qa", "us"],
                initialCountry: "ps",
                utilsScript: "{{ URL::asset('assets/admin/plugins/telephoneinput/utils.js') }}",
            });

            function forceSyncPhonesEdit() {
                var rawFather = $('#edit_phone_father_input').val().replace(/[^0-9\+]/g, '');
                var finalFatherVal = '';

                if (rawFather !== '') {
                    finalFatherVal = itiFatherEdit.getNumber();
                    if (!finalFatherVal) {
                        var countryData = itiFatherEdit.getSelectedCountryData();
                        var dialCode = countryData ? '+' + countryData.dialCode : '';
                        finalFatherVal = rawFather.startsWith('+') ? rawFather : dialCode + rawFather;
                    }
                }
                document.getElementById('edit_phone_father_hidden').value = finalFatherVal;

                var rawMother = $('#edit_phone_mother_input').val().replace(/[^0-9\+]/g, '');
                var finalMotherVal = '';

                if (rawMother !== '') {
                    finalMotherVal = itiMotherEdit.getNumber();
                    if (!finalMotherVal) {
                        var mCountryData = itiMotherEdit.getSelectedCountryData();
                        var mDialCode = mCountryData ? '+' + mCountryData.dialCode : '';
                        finalMotherVal = rawMother.startsWith('+') ? rawMother : mDialCode + rawMother;
                    }
                }
                document.getElementById('edit_phone_mother_hidden').value = finalMotherVal;
            }

            $('#edit_phone_father_input, #edit_phone_mother_input').on('input change blur keyup', forceSyncPhonesEdit);
            inputFatherEdit.addEventListener('countrychange', forceSyncPhonesEdit);
            inputMotherEdit.addEventListener('countrychange', forceSyncPhonesEdit);

            $('#editModal').on('shown.bs.modal', function () {
                var savedFatherPhone = $('#edit_phone_father_hidden').val();
                if(savedFatherPhone) {
                    itiFatherEdit.setNumber(savedFatherPhone);
                }

                var savedMotherPhone = $('#edit_phone_mother_hidden').val();
                if(savedMotherPhone) {
                    itiMotherEdit.setNumber(savedMotherPhone);
                }
            });

            var drEventEdit = null;

            setTimeout(function() {
                drEventEdit = $('.edit_dropify').dropify({
                    messages: {
                        'default': '{{__("admin.global.dropify.drag_drop")}}',
                        'replace': '{{__("admin.global.dropify.replace")}}',
                        'remove': '{{__("admin.global.delete")}}',
                        'error': '{{__("admin.global.dropify.error")}}'
                    }
                });
            }, 200);

            $('#editModal').on('hidden.bs.modal', function () {
                $("#editGuardianWizard").steps("reset");
                formEdit.parsley().reset();
                formEdit[0].reset();
                document.getElementById('edit_phone_father_hidden').value = '';
                document.getElementById('edit_phone_mother_hidden').value = '';

                if (drEventEdit) {
                    var dropifyApiEdit = drEventEdit.data('dropify');
                    if(dropifyApiEdit) {
                        dropifyApiEdit.resetPreview();
                        dropifyApiEdit.clearElement();
                    }
                }
            });

            $(document).ajaxComplete(function(event, xhr, settings) {
                if (xhr.status === 422 && settings.url.includes('guardians')) {
                    if ($('#editModal').is(':visible')) {
                        let firstErrorSection = $('#editGuardianWizard section').has('.is-invalid').first();
                        if (firstErrorSection.length) {
                            let stepIndex = $('#editGuardianWizard section').index(firstErrorSection);
                            $("#editGuardianWizard").steps("setStep", stepIndex);
                        }
                    }
                }
            });

        });
    </script>
@endpush
