<html>

<head>
    <style>
        body {
            background-color: #333333;
            color: lightgray;
            margin: 20px;
        }
    </style>

</head>

<body>
    <?php
    require "../src/ABF.php";
    $abf = new ABF("demo.abf");
    $abf->ShowInfo();
    ?>
</body>

</html>