<form id="login_form" action="/backend/login.php" method="post">

        <div class="input-field col s12">
            <input id="username" name="username" type="text" required autofocus>
            <label for="username">Username</label>
        </div>

        <div class="input-field col s12">
            <input id="password" name="password" type="password" required>
            <label for="password">Password</label>
        </div>



        <label id="rememberme_container">
            <input type="checkbox" class="filled-in" id="rememberme" name="rememberme" value="1"/>
            <span>Remember Me</span>
        </label>


    <button class="btn blue right" type="submit">Login</button>
</form>
