{include file='header.tpl'}

<h2>Panel użytkownika</h2>

<p><strong>Imię:</strong> {$user.username}</p>
<p><strong>Email:</strong> {$user.email}</p>
<p><strong>Rodzina ID:</strong> {$user.family_id|default:'Brak przypisanej rodziny'}</p>
<p><strong>Rola:</strong> {$user.role}</p>
<p><strong>Rodzaj konta:</strong> {$user.account_type}</p>



{include file='footer.tpl'}
