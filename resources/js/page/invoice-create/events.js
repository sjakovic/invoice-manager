import {selector} from "./selector";
import {uuid} from "../../app/helper";
import {translate} from "../../app/localisation";

const recalculateTotal = function (e) {
    e.preventDefault();
    _recalculateTotal();
}

const addInvoiceItemHtml = function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    $(selector.tableInvoiceItems + ' tr.js_invoice_item:last').after(_rowTmpl(uuid()));
}

const removeInvoiceItemHtml = function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    let countItems = $(selector.inputQuantity).length;

    if(countItems === 1) {
        return;
    }

    $(e.target).parents('tr').remove();
    _recalculateTotal();
}

const _recalculateTotal = function () {
    let sums = $(selector.inputQuantity).map(function () {
        let quantity = parseFloat($(this).val());
        let amount = parseFloat($(this).closest('tr').find(selector.inputAmount).val());
        if(isNaN(amount)) {
            amount = 0;
        }
        return quantity * amount;
    }).get();

    let total = sums.reduce((sum, a) => sum + a, 0);

    $(selector.total).html(total);
}

const _rowTmpl = function (uuid) {
    return `
        <tr class="js_invoice_item">
            <td>
                <input name="items[${uuid}][desc]"
                       type="text"
                       class="form-control form-control-sm"
                       value="">
            </td>
            <td>
                <input name="items[${uuid}][quantity]"
                       type="number"
                       minl="1"
                       class="form-control form-control-sm js_quantity"
                       value="1">
            </td>
            <td>
                <input name="items[${uuid}][amount]"
                       type="text"
                       class="form-control form-control-sm js_amount"
                       value="">
            </td>
            <td>
                <button class="btn btn-sm btn-outline-danger js_btn_item_remove">
                    ${translate('btn_remove')}
                </button>
            </td>
        </tr>
    `;
}


export {recalculateTotal, addInvoiceItemHtml, removeInvoiceItemHtml};
