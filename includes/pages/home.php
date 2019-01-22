Home
<form id="login">
    <input name="password">
    <input type="submit">
    <? $core->csrf("/api/endpoint") ?>
</form>
