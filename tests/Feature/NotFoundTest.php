<?php

namespace Tests\Feature;

use Tests\TestCase;

class NotFoundTest extends TestCase
{
    public function test_unknown_route_renders_custom_404_page(): void
    {
        $this->get('/this-page-does-not-exist')
            ->assertNotFound()
            ->assertSee('404 Asymmetrical | Noir/Studio', false)
            ->assertSee('LOST IN THE')
            ->assertSee('PROCESS')
            ->assertSee('Return to Surface')
            ->assertSee('Browse Archive');
    }

    public function test_404_page_links_to_home_and_works(): void
    {
        $this->get('/missing-route-404-test')
            ->assertNotFound()
            ->assertSee(route('home'), false)
            ->assertSee(route('works.index'), false);
    }
}
