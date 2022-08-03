<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    
    public function testHomePageCorrect()
    {
        $response = $this->get('/');

        $response->assertSeeText('Laravel');
    }

    public function testContactPageCorrect()
    {
        $response = $this->get('/contact');

        $response->assertSeeText('Contact');
    }
}
