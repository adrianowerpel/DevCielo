<?php

class template{

    function header(){
        echo '<!DOCTYPE html>
                <html lang="pt-BR">
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <title>Dev Cielo</title>
                
                    <!-- Bootstrap links CDN-->
                    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
                    <link rel="stylesheet" href="../assets/css/bootstrap-grid.min.css">
                    <link rel="stylesheet" href="../assets/css/bootstrap-reboot.min.css">
                </head>
                <body>';
    }

    function footer(){
        echo '                <script src="../assets/js/jquery-3.3.1.min.js"></script>
                <script src="../assets/js/bootstrap.min.js"></script>
                </body>
                </html>';
    }

}
