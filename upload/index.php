<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>[vis.js] CSV Song Adder</title>
  <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
  <link rel="shortcut icon" href="https://www.monstercat.com/favicon.ico"/>
	<style>
		.wid{width: 425px;}
		form{text-align: center; margin-left: -150px;}
		html{zoom: 110%;}
		input{height: 50px;}
	</style>
</head>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		$key = filter_input(INPUT_POST, "key");
		$fileName = filter_input(INPUT_POST, "fileName");
		$artist = filter_input(INPUT_POST, "artist");
		$title = filter_input(INPUT_POST, "title");
		$subtitle = filter_input(INPUT_POST, "subtitle");
		$genre = filter_input(INPUT_POST, "genre");
		$url = filter_input(INPUT_POST, "url");

		//Important If Statements.
		
		$newartist = $artist;
		$newtitle = $title;
		$newsubtitle = $subtitle;
		
		if(empty($key))
		{
				$subtitle = str_replace('Feat', '', $subtitle);
				$subtitle = str_replace('Ft', '', $subtitle);
				$subtitle = str_replace('Remix', '', $subtitle);
				
			if (strlen($artist) > 5)
			{
				$newartist = substr($artist, 0, 5);
			}
			if (strlen($title) > 7)
			{
				$newtitle = substr($title, 0, 7);
			}
			if (strlen($subtitle) > 5)
			{
				$newsubtitle = substr($subtitle, 0, 7);
			}
			$key = $newsubtitle. $newartist . $newtitle;
			$key = preg_replace("/[^[:alnum:]]/ui", '', $key);
		}

		if(!empty($subtitle))
		{
			$title = $title . "<br>" . $subtitle;
		}
		
		if(empty($url))
		{
			$url = "...";
		}
		
		//Not so Important.
		if(empty($fileName))
		{
			exit("File Name Empty...");
		}
		if(empty($artist))
		{
			exit("Artist Empty...");
		}
		if(empty($title))
		{
			exit("Title Empty...");
		}
		if(empty($genre))
		{
			exit("GENRE Empty...");
		}
		
		
		$key = strtolower($key);
		
		 $output = $key . "|";
		 $output .= $fileName . "|";
		 $output .= $artist . "|";
		 $output .= $title . "|";
		 $output .= $genre . "|";
		 $output .= $url . "\n";
		 
		 $fp = fopen("../songs.csv", "a");
		 fwrite($fp, $output);
		 fclose($fp);
		 
		 $domain = $_SERVER['SERVER_NAME'];
		 
		 print"<div style=\"margin-left: 2%\">";
		 print"<h1 style=\"color:#0078e7\">Thanks!</h1>";
		 echo"Uploaded to:<b> $domain/?song=$key</b><br><br>";
		 echo"Or:<b> $domain/vis.js/?song=$key </b>";
		 echo "</div>";

	}
 ?>

 
<form action="" method="post" class="pure-form pure-form-aligned">
	
	<fieldset>	
		<div class="pure-controls">
		<h1><span style="color:#0078e7">[Vis.js]</span> Insert Into CSV Tool</h1>
		<p style="margin-top: -15px; font-size: 1.1em;">Move Audio to the Music Folder First.<br></p>
		</div>

		<div class="pure-control-group">
            <label for="key">Custom Key <b>(Optional)</b>:</label>
            <input class="wid" name='key' type="text" placeholder="Leave Blank for Automatic">
        </div>
		
		<div class="pure-control-group">
            <label for="key">Mp3 File Name:</label>
            <input class="wid" name='fileName' type="text" placeholder="filename + ' .mp3 / .m4a / .ogg '">
        </div>

        <div class="pure-control-group">
            <label for="artist">The Artist:</label>
            <input class="wid" name='artist' type="text" placeholder="Pegboard Nerds">
        </div>

        <div class="pure-control-group">
            <label for="Title">The Title:</label>
            <input class="wid" name='title' type="text" placeholder="Try This">
        </div>
		
		<div class="pure-control-group">
            <label for="subtitle">2 Lined Title <b>(Optional)</b>:</label>
            <input class="wid" name='subtitle' type="text" placeholder="Incept Remix / Ft. Incept">
        </div>
		
		<div class="pure-control-group">
            <label for="Title">URL / YouTube ID <b>(Optional)</b>:</label>
            <input class="wid" name='url' type="text" placeholder="xxxxxxxxxxx">
        </div>
		
        <div class="pure-control-group">
			<label for="Genre">Genre:</label>
			<select class="wid" type='text' name='genre' value=''>
				<option selected="selected" value="EDM">&nbsp;	</option>
				<option value="BTC">Build The Cities</option>
				<option value="Drum & Bass">Drum & Bass</option>
				<option value="Drumstep">Drumstep</option>
				<option value="Dubstep">Dubstep</option>
				<option value="EDM">EDM</option>
				<option value="Electro">Electro</option>
				<option value="Future Bass">Future Bass</option>
				<option value="Glitch Hop">Glitch Hop / 110BPM</option>
				<option value="Hardcore">Hard Dance</option>
				<option value="House">House</option>
				<option value="Nu Disco">Indie Dance / Nu Disco</option>
				<option value="Trance">Trance</option>
				<option value="Trap">Trap</option>
			</select>
		</div>		
<div class="pure-controls">
<input type="checkbox" id="checkme"/>&nbsp;
<b>I understand the <a target="_blank" href="privacy.html">Terms</a> and have checked for errors.</b></input></br>
</div>
        <div class="pure-controls">
            <button id="butt" disabled  type="submit" class="wid pure-button pure-button-primary">Submit</button>
        </div>

 </fieldset>

<script>
var checker = document.getElementById('checkme');
var sendbtn = document.getElementById('butt');
checker.onchange = function() {
sendbtn.disabled = !this.checked;
};
</script>