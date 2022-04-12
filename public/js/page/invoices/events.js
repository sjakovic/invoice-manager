import {selector} from "./selector";
import {gSelector} from "../../../../../app/selector";
import {translate} from "../../../../../app/localisation";
import {crud} from "../../../../../app/crud";

const invoicePreviewModal = function (e) {
    e.preventDefault();

    const bill = $(e.target).closest('tr').data('entity');
    const currency = $(e.target).data('currency');
    const $modal = $(selector.invoiceModal).modal();

    API.service.bill.getInvoiceData(bill.id, currency).done(function (response) {
        $modal.find('.modal-body').html(response);
    });
}

const invoiceEmailModal = function (e) {
    e.preventDefault();

    const bill = $(e.target).closest('tr').data('entity');
    const $modal = $(selector.invoiceEmailModal).modal();

    API.service.bill.getInvoiceEmailHtml(bill.id).done(function (response) {
        $modal.find('.modal-body').html(response);
        $modal.find(selector.btnInvoiceEmailSend).off('click').on('click', {bill}, _sendInvoiceEmail);
    });
}

const invoicePaymentModal = function (e) {
    e.preventDefault();

    const bill = $(e.target).closest('tr').data('entity');
    const $modal = $(selector.invoicePaymentModal).modal();

    API.service.bill.getInvoiceAddPaymentHtml(bill.id).done(function (response) {
        $modal.find('.modal-body').html(response);
        $modal.find(selector.btnPaymentSave).off('click').on('click', {
            bill: bill,
            form: $modal.find('form'),
            modal: $modal,
        }, _savePayment);

        $modal.find(selector.btnRemovePayment).off('click').on('click', {modal: $modal}, _removePayment);
    });
}

const invoicePaymentKarticarModal = function (e) {
    e.preventDefault();

    const bill = $(e.target).closest('tr').data('entity');
    const $modal = $(selector.invoicePaymentKarticarModal).modal();

    API.service.bill.getInvoiceAddPaymentKarticarHtml(bill.id).done(function (response) {
        $modal.find('.modal-body').html(response);
        $modal.find(selector.btnMakePayment).off('click').on('click', {
            bill: bill,
            modal: $modal,
        }, _makePayment);
    });
}

const _sendInvoiceEmail = function (e) {
    let bill = e.data.bill;
    let $alert = $(selector.emailSentAlert);

    $alert.attr('class', 'alert alert-warning').html('Mail je u procesu slanja...').show();

    API.service.bill.sendInvoiceEmail(bill.id).done(function (response) {
        $alert.attr('class', 'alert alert-success').html(response.message);
    }).fail(function () {
        $alert.attr('class', 'alert alert-danger').html('Serverska greska. Pokusajte ponovo.');
    });

}

const _savePayment = function (e) {
    e.preventDefault();

    let bill = e.data.bill;
    let $modal = e.data.modal;
    let formData = e.data.form.serialize();
    let $alert = $(selector.paymentAddAlert);

    $alert.attr('class', 'alert alert-warning').html('Uplata se dodaje...').show();

    API.service.bill.invoiceAddPayment(bill.id, formData).done(function (response) {
        $alert.attr('class', 'alert alert-success').html(response.message);
        API.service.bill.getInvoicePaymentItemsHtml(bill.id).done(function (res) {
            $(selector.previousPaymentsContainer).html(res);
            $modal.find(selector.btnRemovePayment).off('click').on('click', {modal: $modal}, _removePayment);
        }).fail(function (res) {
            console.log(res);
        });
    }).fail(function (response) {
        let errorsHtml = '';
        if (response.hasOwnProperty('responseJSON')) {
            if (response.responseJSON.hasOwnProperty('errors')) {
                let errors = response.responseJSON.errors;
                for (let prop in errors) {
                    if (errors.hasOwnProperty(prop)) {
                        errorsHtml += '<div>' + errors[prop] + '</div>';
                    }
                }
            } else {
                errorsHtml = translate('error_general');
            }
        } else {
            errorsHtml = translate('error_general');
        }
        $alert.attr('class', 'alert alert-danger').html(errorsHtml);
    });
}

