{* Smarty *}
<div id="login">
    <div id="loginAndRegister">
        <div id="registerbutton">REGISTRATI</div><div id="loginbutton">ACCEDI</div>
    </div>
    <div id="dialog_container">
        <div id="loginbox">
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="loginUsername">
            </div><div>
                <label for="password">Password</label>
                <input type="password" name="password" id="loginPassword">
            </div>
            <div id="message"></div>
            <div class="actions">
                <button id="login_submit" class="button">Login</button>
                <a href="/forgot">Ho dimenticato la mia password</a>
            </div>
        </div>
        <div id="registerbox">
            <div>
                <label for="nome">Nome</label>
                <input type="text" name="nome" id="nome">
            </div>
            <div>
                <label for="cognome">Cognome</label>
                <input type="text" name="cognome" id="cognome">
            </div>
            <div>
                <label for="email">E-Mail</label>
                <input type="email" name="email" id="email">
            </div>
            <div>
                <label for="username">Username</label>
                <input type="text" name="username" id="registerUsername">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="registerPassword">
            </div>
            <div>
                <label for="confermaPassword">Conferma Password</label>
                <input type="password" name="confermaPassword" id="confermaPassword"><span id="samePass"></span>
            </div>
            <div>
                <label for="comune">Comune</label>
                <input type="text" name="comune" id="comune" class="autoload_comune"/>
                <input type="hidden" name="comuneId" class="autoload_comune_id"/>
            </div>
            <div>
                <label for="via">Via</label>
                <input type="text" name="via" id="via">
            </div>
            <div>
                <label for="civico">Civico</label>
                <input type="text" name="civico" id="civico">
            </div>
            <div>
                <label for="note">Note</label>
                <input type="text" name="note" id="note">
            </div>
            <div class="actions">
                <div id="register_button" class="button">Registrati</div>
            </div>
        </div>
    </div>
</div>
