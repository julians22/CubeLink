<?php

namespace App\Http\Controllers;

use App\Models\Click;
use App\Models\Link;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LinkRedirectController extends Controller
{
    public function __invoke(Request $request, int $linkId): RedirectResponse
    {
        $link = Link::query()
            ->whereKey($linkId)
            ->where('is_active', true)
            ->firstOrFail();

        Click::query()->create([
            'link_id' => $link->id,
            'clicked_at' => now(),
            'ip_address' => $request->ip() ?? '0.0.0.0',
            'user_agent' => (string) ($request->userAgent() ?? ''),
            'referrer' => $request->headers->get('referer'),
        ]);

        return redirect()->away($link->url);
    }
}
