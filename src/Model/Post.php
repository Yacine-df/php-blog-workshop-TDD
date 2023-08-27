<?php

namespace Blog\Model;

use DomainException;
use InvalidArgumentException;

class Post
{
    private $id;
    private $title;
    private $tags;
    private $body;
    private $status;
    private $author;

    private function __construct(string $title, string $body,array $tags = [], string $author, $status){

        $this->setTitle($title);
        $this->setBody($body);
        $this->tags = $tags;
        $this->author = $author; 
        $this->status = $status;

    }

    public static function publish($title, $body, $tags, $author){

        $post = new Post($title, $body, $tags, $author, 'publish');

        return $post;

    }

    public function isPublished(){

        return $this->status === "publish";

    }

    public function markAsPublished(){

        if ($this->isPublished()) {

            throw new DomainException();
            
        }

        return $this->status = "publish";

    }

    public static function draft($title, $body, $tags, $author){

        $post = new Post( $title,  $body, $tags = [],  $author, 'draft');

        return $post;

    }

    public function isDrafted(){

        return $this->status === "draft";

    }
    

    public function markAsDrafted(){

        if ($this->isDrafted()) {
            
            throw new DomainException();

        }

        return $this->status = "draft";

    }

    public function addTag(string $tag){

        if (count($this->tags) >= 4 ) {
            return throw new DomainException('your adding more then 4 TAGS allowed just 4');
        }

        if (! $this->hasTag($tag)) {
            $this->tags[] = $tag; 
        }

    }

    public function hasTag(string $tag){

        return in_array($tag, $this->tags);

    }

    public function deleteTag(string $tag){

        if ($this->hasTag($tag)) {
            unset($this->tags[$tag]);
        }

    }

    public function changeTitle(string $title, string $author){

        if (! $this->isWrittenByAuthor($author)) {
            
            throw new DomainException();

        }

        $this->setTitle($title);

    }

    public function editBody(string $body, string $author){

        if (! $this->isWrittenByAuthor($author)) {
            
            throw new DomainException();

        }

        $this->setBody($body);

    }

    public function isWrittenByAuthor($author){

        return $this->author === $author;

    }

    public function getId(){

        return $this->id;

    }
    private function setId($id){

        $this->id = $id;

    }

    public function getTitle(){

        return $this->title;

    }
    private function setTitle($title){

        if (empty($title)) {

            throw new InvalidArgumentException('Title must not be empty string');

        }
        if (strlen($title) > 50) {

            throw new InvalidArgumentException('Title must not be more than 50');

        }

        $this->title = $title;

    }
    public function getTags(){

        return $this->tags;

    }
    private function setTags(array $tags){

        $this->tags = $tags;

    }
    private function setBody($body){

        if (empty($body)) {

            throw new InvalidArgumentException('Body must not be empty string');

        }

        $this->body = $body;

    }
    public function getBody(){

        return $this->body;

    }
    
}

?>