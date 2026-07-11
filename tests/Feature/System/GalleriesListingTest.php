<?php

namespace Tests\Feature\System;

use App\Models\Gallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleriesListingTest extends TestCase
{
    use RefreshDatabase;

    public function test_galleries_listing_loads_successfully(): void
    {
        $this->get(route('site.gallery'))->assertOk();
    }

    public function test_listing_paginates_at_ten_per_page(): void
    {
        Gallery::factory()->count(13)->create();

        $response = $this->get(route('site.gallery'));

        $response->assertOk();
        $response->assertViewHas('galleries', function ($galleries) {
            return $galleries->count() === 10 && $galleries->total() === 13;
        });
    }

    public function test_listing_renders_skeleton_placeholders_before_js_runs(): void
    {
        $html = $this->get(route('site.gallery'))->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<div class="galleries">.*?skeleton.*?<\/div>/s', $html);
        $this->assertMatchesRegularExpression('/<div class="pagination">.*?skeleton.*?<\/div>/s', $html);
    }
}
