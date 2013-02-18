<?php



include 'dbconfig.php';


$ingredient = mysql_real_escape_string($_GET['ingSearchfield']);

$query = "SELECT * FROM Recipes b JOIN cookingmethod a ON b.cookingmethodID = a.methodID JOIN dish c ON b.dishID = c.dishID WHERE ";

$terms = preg_split("/[\s,]+/", $ingredient);



	foreach ($terms as $each) {
			$i++;
			
			if($i == 1)
				$query .= "ingredients LIKE '%".$each."%' ";
				else
				$query .= "AND ingredients LIKE  '%".$each."%' ";
	}
					
		

if ($ingredient ==NULL)
		echo "Please enter ingredient";
else
	{ 
	
	
	

 	
	


	
	
	$sort = $_GET['sort'];
	
	$filter = $_GET['filter'];
					if ($filter != NULL)
		
			$query .= "AND dish = '$filter' ";
			
	
	
	if ($sort != NULL)
		$query .= "ORDER by $sort, title";
		else {
		$query .= "ORDER by title";
		}
		
		$result = mysql_query($query);
		$resultrows = mysql_num_rows($result);
		
		$perpage = 4;
		$pages = ceil($resultrows / $perpage);
		$page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
		$start = ($page -1) * $perpage; 
	
		$query .= " LIMIT $start, $perpage  ";
	

		$result = mysql_query($query);
		$resultrows = mysql_num_rows($result);
	
	
	

	if ($resultrows==0)
			if ($filter != NULL){
					echo "No results found with this filter: $filter";
					}
			else
						echo "Sorry, we did not find any recipes with these ingredients: '$ingredient'";
				
	else
		{ 
		
		$LineNum=0;
		echo((isset($_GET['sort']))? '<div class="pageBox"><a id ="button" href="search.php?ingSearchfield='.$ingredient.'&page='.$page.'"><span>Unsort</span></a></div>' : '');
		while ($line=mysql_fetch_assoc($result)) {
			$rating = ($line['rating']) *20; 
		echo '<div' .(($LineNum++ & 1) ? ' class="resultBox"' : ' class="resultBoxalt"'). '><div class="img"><img src="showfile.php?id='.$line['recipeID'] . '" width="100" height="100"><p><b>Dish: </b>'.$line['dish'].'</p></div><div class="instructions"><a id="recipeTitle" href="recipe.php?ingSearchfield='.$ingredient.'&recipeid='.$line['recipeID'].'"><h3><span>' .$line['title']. '</span></h3></a><ul class="star-rating">
		<li class="current-rating" style="width:'.$rating.'%;">Currently 3/5 Stars.</li>
		<li title="1 star out of 5" class="one-star"></li>
		<li title="2 stars out of 5" class="two-stars"></li>
		<li title="3 stars out of 5" class="three-stars"></li>
		<li title="4 stars out of 5" class="four-stars"></li>
		<li title="5 stars out of 5" class="five-stars"></li>
	</ul><p>'.substr($line['instructions'], 0, 80) . '...</p></div><div class="ingredients"> <p><b>Ingredients:</b>' . substr($line['ingredients'], 0, 80) . '</p></div><div class="cost"><p> <a id ="sort" href="search.php?ingSearchfield='.$ingredient.'&page='.$page.'&sort=cost"><span>Cost:<span></a> $'.$line['cost'].'</p></div><div class="preptime"><p><a id ="sort" href="search.php?ingSearchfield='.$ingredient.'&page='.$page.'&sort=preptime"> <span>Prep Time:</span></a>'.$line['preptime'].' </p> </div><div class="cookmethod"><p><a id ="sort" href="search.php?ingSearchfield='.$ingredient.'&page='.$page.'&sort=method"><span>Method:</span></a>'.$line['method'].'</p></div></div>';
		
				}
				
				
	} 
	
	
	}
	if ($pages >= 1 && $page <= $pages) {
		echo '<div class="pageBox"> <b>Pages:</b> ';
	for ($x=1; $x<=$pages; $x++) {
		echo ($x == $page) ? '<b><a href="search.php?ingSearchfield='.$ingredient.'&page='.$x.'">'.$x.'</a></b> ' : '<a href="search.php?ingSearchfield='.$ingredient.'&page='.$x.((isset($_GET['sort'])) ? ' &sort='.$sort.'' : '').((isset($_GET['filter'])) ? ' &filter='.$filter.'' : '').'">'.$x.'</a> ';
	}
	echo '</div>';
	}
	

?>