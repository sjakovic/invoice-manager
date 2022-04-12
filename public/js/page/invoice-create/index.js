import {selector} from './selector';
import * as events from "./events";

const PageInvoiceCreate = (function ($) {

    function initEvents() {
        $(document).on('click', selector.inputQuantity, events.recalculateTotal);
    }

    function initialize() {
        initEvents();
    }

    return {
        init: initialize
    }
})(jQuery);

export {PageInvoiceCreate};
