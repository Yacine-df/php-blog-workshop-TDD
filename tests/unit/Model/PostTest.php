<?php

namespace  BlogTest\Unit;

use Blog\Model\Post;
use DomainException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase{

    public function  testAuthorPublishPost(){

        $title = "php from scratch";
        $body = "the body of the blog";
        $tags = ['php','db','code'];
        $author = 'yacine';

        $post = Post::publish($title, $body, $tags, $author);

        $this->assertTrue($post->isPublished());
    }

    public function  testAuthorDraftPost(){

        $title = "php from scratch";
        $body = "the body of the blog";
        $tags = ['php','db','code'];
        $author = 'yacine';

        $post = Post::draft($title, $body, $tags, $author);

        $this->assertTrue($post->isDrafted());
    }

    public function testvalidTitle(){

        $this->expectException(InvalidArgumentException::class);

        $title = "";
        $body = "the body of the blog";
        $tags = ['php','db','code'];
        $author = 'yacine';

        $post = Post::draft($title, $body, $tags, $author);

    }
    public function testTitleLengthMustNotBeMoreThan250chars(){

        $this->expectException(InvalidArgumentException::class);

        $title = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos fugiat blanditiis non in est quam temporibus sapiente eveniet corporis doloremque odit libero, eaque aliquam! Quidem perspiciatis earum accusamus reiciendis id.";
        $body = "the body of the blog";
        $tags = ['php','db','code'];
        $author = 'yacine';

        $post = Post::draft($title, $body, $tags, $author);

    }
    public function testBodyMustNotBeEmpty(){

        $this->expectException(InvalidArgumentException::class);

        $title = "endis id.";
        $body = "";
        $tags = ['php','db','code'];
        $author = 'yacine';

        $post = Post::draft($title, $body, $tags, $author);

    }

    public function testMarkPostAsPublished(){

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code'];
        $author = 'yacine';

        $post = Post::draft($title, $body, $tags, $author);

        $post->markAsPublished();

        $this->assertTrue($post->isPublished());

    }
    
    public function testMarkAsPublishThrowWhenPostIsAlreadyPublish(){

        $this->expectException(DomainException::class);

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code'];
        $author = 'yacine';

        $post = Post::publish($title, $body, $tags, $author);

        $post->markAsPublished();

    }

    public function testMarkPostAsDrafted(){

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code'];
        $author = 'yacine';

        $post = Post::publish($title, $body, $tags, $author);

        $post->markAsDrafted();

        $this->assertTrue($post->isDrafted());

    }

    public function testMarkAsDraftThrowWhenPostIsAlreadyDraft(){

        $this->expectException(DomainException::class);

        $title = "endis id.";
        $body = "fdfsdf";
        $tags = ['php','db','code'];
        $author = 'yacine';

        $post = Post::draft($title, $body, $tags, $author);

        $post->markAsDrafted();

    }
    
}


?>