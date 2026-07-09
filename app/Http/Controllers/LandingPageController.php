<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Contracts\View\View;

class LandingPageController extends Controller
{
    public function showDefault(): View
    {
        $landingPage = LandingPage::query()
            ->with(['links' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order')])
            ->firstOrFail();

        $featuredSlides = $landingPage->links
            ->take(5)
            ->values()
            ->map(fn ($link) => [
                'id' => $link->id,
                'title' => $link->label,
                'subtitle' => parse_url($link->url, PHP_URL_HOST) ?: $link->url,
                'href' => route('links.redirect', ['linkId' => $link->id]),
            ]);

        return view('landing-page', [
            'landingPage' => $landingPage,
            'featuredSlides' => $featuredSlides,
        ]);
    }
}
