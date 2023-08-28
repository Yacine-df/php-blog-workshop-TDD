<?php

namespace Blog\Model;

class Author{

    private string $firstname;
    private string $lastname;
    private ?string $biography;

    private function __construct(string $firstname, string $lastname, ?string $biography=NULL)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->biography = $biography;
    }
    public static function named(string $firstname,string $lastname, ?string $biography=NULL){

        return new Author($firstname, $lastname);

    }
    public function editBiography(string $biography){

        return $this->biography = $biography;

    }
    public function hasBiography(){

        return $this->biography != NULL;

    }
    public function heIs(Author $author){

        return ($this->firstname == $author->firstname 
                && $this->lastname == $author->lastname 
                && $this->biography == $author->biography);

    }
}