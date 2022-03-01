<?php
//  Menu Category

$id = $page->title()->slug();

//  Redirect to the Menu page
go('/menu/#' . $id, 301);
?>
