(function( window, document, $, msInformUserConfig ){
    var msInformUser = msInformUser || {};

    msInformUser.selectors = function() {
        this.$doc = $(document);
        this.$body = $('body');
        this.actionName = 'iu_action';
        this.action = ':submit[name=' + this.actionName + ']';
        this.dataName = 'iu';
        this.res = 'input[name=id]';
        this.remove = 'iu/remove';
        this.resModal = 'input[name=iu_id]';
        this.actionUrl = msInformUserConfig.actionUrl;
        this.modalId = '#iu-modal';
        this.modalBackdrop = '.modal-backdrop';
        this.iuButton = '#iu-button-';
        this.modalFormId = '#iu-inform';
        this.invalidEmail = '#iu-invalid-email';
        this.consentCheck = '#iu-consent-check';
        this.consentButton = '#iu-consent-button';
        this.inputEmail = 'input[name=iu_email]';
    };

    msInformUser.initialize = function() {
        msInformUser.selectors();

        this.$doc.on('click', this.action, function(e) {
            e.preventDefault();
            $this = $(this);
            // msInformUser.row = $this;
            var v = $this.data(msInformUser.dataName);
            var id = $this.closest('form').find(msInformUser.res).val();
            var sendData = {
                action: v,
                data: {
                    id: id,
                    iu_count: 1
                }
            };

            $this.attr('disabled', true);

            if ($(msInformUser.modalFormId).length) {
                var form = $(msInformUser.modalFormId).serializeArray();
                $.each(form, function(i, val) {
                    sendData.data[val.name] = val.value;
                });
            }
            msInformUser.send(sendData);
        });

        // disabled/enabled button modal
        this.$doc.on('change', this.consentCheck, function() {
            $(msInformUser.consentButton).prop('disabled', function(i, val) {
                return !val;
            })
        });

        // validate email
        this.$doc.on('keyup', this.inputEmail, function() {
            var email = $(this).val();
            if (!msInformUser.validateEmail(email)) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

    };

    msInformUser.validateEmail = function(email) {
        var ereg = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
        return ereg.test(email);
    };

    msInformUser.send = function(sendData, row) {
        $.ajax({
            method: 'POST',
            url: this.actionUrl,
            data: sendData,
            cache: false,
            success: function(res) {
                var status = $.parseJSON(res);
                var mode = status.data.mode;

                if (status.success) {
                    $(msInformUser.modalId).modal('dispose');
                    $(msInformUser.modalBackdrop).remove();

                    switch (mode) {
                        case 'requestCount':
                        case 'addedArrival':
                            msInformUser.setModal(status.data.tplModal);
                            break;

                        case 'removeArrival':
                            msInformUser.setModal(status.data.tplModal);
                            break;
                    }
                    if (status.data.id && status.data.button) {
                        $(msInformUser.iuButton + status.data.id).replaceWith(status.data.button);
                    }
                } else {
                    switch (mode) {
                        case 'invalidEmail':
                            $(msInformUser.invalidEmail).text(status.message).css('display', 'block');
                            break;
                    }
                }
            }
        });
    };

    msInformUser.setModal = function(tplModal) {
        if (!$(msInformUser.modalId).length) {
            this.$body.append(tplModal);
        } else {
            $(msInformUser.modalId).replaceWith(tplModal);
        }
    };

    $(document).ready(function ($) {
        msInformUser.initialize();
    });

    window.msInformUser = msInformUser;
})( window, document, jQuery, msInformUserConfig );