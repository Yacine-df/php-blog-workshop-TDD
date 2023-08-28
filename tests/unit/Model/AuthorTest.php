<?php

namespace  BlogTest\Unit;

use Blog\Model\Author;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase{

    /** @test */
    public function it_can_edit_its_biography(){

        $author = Author::named('yacine','df');
        $author->editBiography('this is a biography');
        $this->assertTrue($author->hasBiography());

    }
    /** @test */
    public function it_can_be_compared_with_others(){

        $author = Author::named('yacine','df');
        $another = Author::named('yacine','df');
        $this->assertTrue($author->HeIs($another));

    }

}

?>