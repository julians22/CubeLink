<?php

namespace Database\Seeders;

use App\Models\Click;
use App\Models\LandingPage;
use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CubeLinkDemoSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::query()->updateOrCreate(
            ['email' => 'admin@cubelink.test'],
            [
                'name' => 'CubeLink Admin',
                'password' => Hash::make('password'),
            ]
        );

        $landingPage = LandingPage::query()->updateOrCreate(
            ['user_id' => $user->id, 'title' => 'CubeLink Demo'],
            [
                'description' => 'A modern BioLink profile powered by CubeLink.',
                'profile_picture' => 'profile-pictures/demo-avatar.png',
                'background_color' => '#f8fafc',
                'text_color' => '#0f172a',
                'theme_slug' => 'clean-sky',
                'custom_css' => null,
            ]
        );

        $landingPage->links()->delete();

        $links = [
            [
                'label' => 'Portfolio',
                'url' => 'https://example.com/portfolio',
                'icon' => 'heroicon-o-briefcase',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'label' => 'Instagram',
                'url' => 'https://instagram.com/example',
                'icon' => 'heroicon-o-camera',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'label' => 'YouTube',
                'url' => 'https://youtube.com/@example',
                'icon' => 'heroicon-o-play',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'label' => 'Contact Me',
                'url' => 'mailto:hello@example.com',
                'icon' => 'heroicon-o-envelope',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($links as $linkData) {
            $link = Link::query()->create([
                'landing_page_id' => $landingPage->id,
                ...$linkData,
            ]);

            for ($i = 0; $i < random_int(5, 20); $i++) {
                Click::query()->create([
                    'link_id' => $link->id,
                    'clicked_at' => now()->subMinutes(random_int(1, 5000)),
                    'ip_address' => fake()->ipv4(),
                    'user_agent' => fake()->userAgent(),
                    'referrer' => fake()->optional()->url(),
                ]);
            }
        }
    }
}
