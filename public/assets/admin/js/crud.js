$(document).ready(function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $(document).on('submit', '.ajax-form', function(e) {
        e.preventDefault();
        var form = $(this);
        var modalId = form.data('modal-id');

        // Parsley Validation
        if(form.parsley && !form.parsley().isValid()) return;

        var formData = new FormData(this);
        var btn = form.find('button[type="submit"]');
        var spinner = btn.find('.spinner-border');
        var originalText = btn.text();

        // Loading State
        btn.attr('disabled', true);
        if(spinner.length) spinner.removeClass('d-none');

        $('.error-text').text('');
        $('input, select, textarea').removeClass('is-invalid');

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                btn.attr('disabled', false);
                if(spinner.length) spinner.addClass('d-none');

                if(response.status === 'success') {
                    if(modalId) $(modalId).modal('hide');

                    swal({
                        title: "Success",
                        text: response.message,
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    setTimeout(function(){
                        location.reload();
                    }, 2000);
                }
            },
            error: function(xhr) {
                btn.attr('disabled', false);
                if(spinner.length) spinner.addClass('d-none');

                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, val) {
                        var input = form.find('[name="'+key+'"]');
                        if(input.length === 0) input = form.find('[name="'+key+'[]"]');

                        if(input.length === 0) {
                            var spatieName = key.replace('.', '[').replace(/(\.[^.]+)$/, ']') + ']';
                            var parts = key.split('.');
                            if(parts.length > 1) {
                                spatieName = parts[0] + '[' + parts[1] + ']';
                                input = form.find('[name="'+spatieName+'"]');
                            }
                        }

                        input.addClass('is-invalid');

                        var errorClass = key.replace(/\./g, '_') + '_error';
                        form.find('.' + errorClass).text(val[0]);
                    });

                    var firstInvalid = form.find('.is-invalid').first();
                    if (firstInvalid.length > 0) {
                        var errorSection = firstInvalid.closest('section');
                        var wizardContainer = form.find('.wizard').parent();

                        if (errorSection.length > 0 && wizardContainer.length && $.fn.steps) {
                            var stepIndex = errorSection.index('section');
                            wizardContainer.steps("setStep", stepIndex);
                        }
                    }

                } else if(xhr.status === 413) {
                    swal("خطأ!", "The Size Of The Attachments Is Too Big.", "error");
                } else {
                    swal("Error!", "Server Error: " + xhr.status, "error");
                }
            }
        });
    });

    $(document).on('click', '.edit-btn', function() {
        var btn = $(this);
        var modalId = btn.data('target');
        var modal = $(modalId);
        var url = btn.data('url');

        modal.find('form').attr('action', url);

        $.each(btn.data(), function(key, value) {

            var input = modal.find('[name="'+key+'"], #'+key);

            if(input.length === 0 && (key.endsWith('_ar') || key.endsWith('_en'))) {
                var fieldName = key.slice(0, -3);
                var locale = key.slice(-2);
                input = modal.find('[name="' + fieldName + '[' + locale + ']"]');
            }

            if(input.length) {
                if(input.is('select')) {
                    input.val(value).trigger('change');
                } else if(input.attr('type') !== 'file') {
                    input.val(value);
                }
            }
        });

        $('.error-text').text('');
        $('input, select, textarea').removeClass('is-invalid');
    });
});
