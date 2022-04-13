import {PageInvoiceCreate} from "./page/invoice-create";

/*** General setup START ***/
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
window.API = {};

// Page manager for routes
API.pageManager = {};

// Events
$('#modal_delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
});

feather.replace({ 'aria-hidden': 'true' });
/*** General setup END ***/

/*** Init pages controllers ***/
//API.pageManager.dashboard = PageDashboard;
API.pageManager.invoiceCreate = PageInvoiceCreate;
