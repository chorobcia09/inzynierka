{include file='header.tpl'}

<h4>Paragon</h4>

{if isset($receiptBase64) && $receiptBase64}
    <img src="data:image/jpeg;base64,{$receiptBase64}" alt="Paragon" style="max-width:100%;">
{else}
    <p>Brak paragonu dla tej transakcji.</p>
{/if}

{include file='footer.tpl'}
