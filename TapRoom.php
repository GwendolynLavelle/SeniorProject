<!-- Author: Gwendolyn Lavelle -->
<?php include "../inc/dbinfo.inc";

error_reporting(-1);
ini_set('display_errors', 'On');

?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- REQUIRED meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, intial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styletap.css">

</head>

<body data-spy="scroll" data-target="#navScrollspy">


    <nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-primary navColor">
        <a class="navbar-brand" href="index.html"><font color="white">Crush Brewing</font></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto" id="navScrollspy">
                <li class="nav-item active">
                    <a class="nav-link" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.html">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="TapRoom.php">TapRoom</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            </ul>
        </div>
        </li>
        <div>

    </nav>


<!-- Begin main content area -->
    <br />
    <br />
    <br />
    <br />

<!-- Select statement of all items in the product table, this is all the items being sold
       what is displayed is the item name and a description of the items -->
<!-- PDO statement is used to ensure database integrity -->

    <section id="beerlist1" style="background-color:white;">
        <h2 class="display-4 text-center">TAPROOM MENU</h2>
        <div id="container">
          <?php
        $beersList = $conn->query("SELECT * FROM GwenLavelle.Product")->fetchAll(PDO::FETCH_ASSOC);

        foreach($beersList as $key => $beer){
            echo "<div>#" . ++$key . " <b>$beer[BeerName] - $beer[Description]</b></div><br>";
    }


    ?>
<!-- Listing of beers and pictures of beers (no pictures yet so dummy pictures are used in place) -->
            <div class="row">

                <div class="col-12 col-md-4 d-flex flex-column align-items-center">

                    <h3 class="text-center">#1: Irish Oatmeal Stout</h3>
                    <img src="fakebeer.jpg" alt="Italian Trulli" height="65" width="60">
                </div>

                <div class="col-12 col-md-4 d-flex flex-column align-items-center">
                    <h3 class="text-center">#2: NEIPA</h3>
                    <img src="fakebeer.jpg" alt="Italian Trulli" height="65" width="60">
                </div>

                <div class="col-12 col-md-4  d-flex flex-column align-items-center">
                    <h3 class="text-center">#3: Crushed Peach Sour</h3>
                    <img src="fakebeer.jpg" alt="Italian Trulli" height="65" width="60">
            </div>
        </div>
    </section>


    <section id="beerlist2" style="background-color:white">
        <div id="container">
            <div class="row">

                <div class="col-12 col-md-4 d-flex flex-column align-items-center">

                    <h3 class="text-center">#4: Crushed Blueberry Sour</h3>
                    <img src="fakebeer.jpg" alt="Italian Trulli" height="65" width="60">

                </div>

                <div class="col-12 col-md-4 d-flex flex-column align-items-center">
                    <h3 class="text-center">#5: Pale Ale</h3>
                    <img src="fakebeer.jpg" alt="Italian Trulli" height="65" width="60">
                </div>

                <div class="col-12 col-md-4  d-flex flex-column align-items-center">
                    <h3 class="text-center">#6: Lager</h3>
                    <img src="fakebeer.jpg" alt="Italian Trulli" height="65" width="60">
                </div>
            </div>
        </div>
    </section>


    <section id="beeroptions" style="background-color:lightgray;">
        <h1 class="display-4 text-center" style="font-family:verdana;"><i>Which one of our beers are for you?</i></h1>

<!-- Form for beer selection decided by the hops attribute of the beer. 
A drop down box is provided to choice all hops options from the database followed by a submit button -->

            <form name="beerSelection" method="post" action="">  
        <center><b>HOPS</b></center>
        <center><select class="display text-center"name="hops">
            <option value="" disabled selected>Select your option</option>
<!-- Again - PDO statements are used for database integrity -->
            <?php
              $hops = $conn->query("SELECT DISTINCT Hops, ProductID FROM GwenLavelle.Product GROUP BY Hops ORDER BY Hops")->fetchAll(PDO::FETCH_ASSOC);
              foreach($hops as $key => $hop){
                  echo "<option value='$hop[ProductID]'>$hop[Hops]</option>";
               }

            ?>
        </select></center>
       <center> <input type="submit" name="submit" value="Submit" /></center>
        </form>
        <?php






        if (isset($_POST['submit'])) {
    #############################################################################################
    #                            FILTER FOR BEERS WITH USER SELECTION     (UPDATE)              #
    #############################################################################################
    $stmt = $conn->prepare("SELECT * FROM GwenLavelle.Product WHERE ProductID=:ProductID");
    $stmt->bindValue( "ProductID",             $_POST['hops'],                             PDO::PARAM_INT );
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $productID = $data['ProductID'];        // This holds the sanitized product ID
    $beerName = $data['Hops'];              // This holds the beer name


    // Previous PDO statement takes care of forthecoming queries
    $beersFound = $conn->query("SELECT * FROM GwenLavelle.Product WHERE Hops = '$beerName'")->fetchAll(PDO::FETCH_ASSOC);

    // Checks to see if there is an existing record with the beer product ID in the Counter Table
    $counterFound = $conn->query("SELECT * FROM GwenLavelle.COUNTER WHERE P_ID = $productID")->fetch(PDO::FETCH_ASSOC);
    
    // If no record is found in the table, Insert a new record
    if (empty($counterFound)){
         $stmt = $conn->prepare("INSERT INTO GwenLavelle.COUNTER (P_ID, `COUNT`) VALUES ($productID, 1)");
        $stmt->execute();                
    } else { // If a record is found in the table, Update
        $stmt = $conn->prepare("UPDATE GwenLavelle.COUNTER SET `COUNT` = " . ($counterFound['COUNT']+1) . " WHERE P_ID = $productID");
        $stmt->execute();
    }
    #############################################################################################
    #############################################################################################
    foreach($beersFound as $key => $beer){
        echo "<div>#" . ++$key . " <b>$beer[BeerName] - $beer[Description]</b></div><br>";
    }

    }
    ?>


        <br />
        <br />
        <br />

    </section>

    <br />
    <br />














    <!-- end mian content area -->
    <footer>
        
    </footer>

    <!-- jQuery first, then Popper.js, then Bootstrap.js -->

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
</body>

</html>
