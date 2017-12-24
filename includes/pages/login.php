<div id="login-bg-container"></div>
<div id="login-container">
    <div class="login-wrapper sht-depth-3">
        <h5>Login</h5>
        <form id="login_form" action="/backend/login.php" method="post">

                <div class="input-field col s12">
                    <input id="username" name="username" type="text" required autofocus>
                    <label for="username">Username</label>
                </div>

                <div class="input-field col s12">
                    <input id="password" name="password" type="password" required>
                    <label for="password">Password</label>
                </div>

            <a class="anchor black" href="/">Go Back</a>
            <button class="btn blue right" type="submit">Login</button>
        </form>
        <h6 class="cms">SHT CMS v<?=$sht->getVersion()?></h6>
    </div>
</div>
