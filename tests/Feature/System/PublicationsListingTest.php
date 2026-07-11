<?php

namespace Tests\Feature\System;

use App\Models\Publication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicationsListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_publications_listing_loads_successfully(): void
    {
        $this->get(route('site.publications'))->assertOk();
    }

    public function test_listing_paginates_at_twelve_per_page(): void
    {
        Publication::factory()->count(15)->create();

        $response = $this->get(route('site.publications'));

        $response->assertOk();
        $response->assertViewHas('publications', function ($publications) {
            return $publications->count() === 12 && $publications->total() === 15;
        });
    }

    public function test_listing_renders_skeleton_placeholders_before_js_runs(): void
    {
        $html = $this->get(route('site.publications'))->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<div class="publications-content">.*?skeleton.*?<\/div>/s', $html);
        $this->assertMatchesRegularExpression('/<div class="pagination">.*?skeleton.*?<\/div>/s', $html);
    }
}
