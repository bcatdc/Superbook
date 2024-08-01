<?


//TABLE: superbook
//•ID , URL. TITLE, STATUS, suggested_by, added, finished, recommend, kindle, terms, cost, note, type, bankrupcy, image, description

//todo

//Figure out how to best double open
// Filter the list by: Read
// Filter the list by bakrupcty - Turn bankrupcy on and off


// Add, Wish, Note
// Add reccomendation, rating and logging features.

$page_privacy = "admin";
require_once('../simple_security/check.php');
require_once('../../mysql_creds.php');
?>
<html>
<?

/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
// Which TYPE of list to QUERY
//Default: READ || ALT = WISH or NOTE
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_GET['type'])){
	$list = $_GET['type'];
}else{
	$list = 'read';
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
// TABLE or CARD VIEW
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////

//Default to TABLE option
//if ($_GET['view']!=card){
if ($_GET['view']=="table"){ ?>
	<style>
				.cardView{ display:none;}
				.tableView{display:block;}
			 	#goToCard{display:block;}
				#goToTable{ display:none;}
	</style>
<?
}else {
?>
	<style>
	 		.tableView{ display:none;}
			.cardView{display:block;}
			#goToTable{display:block;}
			#goToCard{ display:none;}
	</style>
<?
}


?>

<script
			src="https://code.jquery.com/jquery-3.4.1.min.js"
			integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			crossorigin="anonymous"></script>

<script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js'></script>
<script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<style>

body{
	background-color: #eee;
}

.card-columns {
column-count: 2;
}
a{
	cursor: pointer;
}
i{
	color:#999;
	font-weight: 600;
}


.close-button {
  position: absolute;
  top: -5px;
  right: -5px;
  font-size: 24px;
  cursor: pointer;
  width: 30px;
  height: 30px;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 50%;
  background-color: lightgray;
  transition: background-color 0.3s ease;
  //border:3px solid white;
}

.close-button:hover {
  background-color: gray;
}

/* Style the 'X' inside the button */
.close-button::before, .close-button::after {
  content: "";
  position: absolute;
  width: 2px;
  height: 20px;
  background-color: black;
}

.close-button::before {
  transform: rotate(45deg);
}

.close-button::after {
  transform: rotate(-45deg);
}




</style>

	<body>


		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <a class="navbar-brand" href="#"><i class="fa fa-bookmark" aria-hidden="true"></i> Superbook</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		  <div class="collapse navbar-collapse" id="navbarNavDropdown">
		    <ul class="navbar-nav">
		      <li class="nav-item">
		        <a class="nav-link" href="add.php">Add</a>
		      </li>
		      <li class="nav-item <? if ($list=="read"){echo 'active';} ?>">
		        <a class="nav-link" href="?type=read">Read</a>
		      </li>
		      <li class="nav-item <? if ($list=="wish"){echo 'active';} ?>">
		        <a class="nav-link" href="?type=wish">Wish</a>
		      </li>

			<li class="nav-item <? if ($list=="info"){echo 'active';} ?>">
				<a class="nav-link" href="?type=bucketlist"><i class="fa fa-map-signs" aria-hidden="true"></i>Bucket List</a>
			  </li>
			  <li class="nav-item <? if ($list=="cooltools"){echo 'active';} ?>">
				<a class="nav-link" href="?type=cooltools"><i class="fa fa-paint-brush" aria-hidden="true"></i>Cool Tools</a>
			  </li>

			  <li class="nav-item <? if ($list=="info"){echo 'active';} ?>">
				<a class="nav-link" href="?type=info">Note</a>
			</li>
			  <li class="nav-item" id="goToTable">
				<a class="nav-link" href="<? echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?type='.$list;  ?>&view=table">Table View</a>
			  </li>
			  <li class="nav-item" id="goToCard">
				<a class="nav-link" href="<? echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?type='.$list;  ?>&view=card"">Card View</a>
			  </li>
			  <!--
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Dropdown link
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
		          <a class="dropdown-item" href="#">Action</a>
		          <a class="dropdown-item" href="#">Another action</a>
		          <a class="dropdown-item" href="#">Something else here</a>
		        </div>
		      </li>
		  -->

		    </ul>
		  </div>
		</nav>



<div class="container">

<!--

Table Version


<table class="table table-striped table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
</tbody>
</table>

-->
<div class="cardView">
<div class="card-columns" style="margin-top:30px;">


<?


//


	// Perform query
if ($result = mysqli_query($link, "SELECT * FROM superbook WHERE  type ='$list'  AND bankrupcy is NULL order by added DESC")) {

while ($row = $result->fetch_assoc()) {
//echo '<div><a onclick="window.open(\''. $row['URL'] .'\'),window.open(\'youread.php\');">'. $row['TITLE'] .'</a></div>';

?>



<div class="card" style="margin:10px; padding:10px; box-shadow: 3px 3px 5px #ddd; background-color:#fff; ">
	<div style="overflow:auto;" >
		<div onclick="alert('YetToBuild')" class="close-button"></div>
		<a onclick="window.open('youread.php'), window.open('<? echo $row['URL'] ; ?>');">
			<img style="width:100%; margin-bottom:10px;" src="<? echo $row['image']; ?>"  onerror="this.onerror=null;this.src='../style/images/image404.jpg'";>
			<h5><? echo $row['TITLE']; ?></h5>
			<hr>
			<?  if(strlen($row['suggested_by'])>1){ echo '<i> Rec by: ' .$row['suggested_by']. '</i><BR>'; }?>
			<? echo $row['description']; ?>
		</a>
	</div>
</div>

<?

$table .=
	'<tr>
      <th scope="row"><img style="width:120px; margin-bottom:10px;" src="'. $row['image'] .'"  onerror="this.onerror=null;this.src=\'../style/images/image404.jpg\'";></th>
      <td><a onclick="window.open(\'youread.php\'), window.open(\''.$row['URL'] .'\');">'. $row['TITLE'] .'</a></td>
      <td>'.$row['description'].'</td>
      <td>'.$row['suggested_by'].'</td>
	  <td>'.date('h:i A M, d \'y ',$row['added']).'</td>
    </tr>';

}

}
	?>

</div>
</div>

<div class="tableView" style="margin-top:40px;">
	<table class="table table-striped table-dark table-responsive">
	  <thead>
	    <tr>
	      <th scope="col">Image</th>
	      <th scope="col">Title</th>
	      <th scope="col">Description</th>
		  <th scope="col">Rec by</th>
	      <th scope="col">Added</th>
	    </tr>
	  </thead>
	  <tbody>

	<?
	echo $table;
	?>

	  </tbody>
	</table>
</div>

</div>
</body>
</html>
