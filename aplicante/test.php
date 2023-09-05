<!DOCTYPE html>
<html>
    <head>
        <!--SER-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-sacle=1.0">
        <title>Registro - Ser en Acción</title>
        <!--mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <!-- bootstrap css -->
        <link rel="stylesheet" href="css/bootstrap.min.css"> <!--PENDIENTE-->
        <!--style css-->
        <link rel="stylesheet" href="css/formularios.css">
        <!-- Responsive-->
        <link rel="stylesheet" href="css/responsive.css"> <!--PENDIENTE-->
        <!-- fevicon -->
        <link rel="icon" href="images/fevicon.png" type="image/gif" /> <!--PENDIENTE-->
        <!--fonts-->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    </head>
    <body>
        <header>
            Header
        </header>
        <article>
            <h1> Texto H1</h1>
            <h2> Texto H2</h2>
            <h3> Texto H3</h3>
            <h4> Texto H4</h4>
            <h5> Texto H5</h5>
            <h6> Texto H6</h6>
            <?php
                include_once('../models/forms/form_elements/elementor.php');
                $constructor = new Elementor();
                $constructor -> inputElement(
                    'test_input',
                    'test_input',
                    'test input',
                    '',
                    '',
                    'PlaceHolder',
                    '',
                    '',
                    '',
                    'required',
                    ''
                );
                $constructor -> inputElement(
                    'test_input',
                    'test_input',
                    'test input',
                    '',
                    '',
                    'PlaceHolder',
                    'caja',
                    '',
                    '',
                    'required',
                    ''
                );
            ?>
        </article>
    </body>
</html>