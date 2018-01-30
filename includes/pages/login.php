<div id="login-bg-container"></div>
<div id="login-container">
    <div class="login-wrapper">
        <div id="default">
            <h5 id="step">Login</h5>
            <h6 id="description">Insert your credentials below.</h6>
            <div id="cms-container">
                <h6 class="cms">SHT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CMS</h6>
                <img alt="" class="cms-img" src="/images/home/sht_cms.svg">
            </div>
        </div>
        <div id="containers">
            <div class="login-content">
                <form id="login_form" method="post">
                    <div id="username-container" class="input-field col s12">
                        <input id="username" name="username" type="text" autofocus>
                        <label for="username">Username</label>
                    </div>
                    <div id="password-container" class="input-field col s12">
                        <input id="password" name="password" type="password">
                        <label for="password">Password</label>
                    </div>
                    <label id="rememberme_container">
                    <input type="checkbox" class="filled-in" id="rememberme" name="rememberme" value="1"/>
                    <span>Remember Me</span>
                    </label>
                    <button id="submit-btn" class="btn blue right" type="submit">Login</button>
                </form>
            </div>
            <div class="code-content">
                <form id="code_form" method="post" autocomplete="off">
                    <div id="code-container" class="input-field col s12">
                        <input id="code" name="code" type="text" required>
                        <label for="code">Authentication Code</label>
                    </div>
                    <button id="code_auth_btn" class="btn blue right" type="submit">Submit</button>
                </form>
            </div>
            <div class="fingerprint-content">
                <form id="fingerprint_form" method="post">
                    <input id="token" name="token" type="text" required>
                    <i id="fingerprint-ico" class="material-icons animated-fingerprint">fingerprint</i>
                    <div class="binary-text-wrapper">
                        <span id="binary-text">011101110110100001100001011101000010000001111001011011110111010100100000011000010110110001110111011000010111100101110011001000000110100001100001011101100110010100100000011101110110100101110100011010000010000001111001011011110111010100100000011000100111010101110100001000000111100101101111011101010010000001100001011011000111011101100001011110010111001100100000011011000110010101100001011101100110010100100000011000100110010101101000011010010110111001100100</span>
                    </div>
                    <h6>Awaiting fingerprint</h6>
                    <button id="fingerprint_auth_btn" class="btn blue right" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
