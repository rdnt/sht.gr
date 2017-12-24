<div id="login-bg-container"></div>
<div id="login-container">
    <div class="login-wrapper sht-depth-3">
        <div class="default">
            <h5>Login</h5>
            <h6>Insert your credentials below</h6>

            <h6 class="cms">SHT CMS v<?=$sht->getVersion()?></h6>
        </div>
        <div class="containers">
            <div class="login-content">

                <form id="login_form" action="/backend/login.php" method="post">

                        <div class="input-field col s12">
                            <input id="username" name="username" type="text" required autofocus>
                            <label for="username">Username</label>
                        </div>

                        <div class="input-field col s12">
                            <input id="password" name="password" type="password" required>
                            <label for="password">Password</label>
                        </div>


                    <button class="btn blue right" type="submit">Login</button>
                </form>

            </div>
            <div class="code-content">
                <form id="code_form" action="/backend/2fa-login.php" method="post">



                        <div class="input-field col s12">
                            <input id="code" name="code" type="text" required>
                            <label for="code">Authentication Code</label>
                        </div>


                    <button class="btn blue right" type="submit">Verify</button>
                </form>

            </div>

            <div class="fingerprint-content">
                <form id="fingerprint_form" action="/backend/2fa-login.php" method="post">


                    <i class="material-icons">fingerprint</i>
                    <h6>Awaiting fingerprint</h6>



                </form>

            </div>

        </div>
    </div>
</div>
