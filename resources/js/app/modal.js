/**
 * app/modal.js
 */
const el = {
    formModal: '#form_modal',
    formModalLarge: '#form_modal_large',
    notifyModal: '#notify_modal',
    notifyModalLarge: '#notify_modal_large',
    deleteModal: '#delete_modal',
};

function showModal(large = false) {
    let selector = large ? el.formModalLarge : el.formModal
    $(selector).modal();
}

function showNotifyModal(message, large = false) {
    let selector = large ? el.notifyModalLarge : el.notifyModal;
    $(selector).modal().find('.modal-body').html(message);
}

function showDeleteModal(content) {
    $(el.deleteModal).modal().find('.modal-body').html(content);
}

export { el, showNotifyModal, showModal, showDeleteModal };