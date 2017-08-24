<html>
    <head>
        <title>Upvote News</title>
    </head>
    <style>
        body {
            font-family: Verdana;
            font-size: 10pt;
        }
        
        #container {
            clear: both;
            margin: 0 auto;
            width: 960px;
        }  
              
        #main {
            background-color: #F6F6EF;
            width: 960px;
        }
        
        #header {
            background-color: #FF6600;
            padding: 5px;
        }
        
        a {
            text-decoration: none;
            color: #000000;
        }
        
        span {
            display: block;
        }
        
        span, span a {
            color: #828282;
            font-size: 8pt;
            
        }
        
        /* #8287B0 */
    </style>
    <body>
        <div id="container">
            <div id="main">
                <div id="header"><a href="/"><strong>Upvote News</strong>
                <?php
                
                if(\Masterclass\Template\Tools\AuthChecker::checkAuth()) {
                    print '<a href="/story/create">new</a> | <a href="/user/account">account</a> | <a href="/user/logout">logout</a>';
                } else {
                    print '<a href="/user/login">login</a> | ';
                    print '<a href="/user/create">create account</a>';
                }
                ?>    
                    
                </div>
                <div id="content">
                    <?php echo $this->getContent(); ?>
                </div>
            </div>
        </div>
    </body>
</html>