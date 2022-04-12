import * as table from './table';
import {gSelector} from "./selector";
import {crud} from "./crud";

function deleteModalAction(e) {
    let $modal = e.data.modal;
    let url = e.data.url;

    $modal.find(gSelector.modal.errors.general).html('').hide();

    crud.delete(url)
        .done(() => window.location.reload())
        .fail((jqXHR) => $modal.find(gSelector.modal.errors.general).html(jqXHR.responseJSON.generalError).show());
}

function deleteModal(e) {
    let entity = table.getEntityFromRow(e);
    let $modal = $(gSelector.modal.delete);
    let url = e.data.url + '/' + entity.id;

    $modal.find(gSelector.modal.errors.general).html('').hide();

    $modal.find(gSelector.btn.modal.confirm)
        .off('click')
        .on('click', {modal: $modal, url}, deleteModalAction);

    $modal.modal();
};

export {deleteModal};