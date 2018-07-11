{* Smarty *}
{* forse gli dovro passare un array di info cpsi lui sa che info deve displayare *}

<html>

    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="/templates/css/layout.css"/>
        <link rel="stylesheet" type="text/css" href="/templates/css/footer.css"/>
        <script type="text/javascript" src="/templates/js/libs/jquery.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        {$templateHeadIncludes}
        <title>Online Shopping</title>
    </head>

    <body>
        <div id="header">

                <img id ="logoimg" src="/templates/img/logo.png"/>
                <img id ="logowriting" src="/templates/img/OnlineShopping.png"/>
                {*include file="contents/$templateLoginOrUserIncludes"*}
        </div>


        <div class="content">
            {include file="contents/$templateContentIncludes"}
        </div>


        <div id="footer">
            {include file='footer.tpl'}
        </div>

    </body>
</html>
