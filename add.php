<?
$page_privacy = "admin";
require_once('../simple_security/check.php');
require_once('../../mysql_creds.php');
require_once("credentials.php");

$url = $link -> real_escape_string($_GET["url"]);
$terms = $link -> real_escape_string($_GET["s"]);
$title = $link -> real_escape_string($_GET["title"]);
$desc = $link -> real_escape_string($_GET["desc"]);
$imageUrl = $link -> real_escape_string($_GET["image"]);


$time= time();

// Fallback image URL
$fallbackUrl = $root . 'labs/drag_and_drop/uploads/bcatdc_8-bit_image_that_says_404_bold_graphic_art_and_color_582acf73-2cdd-4145-ad64-0b1f512ab26a.png';



// Function to check if the URL resolves
function urlResolves($url) {
    // Ensure the URL is not empty
    if (empty($url)) {
        return false;
    }

    // Get headers of the URL
    $headers = @get_headers($url);
    
    // Check if headers are retrieved and the HTTP status code is 200 (OK)
    if ($headers && strpos($headers[0], '200') !== false) {
        return true;
    }
    return false;
}

// Check if the original image URL resolves
if (urlResolves($imageUrl)) {
    $image= $imageUrl;
} else {
    $image = $fallbackUrl;
}
?>
<!--
TODO:
• Add a category field and drive it off the DB
• Check for and prevent duplicates

TABLE: superbook
•ID , URL. TITLE, STATUS, suggested_by, added, finished, recommend, kindle, terms, cost, note, type, bankrupcy

-->
<html>
<head>
<!-- <script src="http://www.ben-connors.com/lib/awesomplete/awesomplete.js" async></script> -->
  <script
			  src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			  crossorigin="anonymous"></script>
  <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js'></script>
  <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />


<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col-sm-10">
			<P>
				<h3><i class="fa fa-bookmark" aria-hidden="true"></i> &nbsp;<a href="index.php">Superbook</a></h3>
			</P>
		</div>
	</div>
	<form action="submit.php" onsubmit="submitForm()">

	<div class="form-group row" style="margin-bottom:30px;">
		<div class="btn-group btn-group-toggle col-sm-12" data-toggle="buttons">
		  <label class="btn btn-secondary btn-lg active ">
			<input type="radio" name="options" id="option1" value="read" autocomplete="off" checked><i class="fa fa-book" aria-hidden="true"></i>
 Read
		  </label>
		  <label class="btn btn-secondary btn-lg">
			<input type="radio" name="options" id="option2" value="wish" autocomplete="off"><i class="fa fa-gift" aria-hidden="true"></i>
 Wishlist
		  </label>
		  <label class="btn btn-secondary btn-lg">
			<input type="radio" name="options" id="option3" value="bucketlist" autocomplete="off"><i class="fa fa-map-signs" aria-hidden="true"></i>
 Bucket list
		  </label>
		  <label class="btn btn-secondary btn-lg">
			<input type="radio" name="options" id="option4" value="cooltools" autocomplete="off"><i class="fa fa-paint-brush" aria-hidden="true"></i>
Cool Tools
		  </label>
		  <label class="btn btn-secondary btn-lg">
			<input type="radio" name="options" id="option5" value="info" autocomplete="off"><i class="fa fa-cloud" aria-hidden="true"></i>
 Save
		  </label>
		  
		</div>
	</div>

	  <div class="form-group row">
		<label for="title" class="col-sm-2 col-form-label"><i class="fa fa-bookmark" aria-hidden="true"></i> Title</label>
		<div class="col-sm-10">
		  <input type="text" class="form-control" id="title" name="title" value="<? echo $title; ?>">
		</div>
	  </div>

      <div class="form-group row">
		<label for="title" class="col-sm-2 col-form-label"><i class="fa fa-align-left" aria-hidden="true"></i> Description </label>
		<div class="col-sm-10">
		  <input type="text" class="form-control" id="desc" name="desc" value="<? echo $desc; ?>">
		</div>
	  </div>
	
      <!----     TESTING QUILL.js  -->

      <!-- Include stylesheet -->
      <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

      <!-- Create the editor container -->
  <!--
      <div class="form-group row">
      <label for="title" class="col-sm-2 col-form-label"><i class="fa fa-align-left" aria-hidden="true"></i> Quill.js test </label>
      <div class="col-sm-10">

          <div id="editor">
            <p>Hello World!</p>
            <p>Some initial <strong>bold</strong> text</p>
            <p><br></p>
          </div>

      </div>
    </div>
