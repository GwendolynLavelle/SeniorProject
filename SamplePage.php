<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Sample page</h1>


    <?php



    error_reporting(-1);
    ini_set('display_errors', 'On');


    $servername = "mydbinstance.cocii9c2v4il.us-west-2.rds.amazonaws.com";
    $username = "GwenLavelle";
    $password = "GwenLavelle";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=GwenLavelle", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }


    $test = $conn->query("SELECT * FROM Customer")->fetchAll(PDO::FETCH_ASSOC);


$test = $pdo->query("SELECT * FROM Customer");
$stmt->execute();
$test = $stmt->fetchAll(PDO::FETCH_ASSOC);



var_dump($test);






return;







//$test_query = "SHOW TABLES FROM $GwenLavelle";
//$result = mysqli_query($link, $test_query);


    ?>



<!-- Clean up. -->
<?php

  mysqli_free_result($result);
  mysqli_close($connection);

?>

</body>
</html>                    
