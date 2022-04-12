import {selector} from "./selector";

const recalculateTotal = function (e) {
    e.preventDefault();
    let sums = $(selector.inputQuantity).map(function () {
        let quantity = parseFloat($(this).val());
        let amount = parseFloat($(this).closest('tr').find(selector.inputAmount).val());
        return quantity * amount;
    }).get();

    let total = sums.reduce((sum, a) => sum + a, 0);

    $(selector.total).html(total);
}


export {recalculateTotal};