-->

      <!-- Include the Quill library -->
      <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

      <!-- Initialize Quill editor -->
      <script>
        var quill = new Quill('#editor', {
          theme: 'snow'
        });
      </script>


<input type="hidden" name="quill" id="quillContent">



<!--- -->
	  <div class="form-group row">
		<label id="extraLabel" for="extra" class="col-sm-2 col-form-label"><i class="fa fa-address-book" aria-hidden="true"></i> Rec by</label>
		<div class="col-sm-10">
		  <input id="extraInput" type="text" class="form-control form-control-sm" id="extra" name="rec" placeholder="Who recommended this story?">
		</div>
	  </div>

	  <div class="form-group row">
		<label for="url" class="col-sm-2 col-form-label"> <i class="fa fa-link" aria-hidden="true"></i> Url</label>
		<div class="col-sm-10">
		  <input type="text" class="form-control form-control-sm" id="url" name="url" value="<? echo $url; ?>">
		</div>
	  </div>

	  <div class="form-group row">
		<label for="terms" class="col-sm-2 col-form-label"><i class="fa fa-tags" aria-hidden="true"></i> Terms</label>
		<div class="col-sm-10">
		  <input type="text" class="form-control form-control-sm" id="terms" name="term" value="<? echo $terms; ?>">
		</div>
	  </div>

	  <div class="form-group row">
		<label for="time" class="col-sm-2 col-form-label"> <i class="fa fa-clock-o" aria-hidden="true"></i> Time</label>
		<div class="col-sm-4">
		  <input type="text" class="form-control form-control-sm" id="time" value="<? echo date("M j, Y, g:i a" ,$time); ?>" readonly>
		  <input type="hidden" name="time" value="<? echo $time; ?>">
		</div>
        <div class="col-sm-4">
            <img style="width:100%;"src="<? echo $image; ?>">
            <input type="hidden" name="image" value="<? echo $image; ?>">
        </div>
		<div class="col-sm-2 ">
	  		<button type="submit" class="btn btn-primary btn-sm " style="text-align:center; width:100%;"><i class="fa fa-bookmark fa-3x" aria-hidden="true"></i><BR>Save &nbsp; </button>
	  	</div>
        <div class="col-sm-2 ">
            <!--
            <a href="javascript:(function()%7Bvar%20keywords%3D%27%27%3Bvar%20metas%3Ddocument.getElementsByTagName(%27meta%27)%3B%20for%20(var%20x%3D0,y%3Dmetas.length%3B%20x%3Cy%3B%20x%2B%2B)%20%7Bif%20(metas%5Bx%5D.name.toLowerCase()%20%3D%3D%20%27keywords%27)%20%7Bkeywords%20%2B%3D%20metas%5Bx%5D.content%3B%7D%7D%20open%20(%27http://[INTENTIONALLY BLANK]superbook/add.php%3Fs%3D%27%2BencodeURIComponent(keywords)%2B%27%26url%3D%27%2BencodeURIComponent(location.href)%2B%27%26title%3D%27%2BencodeURIComponent(document.title))%3Bdocument.getElementsByTagName(%27head%27)%5B0%5D.appendChild(jsScript)%3B%7D)()%3B">
            <i class="fa fa-bookmark" aria-hidden="true"></i> OLD Superbook
            </a>
            -->

            <a href="javascript:(function()%7Bconsole.log('1')%3Bif%20(document.getElementsByTagName('meta')%20!%3D%3D%20null)%7Bvar%20metas%20%3Ddocument.getElementsByTagName('meta')%3B%7Delse%7Bvar%20metas%20%3D''%3B%7Dconsole.log('2')%3Bif%20(document.querySelector(%22meta%5Bproperty%3D'og%3Aimage'%5D%22)%20!%3D%3D%20null)%7Bvar%20image%3D%20document.querySelector(%22meta%5Bproperty%3D'og%3Aimage'%5D%22).getAttribute(%22content%22)%3B%7Delse%20%7Bvar%20image%3D%22%22%3B%7Dconsole.log('3')%3Bif%20(document.querySelector(%22meta%5Bname%3Ddescription%5D%22)%20!%3D%3D%20null)%7Bvar%20description%20%3Ddocument.querySelector(%22meta%5Bname%3Ddescription%5D%22).getAttribute(%22content%22)%20%7C%7C%20''%3B%7Delse%20%7Bvar%20description%20%3D''%3B%7Dconsole.log('4')%3Bvar%20keywords%3D''%3Bfor%20(var%20x%3D0%2Cy%3Dmetas.length%3B%20x%3Cy%3B%20x%2B%2B)%20%7Bif%20(metas%5Bx%5D.name.toLowerCase()%20%3D%3D%20'keywords')%7Bkeywords%20%2B%3D%20metas%5Bx%5D.content%3B%7D%7Dconsole.log('5')%3Bpasslink%20%3D%20%20%20%20%20%20%20%20%20'http%3A%2F%2F<?php echo $domain;?>%2Fsuperbook%2Fadd.php%3F'%2B's%3D'%2BencodeURIComponent(keywords)%2B'%26url%3D'%2BencodeURIComponent(location.href)%2B'%26title%3D'%2BencodeURIComponent(document.title)%2B'%26image%3D'%2BencodeURIComponent(image)%2B'%26desc%3D'%2BencodeURIComponent(description)%3Bconsole.log(passlink)%3Bwindow.location.replace(passlink)%7D)()"
            <i class="fa fa-bookmark" aria-hidden="true"></i> Superbook
            </a>

        </div>
	  </div>


	</form>

