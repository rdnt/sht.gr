<div id="login-bg-container"></div>
<div id="login-container">
    <div class="login-wrapper sht-depth-3">
        <div id="default">
            <h5 id="step">Register</h5>
            <h6 id="description">Fill in your details below.</h6>

            <h6 class="cms">SHT CMS v<?=$sht->getVersion()?></h6>
        </div>
        <div id="containers">
            <div class="login-content">

                <form id="register_form" action="/backend/register.php" method="post">

                        <div id="username-container" class="input-field col s12">
                            <input id="username" name="username" type="text" autofocus>
                            <label for="username">Username</label>
                        </div>

                        <div id="email-container" class="input-field col s12">
                            <input id="email" name="email" type="text">
                            <label for="email">Email</label>
                        </div>

                        <div id="password-container" class="input-field col s12">
                            <input id="password" name="password" type="password">
                            <label for="password">Password</label>
                        </div>

                        <div id="repeat-password-container" class="input-field col s12">
                            <input id="repeat-password" name="repeat_password" type="password">
                            <label for="repeat-password">Password</label>
                        </div>


                    <button class="btn blue right" type="submit">Register</button>
                </form>

            </div>


        </div>
    </div>
</div>
