{* Smarty *}
<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="/templates/css/layout.css"/>
        <link rel="stylesheet" type="text/css" href="/templates/css/footer.css"/>
        <link rel="stylesheet" type="text/css" href="/libs/jquery-ui/jquery-ui.min.css"></script>
        <link rel="stylesheet" type="text/css" href="/libs/fontawesome/css/all.css">
        <script type="text/javascript" src="/templates/js/libs/jquery.js"></script>
        <script type="text/javascript" src="/libs/jquery-ui/jquery-ui.min.js"></script>
        <!--<script type="text/javascript" src="/libs/jquery-cookie/src/jquery_cookie.js" ></script>-->
        <script type="text/javascript" src="/templates/js/layout.js"></script>
        {$templateHeadIncludes}
        <script type="text/javascript"> var logged={if $logged}"{$logged}"{else}{"false"}{/if}</script>
        <title>{$siteTitle}</title>
        <link rel="shortcut icon" href="/download/favicon"/>
    </head>
    <body>
        <div id="header">
            <div class="wrapper">
                <div id="logobox">
                    <a href="{$homeLink}">
                        <img id ="logoimg" src="/templates/img/logo.png" />
                    </a>
                </div><div id="titlebox">
                  <a href="{$homeLink}">
                      <img id ="logowriting" src="/templates/img/OnlineShopping.png" />
                  </a>
                </div><div id="profilebox">
                        {include file="contents/$templateLoginOrProfileIncludes"}
                </div>
            </div>
        </div>
        <div id="banner">
            <div class="wrapper">
                <noscript>Devi attivare javascript per utilizzare il sito</noscript>
            </div>
        </div>
        <div id="content">
            <div class="wrapper">
                {include file="contents/$templateContentIncludes"}
            </div>
        </div>
        <div id="footer">
            <div class="wrapper">
                {include file='footer.tpl'}
            </div>
        </div>
    </body>
</html>
