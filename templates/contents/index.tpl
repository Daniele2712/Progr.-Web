{* Smarty *}

        <div class="wrapper">

            <div class="header">
                <div id="imglogo">
                </div>
                <div id="namelogo">
                </div>
                <div id="buttonsdiv">
                    <ul id="buttons">
                        <li id="registerbutton">REGISTER </li>
                        <li id="loginbutton">LOGIN</li>
                    </ul>

                </div>
            </div>



                                        <div id="loginbox">
                                            <form class="login"  action="/shop/spesaConLogin" method="post">

                                                <div><label for="username">Username</label>
                                                  <input type="text" name="username" id="username"></div>
                                                <div><label for="password">Password</label>
                                                  <input type="password" name="password" id="password"></div>

                                                <div class="actions">
                                                  <input type="submit" name="login" value="Login"> <a href="/forgot">I forgot my password</a>
                                                </div>
                                            </form>
                                        </div>


                                        <div id="registerbox">
                                        <form class="login"  action="/user/register" method="post">
                                            <div><label for="nome">Nome</label>
                                              <input type="text" name="nome" id="nome"></div>
                                              <div><label for="cognome">Cognome</label>
                                              <input type="text" name="cognome" id="cognome"></div>
                                              <div><label for="indirizzo">Indirizzo</label>
                                              <input type="text" name="indirizzo" id="indirizzo"></div>
                                              <div><label for="username">Username</label>
                                              <input type="text" name="username" id="username"></div>
                                              <div><label for="password">Password</label>
                                              <input type="password" name="password" id="password"></div>
                                              <div><label for="confermaPassword">Conferma Password</label>
                                              <input type="password" name="confermaPassword" id="confermaPassword"></div>

                                            <div class="actions">
                                              <input type="submit" name="login" value="Login">
                                            </div>
                                        </form>
                                    </div>



            <div id="main">


                <div id="locator">
                    <p>Selezione il tuo inzirizzo di spedizione</p>
                    <div id="selectlocation">
                        <form class="login"  action="/shop/spesaSenzaLogin" method="post">

                            <div><label for="citta">Citta'</label>
                              <input type="text" name="citta" id="citta"></div>
                            <div><label>Via</label>
                              <input type="text" name="via" id="via"></div>
                            <div><label>Numero</label>
                              <input type="text" name="numero" id="numero"></div>
                            <div><label>Interno</label>
                              <input type="text" name="interno" id="interno"></div>
                            <div class="actions" id='inizialaspesa'>
                              <input type="submit" name="inizialaspesa" value="Inizia la spesa!">
                            </div>
                        </form>
                    </div>

               </div>
            </div>

        </div>
