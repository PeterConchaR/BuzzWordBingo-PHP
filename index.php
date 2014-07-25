<?php 
require_once 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width" />
   <title>BuzzWordBingo</title>

   <link rel="stylesheet" type="text/css" href="css/jquery.ui.core.css"/>
   <link rel="stylesheet" type="text/css" href="css/jquery.ui.resizable.css"/>
   <link rel="stylesheet" type="text/css" href="css/jquery.ui.selectable.css"/>
   <link rel="stylesheet" type="text/css" href="css/jquery.ui.accordion.css"/>
   <link rel="stylesheet" type="text/css" href="css/jquery.ui.autocomplete.css"/>
   <link rel="stylesheet" type="text/css" href="css/jquery.ui.button.css"/>
   <link rel="stylesheet" type="text/css" href="css/jquery.ui.dialog.css"/>
   <link rel="stylesheet" type="text/css" href="css/jquery.ui.slider.css"/>
   <link rel="stylesheet" type="text/css" href="css/jquery.ui.tabs.css"/>
   <link rel="stylesheet" type="text/css" href="css/jquery.ui.datepicker.css"/>
   <link rel="stylesheet" type="text/css" href="css/jquery.ui.progressbar.css"/>
   <link rel="stylesheet" type="text/css" href="css/jquery.ui.theme.css"/>
   <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
   <link rel="stylesheet" type="text/css" href="css/bootstrap.responsive.min.css"/>
   <link rel="stylesheet" type="text/css" href="css/site.css"/>
   <script type="text/javascript" src="js/modernizr.js"></script>
</head>
<body>
<div id="winner"><div>You've Won!</div><br /><button onclick="javascript:clearBoard();">New Game</button></div>
<div class="container">
<div class="row">
    <div class="span10 offset1">
   		<table class="table table-bordered board">
			<tbody>
			<?php
				$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
				$result = $mysqli->query('select id, word, definition from buzzwords order by rand() LIMIT 24');

				$count=0;
				for($row=0;$row < GRID_SIZE; $row++) {

					echo "<tr id='row".$row."'>\n";
					
					for($column = 0; $column < GRID_SIZE; $column++) {
						
						if(GRID_MIDDLE == $row && GRID_MIDDLE == $column) {
							echo "<td class='square-free'><a href='http://aka.ms/tryazuretoday' target='_blank'>";
                                			echo "<img src='images/try-azure-today.jpg' class='azure-ad' alt='Click to access 90-Day Free Trial' /></a></td>\n";
                                			continue;
						}
						$word = $result->fetch_assoc();
						echo "<td id='row".$row."_col".$column."' class='square' data-id='".$word['id']."' title='".$word['definition']."'>".$word['word']."</td>\n";
						$count++;
					}

					echo "</tr>\n";
				}
			?>
			</tbody>
   		</table>
	</div>
   </div>
</div>

   <script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
   <script type="text/javascript" src="js/jquery-ui-1.8.20.min.js"></script>
   <script type="text/javascript" src="js/bootstrap.min.js"></script>
   <script type="text/javascript" src="js/site.js"></script>
   <script type="text/javascript">
	setGridSize(<?php echo GRID_SIZE; ?>);
	setGridMiddle(<?php echo GRID_MIDDLE; ?>);
	initializeBoard(board);
   </script>
</body>
</html>
