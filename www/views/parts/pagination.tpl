<div class="pagination">
	<?php 
	for ($page=1; $page <= $pagintation['number_of_pages']; $page++) { 
		$item_class = 'pagination__item';
		if ($pagintation['page_number'] == $page) {
			$item_class = $item_class . ' pagination__item--active' ;
		}
		echo '<a href="'.HOST.'blog?page='.$page.'" class="'.$item_class.'">'.$page.'</a>';
	}
	?>
</div>