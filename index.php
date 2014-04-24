<?
	include_once 'poetrymagic/magic.php';
	$head = new Head();
	$head->addStyleSheet("/css/grid.css");
	$head->addLess("2013.less");

	echo $head;
?>

<?
	$poems = new BasicMagicGroup();
	$poems_index = new BasicMagicGroup();
	//echo varDump($poems);
	$poem_files = glob("*.html");
	$pretty_pictures = glob('../grimms/images/*.png');
	shuffle($poem_files);
	shuffle($pretty_pictures);
	foreach($poem_files as $key=>$poem){
		$poem_text = convertPoem($poem);
		$poems->make(basicMagicElement, array("div_class" => "poem_wrapper", "p_inner"=>$poem_text, "img_id"=>$poem, "img_src"=>$pretty_pictures[$key]));
		$poems_index->make(basicMagicElement, poemIndexSpecs($poem));
	}
	function convertPoem($poem_path){
		$poem = file_get_contents($poem_path);
		$poem = nl2br($poem);
		return $poem;
	}
	function poemIndexSpecs($poem_path){
		preg_match('|<b>(.*)</b>|', file_get_contents($poem_path), $matches);
		$poem_index_specs["li_inner"] = $matches[1];
		$poem_index_specs["a_href"] = "#".$poem_path;
		return $poem_index_specs;
	}
	//echo "<div class='testing'>{$poem_index}</div>";

	$poems_index->addEach("li");
	$poems_index->wrapEach("a");
	$poems->addEach("img");
	$poems->addEach("p");
	$poems->wrapEach("div");


?>
	<div class="grid-30 push-70 testing">
		<div class="title">
			<b>POETRY</b><br>
			<i>2013</i>
		</div>
		<ol class="">
			<?
				echo $poems_index
			?>
		</ol>
		<div class="credits">
			Edwin Fallwell <br>
			<a href = "http://housewithinahouse.com">House Within A House</a>
			2014 <br>
			<hr>
			images from: <br>Oxford's 1933 Grimm's Fairy Tales<br>
			background from: <br>subtlepatterns.com <br>
			I love: PHP!
		</div>
	</div>
	<div class = "grid-65 poem">
		<div class="header">
		</div>
	<?
		echo $poems
	?>
	</div>
