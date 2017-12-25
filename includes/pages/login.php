<div id="login-bg-container"></div>
<div id="login-container">
    <div class="login-wrapper sht-depth-3">
        <div id="default">
            <h5 id="step">Login</h5>
            <h6 id="description">Insert your credentials below.</h6>

            <h6 class="cms">SHT CMS v<?=$sht->getVersion()?></h6>
        </div>
        <div id="containers">
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


                    <button class="btn blue right" type="submit">Submit</button>
                </form>

            </div>

            <div class="fingerprint-content">
                <form id="fingerprint_form" action="/backend/2fa-login.php" method="post">

                    <input id="token" name="token" type="text" required>
                    <i id="fingerprint-ico" class="material-icons animated-fingerprint">fingerprint</i>
                    <h6>Awaiting fingerprint</h6>
                    <button id="fingerprint_auth_btn" class="btn blue right" type="submit">Submit</button>

                </form>

            </div>

        </div>
    </div>
</div>
