import {gSelector} from "./selector";
import {translate} from "./localisation";

function setFormData($modal, elements, data) {
    let elementsLength = elements.length;
    for (let i = 0; i < elementsLength; i++) {
        let item = elements[i];
        let value = data[item.field];

        if (item.hasOwnProperty('set')) {
            item.set($modal, item.selector, value);
        } else {
            $modal.find(item.selector).val(value);
        }
    }
}

function handleSuccessResponse($form, reload, response) {
    if (reload === true) window.location.reload();
    else {
        $form.find(gSelector.modal.success.general).html(response.message).show();
    }
}


function handleFailResponse($form, formFields, response) {
    if (response.generalError) {
        $form.find(gSelector.modal.errors.general).html(response.generalError).show();
    } else if (response.errors) {
        let errors = response.errors;
        for (let prop in errors) {
            if (errors.hasOwnProperty(prop)) {
                let fieldSelector = getFieldSelector(prop, formFields);
                if (typeof fieldSelector === 'undefined')
                    console.error('Field selector cann\'t find field in form fields');
                let htmlAfter = '<div class="text-danger">' + errors[prop] + '</div>';
                $form.find(fieldSelector).addClass('is-invalid').after(htmlAfter);
            }
        }
    } else {
        $(gSelector.modal.errors.general).html(translate('error_general')).show();
    }
}

function getFieldSelector(field, formFields) {
    let i = 0, len = formFields.length;
    while (i < len) {
        if (formFields[i].field === field) return formFields[i].selector;
        i++
    }
}

function removeErrorMessages($form, formFields) {
    let i = 0, len = formFields.length;
    while (i < len) {
        let $field = $form.find(formFields[i].selector);
        $field.removeClass('is-invalid');
        if ($field.next().hasClass('text-danger')) $field.next().remove();
        i++
    }
    $form.find(gSelector.modal.errors.general).html('').hide();
    $form.find(gSelector.modal.success.general).html('').hide();
}

function resetFormData($form, formFields) {
    let i = 0, len = formFields.length;
    while (i < len) {
        let $field = $form.find(formFields[i].selector);
        $field.val('');
        i++
    }
}

function getFormData($form, formFields) {
    let formData = new FormData();
    let i = 0, len = formFields.length;
    while (i < len) {
        if (formFields[i].type === 'radio' || formFields[i].type === 'checkbox') {
            let value = $form.find(formFields[i].selector + ':checked').val();
            if (typeof value !== 'undefined' && value !== '' && value !== null) {
                formData.append(formFields[i].field, $form.find(formFields[i].selector + ':checked').val());
            }
        } else {
            formData.append(formFields[i].field, $form.find(formFields[i].selector).val());
        }
        i++;
    }
    $form.find(gSelector.modal.errors.general).html('').hide();
    return formData;
}

export {setFormData, getFormData, handleFailResponse, handleSuccessResponse, removeErrorMessages, resetFormData};