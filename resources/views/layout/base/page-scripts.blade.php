@if(in_array($varCurrentRoute, ['invoice-create', 'invoice-edit']))
    <script>API.pageManager.invoiceCreate.init()</script>
@endif
