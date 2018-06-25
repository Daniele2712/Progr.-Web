<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/templates/css/layout.css"/>
        <script type="text/javascript" src="/templates/js/libs/jquery.js"></script>
        <title>{$title}</title>
    <body>
        <div id="header">
            <div class="content">
                <p style="margin:0;">header</p>
            </div>
        </div>
        <div id="nav">
            <div class="content">
                <div id="logo_container" class="button">
                    <a id="logo_link" href="/{$default.controller}/{$default.action}">
                        <img id="logo" src="{$logo_path}" alt="Logo"/>
                    </a>
                </div>
                <div id="menu_container" class="button">
                </div>
                <div id="cart_container" class="button">
                </div>
                <div id="user_container" class="button">
                </div>
            </div>
        </div>
        <div id="container">
            <div class="content">
                {* body of template goes here, the $content variable is replaced with a value eg 'list.tpl' *}
                {include file="contents/$content"}
            </div>
        </div>
        <div id="footer">
            <div class="content">
                <p style="margin:0;">footer</p>
            </div>
        </div>
    </body>
</html>
