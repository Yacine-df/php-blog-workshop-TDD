<?php

namespace  BlogTest\Unit;

use Blog\Model\Author;
use Blog\Model\Post;
use DateTimeImmutable;
use DomainException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase{

    public function  testAuthorPublishPost(){

        $title = "php from scratch";
        $body = "the body of the blog";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::publish($title, $body, $tags, $author);

        $this->assertTrue($post->isPublished());
    }

    public function  testAuthorDraftPost(){

        $title = "php from scratch";
        $body = "the body of the blog";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::draft($title, $body, $tags, $author);

        $this->assertTrue($post->isDrafted());
    }

    public function testvalidTitle(){

        $this->expectException(InvalidArgumentException::class);

        $title = "";
        $body = "the body of the blog";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::draft($title, $body, $tags, $author);

    }
    public function testTitleLengthMustNotBeMoreThan250chars(){

        $this->expectException(InvalidArgumentException::class);

        $title = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos fugiat blanditiis non in est quam temporibus sapiente eveniet corporis doloremque odit libero, eaque aliquam! Quidem perspiciatis earum accusamus reiciendis id.";
        $body = "the body of the blog";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::draft($title, $body, $tags, $author);

    }
    public function testBodyMustNotBeEmpty(){

        $this->expectException(InvalidArgumentException::class);

        $title = "endis id.";
        $body = "";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::draft($title, $body, $tags, $author);

    }

    public function testMarkPostAsPublished(){

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::draft($title, $body, $tags, $author);

        $post->markAsPublished();

        $this->assertTrue($post->isPublished());

    }
    
    public function testMarkAsPublishThrowWhenPostIsAlreadyPublish(){

        $this->expectException(DomainException::class);

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::publish($title, $body, $tags, $author);

        $post->markAsPublished();

    }

    public function testMarkPostAsDrafted(){

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::publish($title, $body, $tags, $author);

        $post->markAsDrafted();

        $this->assertTrue($post->isDrafted());

    }

    public function testMarkAsDraftThrowWhenPostIsAlreadyDraft(){

        $this->expectException(DomainException::class);

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::draft($title, $body, $tags, $author);

        $post->markAsDrafted();

    }

    public function testChangeTitle(){

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::publish($title, $body, $tags, $author);

        $post->changeTitle('title has been changed',$author);

        $this->assertEquals('title has been changed', $post->getTitle());

    }

    public function testEditBody(){

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::publish($title, $body, $tags, $author);

        $post->editBody('the body has been edited', $author);

        $this->assertEquals('the body has been edited', $post->getBody());

    }

    public function testChangeTitleOnlyByTheAuthorOfThePost(){

        $this->expectException(DomainException::class);

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::publish($title, $body, $tags, $author);

        $post->changeTitle('new title here', Author::named('test','df'));


    }

    public function testEditBodyOnlyByTheAuthorOfThePost(){

        $this->expectException(DomainException::class);

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::publish($title, $body, $tags, $author);

        $post->editBody('new body goes here', Author::named('test','df'));


    }

    public function testAddingTag(){

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code'];
        $author = Author::named('yacine','df');

        $post = Post::publish($title, $body, $tags, $author);
        $post->addTag('programming');

        $this->assertTrue($post->hasTag('programming'));

    }

    public function testThrowsWhenTryToAddMoreThen4Tags(){

        $this->expectException(DomainException::class);

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code', 'TDD'];
        $author = Author::named('yacine','df');

        $post = Post::publish($title, $body, $tags, $author);

        $post->addTag('programming');

    }
    public function testDeleteTag(){

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code', 'TDD'];
        $author = Author::named('yacine','df');

        $post = Post::publish($title, $body, $tags, $author);

        $post->deleteTag('programming');

        $this->assertFalse($post->hasTag('programming'));

    }

    public function testSetCreatedAtOnInitialPublish(){

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code', 'TDD'];
        $author = Author::named('yacine','df');

        $post = Post::publish($title, $body, $tags, $author);
        $this->assertInstanceOf(DateTimeImmutable::class, $post->getCreatedAt());
        $this->assertEquals('28/08/2023', $post->getCreatedAt()->format('d/m/Y'));

    }
    public function testSetCreatedAtOnInitialDraft(){

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code', 'TDD'];
        $author = Author::named('yacine','df');

        $post = Post::draft($title, $body, $tags, $author);
        $this->assertInstanceOf(DateTimeImmutable::class, $post->getCreatedAt());
        $this->assertEquals('28/08/2023', $post->getCreatedAt()->format('d/m/Y'));

    }
    public function testSetUpdatedAtOnSwitchingFromDraftToPublish(){

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code', 'TDD'];
        $author = Author::named('yacine','df');

        $post = Post::draft($title, $body, $tags, $author);
        $post->markAsPublished();
        $this->assertInstanceOf(DateTimeImmutable::class, $post->getUpdatedAt());

    }
    
    public function testSetUpdatedAtOnChangingTitle(){

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code', 'TDD'];
        $author = Author::named('yacine','df');

        $post = Post::publish($title, $body, $tags, $author);
        $post->changeTitle('new title here', $author);
        $this->assertInstanceOf(DateTimeImmutable::class, $post->getUpdatedAt());

    }
    
}


?>