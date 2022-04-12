import {selector} from './selector';
import * as events from "./events";

const PageInvoiceCreate = (function ($) {

    function initEvents() {
        $(document).on('change', selector.inputQuantity, events.recalculateTotal);
        $(document).on('change', selector.inputAmount, events.recalculateTotal);
    }

    function initialize() {
        initEvents();
    }

    return {
        init: initialize
    }
})(jQuery);

export {PageInvoiceCreate};
