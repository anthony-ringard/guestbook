<?php


namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConferenceControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET','/');


        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Give your feedback');

    }


    public function testCommentSubmission()
    {
        $client = static::createClient();
        $client->request('GET', '/conference/amsterdam');
        $client->submitForm('Submit',
            [
                'comment_form[author]' => 'toto',
                'comment_form[text]' => 'that so great',
                'comment_form[email]' => 'toto@yopmail.com',
                'comment_form[photo]' => dirname(__DIR__,2).'/public/images/under-construction.png',
            ]);


        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('div:contains("There are 2 comments")');

    }


    public function testConferencePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET','/');

        $this->assertCount(2, $crawler->filter('h4'));

        $client->clickLink('Views');

        $this->assertPageTitleContains('Amsterdam');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h3', 'Amsterdam 2019');
        $this->assertSelectorExists('div:contains("There are 1 comments")');

    }

}