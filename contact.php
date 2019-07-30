<!-- Gwendolyn Lavelle -->
<?php 

error_reporting(-1);
 ini_set('display_errors', 'On');

include "../inc/dbinfo.inc"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- REQUIRED meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, intial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

    <!-- Style Sheet refrences-->
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
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            </ul>
        </div>
    </nav>


    <!-- Begins main content area -->
    <br />
    <br />
    <br />


    <div style="background-color:lightgray" align="left">
  <center><h3>Join our mailing list for brewing and event updates!</h3></center>
</div>


    
        <form name="contactForm" method="post" action="">

<!-- Styling for contact form table-->
            <style>
        table {
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: lightgray;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>

            <!--Begins contact form table which includes first name, last name, and email - all fields are required in order to submit form-->

            <table width="450px">
                <tr>
                    <td valign="top">
                        <label for="first_name">
                            <b>First Name *</b>
                        </label>
                    </td>
                    <td valign="top">
                        <input type="text" name="FIRST_NAME" maxlength="50" size="30" required />
                    </td>
                </tr>
                <tr>
                    <td valign="top" ">
                        <label for="last_name">
                            <b>Last Name *</b>
                        </label>
                    </td>
                    <td valign="top">
                        <input type="text" name="LAST_NAME" maxlength="50" size="30" required />
                    </td>
                </tr>
                <tr>
                    <td valign="top">
                        <label for="email">
                            <b>Email Address *</b>
                        </label>
                    </td>
                    <td valign="top">
                        <input type="text" name="EMAIL" maxlength="80" size="30" required />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center">
                        <input type="submit" name="submit" value="Submit" />
                    </td>
                </tr>
            </table>
        </form>



        <br />
        <div style="background-color:lightgray" align="left">
            <center>
                <h3>Would you like to remove yourself from our email list? No problem, just enter your valid email address below!</h3>
            </center>
        </div>
        <br />

    <!--Begins delete form table which includes customer email - all fields are required in order to submit form - 
        although only email is required entire record will be removed from the database -->

        <section id="delete form">
            <form name="deleteform" method="post" action="">

                <table width="450px">
                    <tr>
                        <td valign="top">
                            <label for="DeleteEmail">
                                <b>Remove Email Address *</b>
                            </label>
                        </td>
                        <td valign="top">
                            <input type="text" name="EMAIL" maxlength="80" size="30" required/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center">
                            <input type="submit" name="delete" value="Delete" />
                        </td>
                    </tr>
                </table>
            </form>
        </section>
</body>
</html>



<?php
// insert first name, last name, and email into customer database




/* Security implementation to avoid from SQL Injections and XXS
 PDO statements are used for security and database integrity
 Once the record is submitted - an alert will be shown at the bottom of the webpage ensuring the record has been added */

if (isset($_POST['submit'])) {
    #############################################################################################
    #                                   INSERT Record Into Database                             #
    #############################################################################################
    $stmt = $conn->prepare("INSERT INTO GwenLavelle.Customer (FIRST_NAME, LAST_NAME, EMAIL) VALUES (:FIRST, :LAST, :EMAIL)");
    $stmt->bindValue( "FIRST",             $_POST['FIRST_NAME'],                                   PDO::PARAM_STR );
    $stmt->bindValue( "LAST",             $_POST['LAST_NAME'],                                     PDO::PARAM_STR );
    $stmt->bindValue( "EMAIL",             $_POST['EMAIL'],                                        PDO::PARAM_STR );
    $stmt->execute();
    #############################################################################################
    #############################################################################################

    echo "<center><b>Submitted successfully!</b></center>";

}
//error_reporting(-1);
//ini_set('display_errors', 'On');
//var_dump($_POST);


/* Security implementation to avoid from SQL Injections and XXS
 PDO statements are used for security and database integrity
 Once the email is submitted - an alert will be shown at the bottom of the webpage ensuring the record has been deleted from the database
 Only the email is required and must be a valid email recorded - entire record will be deleted */

if (isset($_POST['delete'])) {

    // Checking for a valid email address via PHP sanitization filters
    if (filter_var($_POST['EMAIL'], FILTER_VALIDATE_EMAIL)){


        #############################################################################################
        #                                   Check of Email exists                                   #
        #############################################################################################
        $stmt = $conn->prepare("SELECT * FROM GwenLavelle.Customer WHERE EMAIL = :EMAIL");
        $stmt->bindValue( "EMAIL",             $_POST['EMAIL'],                                        PDO::PARAM_STR );
        $stmt->execute();
        $emailFound = $stmt->fetch(PDO::FETCH_ASSOC);
        #############################################################################################
        #############################################################################################


        if ($emailFound){
            #############################################################################################
            #                                   DELETE Record From Database                           #
            #############################################################################################
            $stmt = $conn->prepare("DELETE FROM GwenLavelle.Customer WHERE EMAIL=:EMAIL");
            $stmt->bindValue( "EMAIL",             $_POST['EMAIL'],                             PDO::PARAM_STR );
            $stmt->execute();
            #############################################################################################
            #############################################################################################

            echo "<center><b>Deleted successfully!</b></center>";

        } else
            echo "<center><b>Email not found. Please try again.</b></center>";



    } else {
        die("<center><b>Please enter valid email address</b></center>");
    }




}

?>

