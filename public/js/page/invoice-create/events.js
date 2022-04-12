import {selector} from "./selector";

const recalculateTotal = function (e) {
    e.preventDefault();

    API.service.bill.getInvoiceData(bill.id, currency).done(function (response) {
        $modal.find('.modal-body').html(response);
    });
}


export {recalculateTotal};
