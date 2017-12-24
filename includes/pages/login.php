<div id="login-bg-container"></div>
<div id="login-container">
    <div class="login-wrapper sht-depth-3">
        <h5>Login</h5>
        <form id="login_form" action="/backend/login.php" method="post">
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password" required>
            <button class="btn blue" type="submit">Login</button>
        </form>
        <h6 class="cms">SHT CMS v<?=$sht->getVersion()?></h6>
    </div>
</div>
