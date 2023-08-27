<?php

use Blog\Model\Post;

    require "../vendor/autoload.php";

    $post = new Post();

    $post->setTitle('php app from scratch');
    
    echo  $post->getTitle();



?>
<html</html>