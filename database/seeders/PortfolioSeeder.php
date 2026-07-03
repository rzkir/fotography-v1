<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Str;

class PortfolioSeeder extends UserScopedSeeder
{
    /**
     * @return list<array<string, mixed>>
     */
    private function projects(): array
    {
        return [
            [
                'title' => 'Midnight Soul',
                'subtitle' => 'soul',
                'slug' => 'midnight-soul',
                'client' => 'Personal Editorial',
                'year' => 2024,
                'category_id' => 'fine-art-portrait',
                'location' => 'Jakarta, ID',
                'hero_image' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&q=80&w=1600',
                'hero_caption' => 'Shot 01 · f/1.4 · ISO 200',
                'quote' => 'In the darkness, the truth of the soul reveals itself through shadow and silence.',
                'status' => 'published',
                'is_published' => true,
                'team_names' => ['Evan Wijaya', 'Sofia Laurent', 'Rizky Hidayat'],
                'content_sections' => [
                    ['title' => 'Concept Overview', 'description' => 'A study of chiaroscuro portraiture inspired by Dutch masters, reinterpreted for contemporary editorial.'],
                    ['title' => 'Creative Direction', 'description' => 'Minimal wardrobe, deep blacks, and a single hard key to sculpt facial structure without distraction.'],
                ],
                'gallery_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&q=80&w=1200', 'caption' => 'Shot 02', 'alt' => 'Portrait in shadow'],
                    ['url' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&q=80&w=1200', 'caption' => 'Shot 03', 'alt' => 'Editorial close-up'],
                ],
                'metrics' => [
                    'shots_taken' => '1.2k+',
                    'final_selects' => '18',
                    'total_hours' => '72h',
                    'team_members' => '6',
                ],
                'technical_specs' => [
                    'camera_setup' => 'Leica M11 / Summilux 50mm f/1.4',
                    'camera_settings' => 'ISO 100-400 · 1/125s - 1/250s',
                    'lighting_array' => 'Profoto B10X + 3\' Deep Octa',
                    'lighting_notes' => 'Single source with negative fill for extreme contrast.',
                    'post_processing' => [
                        ['title' => 'Curation & RAW', 'text' => 'Initial selection and RAW development in Capture One.'],
                        ['title' => 'Color Grading', 'text' => 'Custom LUTs with frequency separation for skin texture.'],
                    ],
                    'retouching_notes' => 'Preserved natural skin texture; lifted shadows without crushing blacks.',
                ],
                'timeline' => [
                    ['title' => 'Week 01: Ideation', 'text' => 'Moodboarding, casting, and studio location scouting.'],
                    ['title' => 'Week 02: Production', 'text' => 'Two-day studio shoot with wardrobe and beauty prep.'],
                ],
                'testimonial' => [
                    'quote' => 'The final series exceeded every expectation. Moody, precise, and deeply human.',
                    'author' => 'Editorial Director',
                ],
            ],
            [
                'title' => 'Urban Elegance',
                'subtitle' => 'elegance',
                'slug' => 'urban-elegance',
                'client' => 'Maison Lumière',
                'year' => 2025,
                'category_id' => 'fashion-editorial',
                'location' => 'Bandung, ID',
                'hero_image' => 'https://images.unsplash.com/photo-1469334031218-e382a71b716b?auto=format&fit=crop&q=80&w=1600',
                'hero_caption' => 'Look 04 · f/2.8 · ISO 160',
                'quote' => 'Structure meets movement — tailoring designed for the city after dark.',
                'status' => 'published',
                'is_published' => true,
                'team_names' => ['Marco Rossi', 'Aisha Karim', 'Daniel Pratama'],
                'content_sections' => [
                    ['title' => 'Collection Story', 'description' => 'Autumn-winter campaign highlighting architectural silhouettes against brutalist cityscapes.'],
                    ['title' => 'Styling Notes', 'description' => 'Layered textures in monochrome with a single accent tone per look.'],
                ],
                'gallery_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1492447272811-48135dd4c438?auto=format&fit=crop&q=80&w=1200', 'caption' => 'Look 05', 'alt' => 'Fashion editorial'],
                    ['url' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&q=80&w=1200', 'caption' => 'Look 06', 'alt' => 'Urban fashion'],
                ],
                'metrics' => [
                    'shots_taken' => '2.4k+',
                    'final_selects' => '32',
                    'total_hours' => '96h',
                    'team_members' => '8',
                ],
                'technical_specs' => [
                    'camera_setup' => 'Sony A7R V / 35mm f/1.4 GM',
                    'camera_settings' => 'ISO 200-800 · 1/200s - 1/500s',
                    'lighting_array' => 'Natural overcast + Profoto B1X bounce',
                    'lighting_notes' => 'Mixed ambient and strobe for seamless outdoor editorial.',
                    'post_processing' => [
                        ['title' => 'Selects', 'text' => 'Narrowed to 32 hero frames across 12 looks.'],
                        ['title' => 'Grade', 'text' => 'Cool shadows with warm skin separation.'],
                    ],
                    'retouching_notes' => 'Fabric detail preserved; minimal body contouring.',
                ],
                'timeline' => [
                    ['title' => 'Pre-Production', 'text' => 'Wardrobe fittings and location permits across three districts.'],
                    ['title' => 'Shoot Days', 'text' => 'Four on-location days with rolling wardrobe changes.'],
                ],
                'testimonial' => [
                    'quote' => 'Every frame feels editorial-ready. The campaign performed above benchmark on launch week.',
                    'author' => 'Brand Manager, Maison Lumière',
                ],
            ],
            [
                'title' => 'Ember & Smoke',
                'subtitle' => 'smoke',
                'slug' => 'ember-smoke',
                'client' => 'Nordic Spirits Co.',
                'year' => 2024,
                'category_id' => 'commercial-advertising',
                'location' => 'Surabaya, ID',
                'hero_image' => 'https://images.unsplash.com/photo-1509460913899-515f1df34fed?auto=format&fit=crop&q=80&w=1600',
                'hero_caption' => 'Hero · f/4 · ISO 100',
                'quote' => 'Warmth, ritual, and the slow burn of craft distilled into a single frame.',
                'status' => 'published',
                'is_published' => true,
                'team_names' => ['Evan Wijaya', 'Daniel Pratama', 'Nina Okonkwo'],
                'content_sections' => [
                    ['title' => 'Campaign Brief', 'description' => 'Launch visuals for a small-batch whisky line targeting premium bar culture.'],
                    ['title' => 'Art Direction', 'description' => 'Amber tones, controlled smoke, and tactile glass reflections on dark set dressing.'],
                ],
                'gallery_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1470337458703-46ad1756a187?auto=format&fit=crop&q=80&w=1200', 'caption' => 'Product', 'alt' => 'Whisky pour'],
                    ['url' => 'https://images.unsplash.com/photo-1569529465841-dfecdab0223a?auto=format&fit=crop&q=80&w=1200', 'caption' => 'Detail', 'alt' => 'Glass detail'],
                ],
                'metrics' => [
                    'shots_taken' => '860',
                    'final_selects' => '12',
                    'total_hours' => '48h',
                    'team_members' => '5',
                ],
                'technical_specs' => [
                    'camera_setup' => 'Phase One IQ4 / 80mm Macro',
                    'camera_settings' => 'ISO 50-100 · f/4 - f/8',
                    'lighting_array' => 'Strip boxes + smoke machine + black velvet',
                    'lighting_notes' => 'Backlit liquid with flagged spill for label legibility.',
                    'post_processing' => [
                        ['title' => 'Composite', 'text' => 'Blend pour splashes from multiple captures.'],
                        ['title' => 'Retouch', 'text' => 'Label cleanup and condensation enhancement.'],
                    ],
                    'retouching_notes' => 'Product geometry corrected; liquid kept organic.',
                ],
                'timeline' => [
                    ['title' => 'Set Build', 'text' => 'Custom bar set and prop styling overnight.'],
                    ['title' => 'Capture', 'text' => 'Single intensive studio day with live client review.'],
                ],
                'testimonial' => [
                    'quote' => 'The imagery elevated our entire brand positioning. Sales uplift followed within the quarter.',
                    'author' => 'Marketing Lead, Nordic Spirits Co.',
                ],
            ],
            [
                'title' => 'Sacred Waters',
                'subtitle' => 'waters',
                'slug' => 'sacred-waters',
                'client' => 'Private Commission',
                'year' => 2025,
                'category_id' => 'wedding-events',
                'location' => 'Bali, ID',
                'hero_image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&q=80&w=1600',
                'hero_caption' => 'Ceremony · f/2.0 · ISO 400',
                'quote' => 'Where the ocean meets vows — light, tide, and timeless commitment.',
                'status' => 'published',
                'is_published' => true,
                'team_names' => ['Kenji Tanaka', 'Sofia Laurent', 'Nina Okonkwo'],
                'content_sections' => [
                    ['title' => 'Event Overview', 'description' => 'Intimate cliffside ceremony with golden-hour reception spanning two days.'],
                    ['title' => 'Coverage Approach', 'description' => 'Documentary-first with curated portrait windows between rituals.'],
                ],
                'gallery_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1606216794074-735e91aa2c92?auto=format&fit=crop&q=80&w=1200', 'caption' => 'Vows', 'alt' => 'Wedding ceremony'],
                    ['url' => 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?auto=format&fit=crop&q=80&w=1200', 'caption' => 'Reception', 'alt' => 'Wedding reception'],
                ],
                'metrics' => [
                    'shots_taken' => '3.1k+',
                    'final_selects' => '240',
                    'total_hours' => '36h',
                    'team_members' => '4',
                ],
                'technical_specs' => [
                    'camera_setup' => 'Dual Canon R5 / 24-70mm & 85mm',
                    'camera_settings' => 'ISO 100-3200 · available light priority',
                    'lighting_array' => 'On-camera bounce + LED panels for reception',
                    'lighting_notes' => 'No flash during ceremony; warm practicals for dinner.',
                    'post_processing' => [
                        ['title' => 'Culling', 'text' => 'Same-day selects delivered for social sharing.'],
                        ['title' => 'Album Design', 'text' => '40-spread heirloom album with linen cover.'],
                    ],
                    'retouching_notes' => 'Natural color palette aligned with coastal venue tones.',
                ],
                'timeline' => [
                    ['title' => 'Day 01', 'text' => 'Welcome dinner and rehearsal portraits.'],
                    ['title' => 'Day 02', 'text' => 'Ceremony, family formals, and sunset reception.'],
                ],
                'testimonial' => [
                    'quote' => 'Every meaningful moment was captured without feeling staged. We relive the day every time we open the album.',
                    'author' => 'Bride & Groom',
                ],
            ],
            [
                'title' => 'Silent Horizons',
                'subtitle' => 'horizons',
                'slug' => 'silent-horizons',
                'client' => 'National Geographic Indonesia',
                'year' => 2023,
                'category_id' => 'documentary',
                'location' => 'Flores, ID',
                'hero_image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&q=80&w=1600',
                'hero_caption' => 'Field · f/5.6 · ISO 400',
                'quote' => 'The land speaks in silence — we only had to listen and frame it.',
                'status' => 'draft',
                'is_published' => false,
                'team_names' => ['Evan Wijaya', 'Nina Okonkwo'],
                'content_sections' => [
                    ['title' => 'Assignment', 'description' => 'Three-week field documentary on coastal communities adapting to changing tides.'],
                    ['title' => 'Ethics', 'description' => 'Collaborative storytelling with community review before publication.'],
                ],
                'gallery_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&q=80&w=1200', 'caption' => 'Coast', 'alt' => 'Coastal landscape'],
                    ['url' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?auto=format&fit=crop&q=80&w=1200', 'caption' => 'Forest', 'alt' => 'Forest path'],
                ],
                'metrics' => [
                    'shots_taken' => '5.6k+',
                    'final_selects' => '45',
                    'total_hours' => '240h',
                    'team_members' => '3',
                ],
                'technical_specs' => [
                    'camera_setup' => 'Leica Q3 + backup mirrorless kit',
                    'camera_settings' => 'ISO 200-6400 · documentary auto ISO',
                    'lighting_array' => 'Available light only',
                    'lighting_notes' => 'No artificial lighting in community spaces.',
                    'post_processing' => [
                        ['title' => 'Edit', 'text' => 'Long-form photo essay sequencing.'],
                        ['title' => 'Captioning', 'text' => 'Bilingual captions with community approval.'],
                    ],
                    'retouching_notes' => 'Minimal intervention; journalistic integrity maintained.',
                ],
                'timeline' => [
                    ['title' => 'Week 01-02', 'text' => 'Field immersion and relationship building.'],
                    ['title' => 'Week 03', 'text' => 'Focused portrait and landscape sessions.'],
                ],
                'testimonial' => [
                    'quote' => 'Rare sensitivity to subject and place. The essay draft is our strongest this season.',
                    'author' => 'Photo Editor',
                ],
            ],
            [
                'title' => 'Object in Light',
                'subtitle' => 'light',
                'slug' => 'object-in-light',
                'client' => 'Atelier Forma',
                'year' => 2025,
                'category_id' => 'product-photography',
                'location' => 'Jakarta, ID',
                'hero_image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=1600',
                'hero_caption' => 'Product · f/8 · ISO 64',
                'quote' => 'Form, material, and the geometry of desire rendered in pure light.',
                'status' => 'published',
                'is_published' => true,
                'team_names' => ['Daniel Pratama', 'Rizky Hidayat', 'Aisha Karim'],
                'content_sections' => [
                    ['title' => 'Product Range', 'description' => 'Ceramic homeware collection shot for e-commerce and print catalogue.'],
                    ['title' => 'Set Design', 'description' => 'Modular plinths with gradient backdrops to emphasize material finish.'],
                ],
                'gallery_images' => [
                    ['url' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&q=80&w=1200', 'caption' => 'Flat lay', 'alt' => 'Product flat lay'],
                    ['url' => 'https://images.unsplash.com/photo-1560343090-f0409e52491a?auto=format&fit=crop&q=80&w=1200', 'caption' => 'Detail', 'alt' => 'Product detail'],
                ],
                'metrics' => [
                    'shots_taken' => '640',
                    'final_selects' => '48',
                    'total_hours' => '32h',
                    'team_members' => '4',
                ],
                'technical_specs' => [
                    'camera_setup' => 'Fujifilm GFX 100 II / 110mm f/2',
                    'camera_settings' => 'ISO 64-200 · f/8 - f/11 · focus stacking',
                    'lighting_array' => 'Overhead softbox + side rim panels',
                    'lighting_notes' => 'Polarized highlights to control ceramic glare.',
                    'post_processing' => [
                        ['title' => 'Stacking', 'text' => 'Multi-frame focus merge per SKU angle.'],
                        ['title' => 'Clipping Path', 'text' => 'Clean masks for marketplace variants.'],
                    ],
                    'retouching_notes' => 'Dust removal and subtle surface uniformity only.',
                ],
                'timeline' => [
                    ['title' => 'Prep', 'text' => 'SKU inventory and surface cleaning protocol.'],
                    ['title' => 'Shoot', 'text' => 'Two studio days covering full collection.'],
                ],
                'testimonial' => [
                    'quote' => 'Conversion on our product pages improved immediately. The detail work is immaculate.',
                    'author' => 'Founder, Atelier Forma',
                ],
            ],
        ];
    }

    public function run(): void
    {
        foreach ($this->users() as $user) {
            $this->seedForUser($user);
        }
    }

    private function seedForUser(User $user): void
    {
        $affectedTeamIds = [];

        foreach ($this->projects() as $project) {
            $slug = $project['slug'].'-u'.$user->id;

            $portfolio = Portfolio::query()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'slug' => $slug,
                ],
                [
                    'title' => $project['title'],
                    'subtitle' => $project['subtitle'],
                    'client' => $project['client'],
                    'year' => $project['year'],
                    'category_id' => $project['category_id'],
                    'location' => $project['location'],
                    'hero_image' => $project['hero_image'],
                    'hero_caption' => $project['hero_caption'],
                    'quote' => $project['quote'],
                    'content_sections' => $project['content_sections'],
                    'gallery_images' => $project['gallery_images'],
                    'metrics' => $project['metrics'],
                    'technical_specs' => $project['technical_specs'],
                    'timeline' => $project['timeline'],
                    'contributors' => null,
                    'testimonial' => $project['testimonial'],
                    'status' => $project['status'],
                    'is_published' => $project['is_published'],
                ]
            );

            $teamIds = $this->resolveTeamIds($user, $project['team_names']);
            $portfolio->teams()->sync($teamIds);
            $affectedTeamIds = array_merge($affectedTeamIds, $teamIds);
        }

        if ($affectedTeamIds !== []) {
            Team::recalculateNumbers(array_values(array_unique($affectedTeamIds)));
        }
    }

    /**
     * @param  list<string>  $preferredNames
     * @return list<int>
     */
    private function resolveTeamIds(User $user, array $preferredNames): array
    {
        $teams = $user->teams()->orderBy('name')->get();

        if ($teams->isEmpty()) {
            return [];
        }

        $matched = $teams->filter(function ($team) use ($preferredNames): bool {
            foreach ($preferredNames as $name) {
                if (Str::lower($team->name) === Str::lower($name)) {
                    return true;
                }

                if (Str::contains(Str::lower($team->name), Str::lower(Str::before($name, ' ')))) {
                    return true;
                }
            }

            return false;
        });

        if ($matched->isEmpty()) {
            return $teams->take(min(3, $teams->count()))->pluck('id')->all();
        }

        return $matched->take(3)->pluck('id')->all();
    }
}