</div>



<script>

function submitForm() {
            // Get the HTML content from the Quill editor
            var quillHtml = quill.root.innerHTML;

            // Set the hidden input field's value to the Quill editor content
            document.getElementById('quillContent').value = quillHtml;
        }

$(".btn-group-toggle").on('change', function() {
let mode = $( "input:checked" ).val();


console.log(mode);
switch(mode) {
  case 'read':
  	$("#extraLabel").html('<i class="fa fa-address-book" aria-hidden="true"></i> Rec by');
  	$("#extraInput").attr({"placeholder": "Who recommended this story?","name": "rec","type": "text"});
  	break;
  case 'wish':
  	$("#extraLabel").html('<i class="fa fa-money" aria-hidden="true"></i> Price');
  	$("#extraInput").attr({"placeholder": "Price in dollars","name": "cost","type": "number"});
    break;

case 'bucketlist':
  	$("#extraLabel").html('<i class="fa fa-money" aria-hidden="true"></i> Rec by');
  	$("#extraInput").attr({"placeholder": "Time in hours","name": "time","type": "number"});
      break;
case 'cooltools':
  	$("#extraLabel").html('<i class="fa fa-sticky-note" aria-hidden="true"></i> Rec by');
  	$("#extraInput").attr({"placeholder": "What medium is this for","note": "medium","type": "text"});
break;
  case 'info':
  	$("#extraLabel").html('<i class="fa fa-sticky-note" aria-hidden="true"></i> Note');
  	$("#extraInput").attr({"placeholder": "What are we saving this for?","note": "rec","type": "text"});
      break;

}

})
</script>

</html>
