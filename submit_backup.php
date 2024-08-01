<?
$page_privacy = "admin";
require_once('../simple_security/check.php');
require_once('../../mysql_creds.php');
require_once("credentials.php");



// •TABLE: superbook
// •ID , URL. TITLE, STATUS, suggested_by, added, finished, recommend, kindle, terms, cost, note, type, bankrupcy


//TO DO:
// validate variables for each insert


$URL = $_GET['url'];
$TITLE = $_GET['title'];
$desc = $_GET['desc'];
$image = $_GET['image'];
// $STATUS = $_GET[''];
$added= $_GET['time'];
// $finished= $_GET[''];
// $reccomend= $_GET['rec'];
// $kindle= $_GET[''];
$terms = $_GET['term'];
if (isset($_GET['rec'])){ $suggested_by= $_GET['rec'];}else{$suggested_by='';}
if (isset($_GET['cost'])){ $cost= $_GET['cost'];}else{$cost='';}
if (isset($_GET['note'])){ $note= $_GET['note'];}else{$note='';}
$type= $_GET['options'];
//$bankrupcy = $_GET[''];


$redirect ='
 Redirecting <span id="countdown">5</span> seconds

<!-- JavaScript part -->
<script type="text/javascript">

    // Total seconds to wait
    var seconds = 4;

    function countdown() {
        seconds = seconds - 1;
        if (seconds < 0) {
            // Chnage your redirection link here
            window.location = "'.$home.'";
        } else {
            // Update remaining seconds
            document.getElementById("countdown").innerHTML = seconds;
            // Count down using javascript
            window.setTimeout("countdown()", 1000);
        }
    }

    // Run countdown function
    countdown();

</script>';


$dupesql = "SELECT * FROM superbook  where (URL = '$URL')";
$duperaw = mysqli_query($link,$dupesql);
if (mysqli_num_rows($duperaw) > 0) {

echo 'This is a duplicate entry. ' . $redirect;

}else{

    $sql = "INSERT INTO superbook(
                                                    URL,
                                                    TITLE,
                                                    description,
                                                    image,

                                                    suggested_by,
                                                    added,

                                                    terms,
                                                    cost,
                                                    note,
                                                    type

                                                )

    VALUES (
                        '$URL',
                        '$TITLE',
                        '$desc',
                        '$image',

                        '$suggested_by',
                        '$added',

                        '$terms',
                        '$cost',
                        '$note',
                        '$type'
    )";

//echo $sql . '<HR>';

    if (mysqli_query($link, $sql)) {

echo "record created." . $redirect;

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($link);
    }
}
?>
