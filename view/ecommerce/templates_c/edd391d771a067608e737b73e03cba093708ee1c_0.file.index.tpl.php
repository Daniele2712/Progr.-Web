<?php
/* Smarty version 3.1.32, created on 2018-06-23 20:16:02
  from '/var/www/html/Progr.-Web/view/ecommerce/templates/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.32',
  'unifunc' => 'content_5b2e8e6243f906_80699828',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'edd391d771a067608e737b73e03cba093708ee1c' => 
    array (
      0 => '/var/www/html/Progr.-Web/view/ecommerce/templates/index.tpl',
      1 => 1529777678,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b2e8e6243f906_80699828 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
    <html lang="en">
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/style_main_page.css">
        
        <?php echo '<script'; ?>
 src="js/jquery.js"><?php echo '</script'; ?>
>
        
    </head>
    
    <body>
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
                                            <form class="login"  action="<?php echo $_smarty_tpl->tpl_vars['SCRIPT_NAME']->value;?>
?action=spesaConLogin" method="post"> 

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
                                        <form class="login"  action="<?php echo $_smarty_tpl->tpl_vars['SCRIPT_NAME']->value;?>
?action=registrazione" method="post"> 
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
                        <form class="login"  action="<?php echo $_smarty_tpl->tpl_vars['SCRIPT_NAME']->value;?>
?action=spesaSenzaLogin" method="post"> 

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
               
               
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                            
                    
               
    
         


            <div class="footer">
            </div>
        </div>
        <?php echo '<script'; ?>
 src="js/myscripts.js"><?php echo '</script'; ?>
>
        </div>
    </body>
  
</html>


<?php }
}
