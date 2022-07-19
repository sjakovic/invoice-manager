import {selector} from './selector';
import * as events from "./events";

const PageInvoiceCreate = (function ($) {

    function initEvents() {
        $(document).on('change', selector.inputQuantity, events.recalculateTotal);
        $(document).on('change', selector.inputAmount, events.recalculateTotal);
        $(document).on('click', selector.btnItemAdd, events.addInvoiceItemHtml);
        $(document).on('click', selector.btnItemRemove, events.removeInvoiceItemHtml);
    }

    function initialize() {
        initEvents();

        $(selector.inputQuantity).trigger('change');
    }

    return {
        init: initialize
    }
})(jQuery);

export {PageInvoiceCreate};
