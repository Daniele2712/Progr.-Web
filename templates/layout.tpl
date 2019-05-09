{* Smarty *}
<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="/templates/css/layout.css"/>
        <link rel="stylesheet" type="text/css" href="/templates/css/footer.css"/>
        <link rel="stylesheet" type="text/css" href="/libs/jquery-ui/jquery-ui.min.css"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <script type="text/javascript" src="/templates/js/libs/jquery.js"></script>
        <script type="text/javascript" src="/libs/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="/libs/jquery-cookie/src/jquery_cookie.js" ></script>
        <script type="text/javascript" src="/templates/js/layout.js"></script>
        {$templateHeadIncludes}
        <script type="text/javascript"> var logged={if $logged}"{$logged}"{else}{"false"}{/if}</script>
        <title>{$siteTitle}</title>
        <link rel="shortcut icon" href="/download/favicon"/>
    </head>
    <body>
        <div id="header">
            <div class="centralbox">
                <div id="logobox">
                    <a href="{$homeLink}">
                        <img id ="logoimg" src="/templates/img/logo.png" />
                    </a>
                </div><div id="titlebox">
                    <img id ="logowriting" src="/templates/img/OnlineShopping.png" />
                </div><div id="profilebox">
                        {include file="contents/$templateLoginOrProfileIncludes"}
                </div>
            </div>
        </div>
        <div id="content">
            <div class="centralbox">
                {include file="contents/$templateContentIncludes"}
            </div>
        </div>
        <div id="footer">
            <div class="centralbox">
                {include file='footer.tpl'}
            </div>
        </div>
    </body>
</html>
