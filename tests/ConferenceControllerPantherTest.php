<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class ConferenceControllerPantherTest extends PantherTestCase
{
    public function testIndex()
    {
        $client = static::createPantherClient(['browser' => static::FIREFOX]);
        $client->request('GET', '/');

        $this->assertSelectorTextContains('h2', 'Give your feedback');

        $client->clickLink('Paris 2020');

        $client->takeScreenshot('screen.png');
    }
}
