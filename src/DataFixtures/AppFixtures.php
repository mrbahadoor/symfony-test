<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $blogPost = new BlogPost();
        $blogPost->setTitle('A first post!');
        $blogPost->setPublished(new \DateTime('2023-09-13 12:00:00'));
        $blogPost->setContent('Post text!');
        $blogPost->setAuthor('Rushdi Bahadoor');
        $blogPost->setSlug('a-first-post');
        $manager->persist($blogPost);

        $blogPost = new BlogPost();
        $blogPost->setTitle('A second post!');
        $blogPost->setPublished(new \DateTime('2023-09-13 12:00:00'));
        $blogPost->setContent('Post text2!');
        $blogPost->setAuthor('Rushdi Bahadoor');
        $blogPost->setSlug('a-second-post');
        $manager->persist($blogPost);

        $manager->flush();
    }
}
