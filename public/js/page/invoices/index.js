import {selector} from './selector';
import * as events from "./events";

const PageInvoices = (function ($) {

    function initEvents() {
        $(document).on('click', selector.invoicePreview, events.invoicePreviewModal);
        $(document).on('click', selector.invoiceEmail, events.invoiceEmailModal);
        $(document).on('click', selector.invoicePayment, events.invoicePaymentModal);
        $(document).on('click', selector.invoicePaymentKarticar, events.invoicePaymentKarticarModal);
        $(document).on('click', selector.btnDeleteBill, events.removeBill);
        $(document).on('click', selector.btnBillsExportCSV, events.exportBillsCSV);
    }

    function initialize() {
        initEvents();
    }

    return {
        init: initialize
    }
})(jQuery);

export {PageInvoices};
