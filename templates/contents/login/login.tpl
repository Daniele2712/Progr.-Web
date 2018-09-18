{* Smarty *}
<div id="topleft">

<div id="loginAndRegister">
    <ul>
        <li id="registerbutton">REGISTER</li>
        <li id="loginbutton">LOGIN</li>
    </ul>
</div>
    <div id="loginbox">
        <form class="login"  action="/user/login" method="post">

            <div><label for="username">Username</label>
              <input type="text" name="username" id="loginUsername"></div>
            <div><label for="password">Password</label>
              <input type="password" name="password" id="loginPassword"></div>

            <div class="actions">
              <input type="submit" name="login" value="Login"> <a href="/forgot">I forgot my password</a>
            </div>
        </form>
    </div>
    <div id="registerbox">
    <form class="login"  action="" method="post">
        <div><label for="nome">Nome</label>
          <input type="text" name="nome" id="nome"></div>
          <div><label for="cognome">Cognome</label>
          <input type="text" name="cognome" id="cognome"></div>
          <div><label for="indirizzo">Indirizzo</label>
          <input type="text" name="indirizzo" id="indirizzo"></div>
          <div><label for="username">Username</label>
          <input type="text" name="username" id="registerUsername"></div>
          <div><label for="password">Password</label>
          <input type="password" name="password" id="registerPassword"></div>
          <div><label for="confermaPassword">Conferma Password</label>
          <input type="password" name="confermaPassword" id="confermaPassword"></div>

        <div class="actions">
          <input type="submit" name="login" value="Login">
        </div>
    </form>
    </div>
</div>
