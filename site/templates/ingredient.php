<?php
$id = $page->title()->slug();

//  Redirect to the Allergen page
go('/allergens/#' . $id, 301);
?>