const _makePayment = function (e) {
    e.preventDefault();

    let bill = e.data.bill;
    let $modal = e.data.modal;
    let $alert = $(selector.paymentAddAlert);

    $alert.attr('class', 'alert alert-warning').html('Naplata je u toku...').show();

    API.service.bill.invoiceAddPaymentKarticar(bill.id).done(function (response) {
        $alert.attr('class', 'alert alert-success').html(response.message);
        API.service.bill.getInvoicePaymentItemsHtml(bill.id).done(function (res) {
            $(selector.previousPaymentsContainer).html(res);
            $modal.find(selector.btnMakePayment).remove();
        }).fail(function (res) {
            console.log(res);
        });
    }).fail(function (response) {
        let errorsHtml = '';
        if (response.hasOwnProperty('responseJSON')) {
            if (response.responseJSON.hasOwnProperty('errors')) {
                let errors = response.responseJSON.errors;
                for (let prop in errors) {
                    if (errors.hasOwnProperty(prop)) {
                        errorsHtml += '<div>' + errors[prop] + '</div>';
                    }
                }
            } else {
                errorsHtml = translate('error_general');
            }
        } else {
            errorsHtml = translate('error_general');
        }
        $alert.attr('class', 'alert alert-danger').html(errorsHtml);
    });
}

const _removePayment = function (e) {
    const $modal = $(gSelector.modal.delete).modal();
    const url = $(e.target).data('href');
    const $parentModal = e.data.modal;

    $modal.find(gSelector.modal.success.general).html("").hide();
    $modal.find(gSelector.modal.errors.general).html("").hide();

    $modal.find('.js_btn_modal_confirm').off('click').on('click', function (ev) {
        crud.delete(url)
            .done(function (response) {
                $modal.find(gSelector.modal.success.general).html(response.message).show();
                $parentModal.find(selector.btnRemovePayment).each(function () {
                    if ($(this).data('href') === url) $(this).parent('div').remove();
                });
                $modal.modal('hide');
            })
            .fail((jqXHR) => $modal.find(gSelector.modal.errors.general).html(translate('error_general')).show());
    });
}

const removeBill = function (e) {
    e.preventDefault();

    const $modal = $(gSelector.modal.delete).modal();
    const url = $(e.target).attr('href');

    $modal.find(gSelector.modal.success.general).html("").hide();
    $modal.find(gSelector.modal.errors.general).html("").hide();

    $modal.find('.js_btn_modal_confirm').off('click').on('click', function (ev) {
        crud.delete(url)
            .done(function (response) {
                $modal.find(gSelector.modal.success.general).html(response.message).show();
                $modal.modal('hide');
                window.location.reload();
            })
            .fail((jqXHR) => $modal.find(gSelector.modal.errors.general).html(translate('error_general')).show());
    });
}

const exportBillsCSV = function (e) {
    e.preventDefault();

    let filterDateFrom = $(selector.filterDateFrom).val();
    let filterDateTo = $(selector.filterDateTo).val();
    let filterPaymentChannel = $(selector.filterPaymentChannel).val();
    let filterPaid = $(selector.filterPaid).val();
    let filterImportKey = $(selector.filterImportKey).val();
    let filterCustomerName = $(selector.filterCustomerName).val();
    let filterBillNumber = $(selector.filterBillNumber).val();
    let filterEmail = $(selector.filterEmail).val();
    let filterForeign = $(selector.filterForeign).val();

    let params = '?';
    if(filterDateFrom !== '') params = params + 'filter_date_from=' + encodeURIComponent(filterDateFrom) + '&';
    if(filterDateTo !== '') params = params + 'filter_date_to=' + encodeURIComponent(filterDateTo) + '&';
    if(filterPaymentChannel !== '') params = params + 'filter_payment_channel=' + encodeURIComponent(filterPaymentChannel) + '&';
    if(filterPaid !== '') params = params + 'filter_paid=' + encodeURIComponent(filterPaid) + '&';
    if(filterImportKey !== '') params = params + 'filter_import_key=' + encodeURIComponent(filterImportKey) + '&';
    if(filterCustomerName !== '') params = params + 'filter_customer_name=' + encodeURIComponent(filterCustomerName) + '&';
    if(filterBillNumber !== '') params = params + 'filter_bill_number=' + encodeURIComponent(filterBillNumber) + '&';
    if(filterEmail !== '') params = params + 'filter_email=' + encodeURIComponent(filterEmail) + '&';
    if(filterForeign !== '') params = params + 'filter_foreign=' + encodeURIComponent(filterForeign) + '&';

    window.location.href = '/admin/bills/export/csv' + params;
}


export {
    invoicePreviewModal,
    invoiceEmailModal,
    invoicePaymentModal,
    invoicePaymentKarticarModal,
    removeBill,
    exportBillsCSV,
};