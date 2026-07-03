<?php

namespace Database\Seeders;

use App\Models\Jurnal;
use App\Models\User;

class JurnalSeeder extends UserScopedSeeder
{
    /**
     * @return list<array<string, mixed>>
     */
    private function articles(): array
    {
        return [
            [
                'title' => 'The Alchemy of Chiaroscuro',
                'slug' => 'the-alchemy-of-chiaroscuro',
                'category_id' => 'craft-technique',
                'description' => 'Exploring the dramatic rebirth of chiaroscuro in modern digital portraiture and how shadow shapes narrative.',
                'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&q=80&w=1200',
                'content' => <<<'HTML'
<p>Photography is, at its most fundamental level, the management of photons. But in portraiture, it becomes the management of emotion — and nothing sculpts emotion quite like chiaroscuro.</p>
<h2>Understanding the Ratio</h2>
<p>The relationship between key and fill determines whether your subject feels vulnerable, powerful, or distant. We typically start with a 4:1 ratio for editorial portraiture, pushing to 8:1 when the story demands drama.</p>
<h2>Practical Setup</h2>
<p>A single Profoto B10X with a deep octa, flagged on the fill side, remains our most reliable recipe. Negative fill with black V-flats often does more work than adding another light.</p>
<p>The goal is never darkness for its own sake — it is revelation through contrast.</p>
HTML,
            ],
            [
                'title' => 'Building a Modular Location Kit',
                'slug' => 'building-a-modular-location-kit',
                'category_id' => 'hardware-gear',
                'description' => 'What we pack for unpredictable outdoor shoots — from batteries to backup bodies, organized for speed.',
                'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&q=80&w=1200',
                'content' => <<<'HTML'
<p>Location work punishes inefficiency. After years of overpacking and underpacking, we settled on a modular kit that scales from solo editorial to full commercial crew.</p>
<h2>Core Camera Stack</h2>
<p>Two matched bodies, three lenses (35mm, 50mm, 85mm), and one specialty lens chosen per assignment. Everything else is negotiable.</p>
<h2>Power & Lighting</h2>
<p>Four V-mount batteries per strobe head, dual chargers, and a compact inverter for hotel-room tethering. We never assume reliable power on location.</p>
<p>The best kit is the one you can carry without slowing down your instincts.</p>
HTML,
            ],
            [
                'title' => 'Warm Shadows in Digital Photography',
                'slug' => 'warm-shadows-in-digital-photography',
                'category_id' => 'theory-color',
                'description' => 'Why lifting shadows with blue tones feels clinical — and how to keep shadow regions emotionally warm.',
                'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&q=80&w=1200',
                'content' => <<<'HTML'
<p>Digital sensors render shadow noise with a cool bias. Left uncorrected, skin in shadow reads lifeless — the "digital look" clients describe without knowing the vocabulary.</p>
<h2>Split Toning Approach</h2>
<p>We push warmth into shadow hues while keeping highlights neutral or slightly cool. The separation creates depth without vintage gimmickry.</p>
<h2>Skin Tone Integrity</h2>
<p>Protecting the hue angle of skin across exposure zones matters more than perfect luminance. A half-stop of noise in warm shadows beats clean, gray flesh.</p>
HTML,
            ],
            [
                'title' => 'Shooting Through the Monsoon',
                'slug' => 'shooting-through-the-monsoon',
                'category_id' => 'lifestyle-travel',
                'description' => 'Field notes from a fashion editorial shot across Yogyakarta during peak rainy season.',
                'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&q=80&w=1200',
                'content' => <<<'HTML'
<p>Rain is not downtime — it is atmosphere. The challenge is protecting gear while keeping the crew mobile enough to chase shifting light between squalls.</p>
<h2>Gear Protection</h2>
<p>Clear rain sleeves for cameras, microfiber rotation for lenses, and a pop-up tent for lens changes. Simplicity beats elaborate rigs in tropical humidity.</p>
<h2>Embracing the Weather</h2>
<p>Wet pavement, diffused skylight, and spontaneous reflections gave us frames we could never have planned in dry conditions. Flexibility was the creative asset.</p>
HTML,
            ],
            [
                'title' => '48 Hours Before a Campaign Launch',
                'slug' => '48-hours-before-campaign-launch',
                'category_id' => 'behind-the-scenes',
                'description' => 'A timeline of the final two days before a major commercial campaign goes live — from retouch to client approval.',
                'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1492684223066-81342ee85ff4?auto=format&fit=crop&q=80&w=1200',
                'content' => <<<'HTML'
<p>Launch week is choreography. Every hour is accounted for, yet something always shifts — a crop change, a legal note on a label, a last-minute talent replacement.</p>
<h2>Day -2: Selects Lock</h2>
<p>Creative and client align on hero frames. No new edits enter the pipeline after this point unless flagged as critical.</p>
<h2>Day -1: Delivery & QA</h2>
<p>Export matrices for every channel — OOH, social, e-commerce. Color proof on calibrated displays, then physical print tests for billboards.</p>
<p>The invisible work is what makes the visible work feel effortless.</p>
HTML,
            ],
            [
                'title' => 'Frequency Separation Without the Plastic Look',
                'slug' => 'frequency-separation-without-plastic',
                'category_id' => 'post-production',
                'description' => 'A restrained retouching workflow that preserves pore texture while cleaning distractions.',
                'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1542038784456-1ea8e935640e?auto=format&fit=crop&q=80&w=1200',
                'content' => <<<'HTML'
<p>Frequency separation is a tool, not a style. Used aggressively, it turns skin into silicone. Used with restraint, it solves problems local healing cannot touch.</p>
<h2>Our Layer Discipline</h2>
<p>We work on a single low-frequency layer for tone transitions and keep high-frequency passes under five minutes per frame. Timer visible. Ego invisible.</p>
<h2>Quality Check</h2>
<p>Zoom to 100%, then zoom out to 25%. If the retouch reads at 25%, it is too much. The print test is the final judge.</p>
HTML,
            ],
            [
                'title' => 'Why We Shoot Tethered on Every Commercial Set',
                'slug' => 'why-we-shoot-tethered',
                'category_id' => 'studio-notes',
                'description' => 'Tethering slows the shutter slightly but accelerates decision-making — here is how we justify it to every client.',
                'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1452587925148-ce544e77e70d?auto=format&fit=crop&q=80&w=1200',
                'content' => <<<'HTML'
<p>Untethered shooting feels faster until you are reviewing 3,000 frames at midnight. Tethering front-loads decisions when stakeholders are present and accountable.</p>
<h2>Workflow Integration</h2>
<p>Capture One sessions sync to a calibrated client monitor. Art director flags selects in real time. Stylist adjusts wardrobe between bursts, not after wrap.</p>
<h2>Cable Management</h2>
<p>Overhead runs, sandbagged junctions, and dedicated "cable person" on large sets. A tripped cable costs more than a wireless transmitter ever saved.</p>
HTML,
            ],
            [
                'title' => 'When a Brand Trusts the Process',
                'slug' => 'when-a-brand-trusts-the-process',
                'category_id' => 'client-stories',
                'description' => 'How a long-term client relationship let us push creative risk on a fragrance campaign — and why it paid off.',
                'status' => 'published',
                'thumbnail' => 'https://images.unsplash.com/photo-1523293182086-7651a899d37f?auto=format&fit=crop&q=80&w=1200',
                'content' => <<<'HTML'
<p>The brief said "safe." The relationship said "honest." We presented two directions — one literal, one interpretive — and the client chose the risk.</p>
<h2>Building Trust</h2>
<p>Three prior campaigns delivered on time and on message. Trust is cumulative; you cannot request it on the first job.</p>
<h2>The Result</h2>
<p>Engagement doubled against their benchmark. The hero frame was the one we almost did not show — too dark, too quiet, too true to the product story.</p>
HTML,
            ],
            [
                'title' => 'Draft: The Future of Medium Format Mirrorless',
                'slug' => 'future-of-medium-format-mirrorless',
                'category_id' => 'hardware-gear',
                'description' => 'Early notes on sensor trends and what medium format means when full-frame resolution keeps climbing.',
                'status' => 'draft',
                'thumbnail' => 'https://images.unsplash.com/photo-1519186601-0eccfac7a380?auto=format&fit=crop&q=80&w=1200',
                'content' => <<<'HTML'
<p>This article is still in progress. We are testing three medium format bodies against our commercial benchmarks before publishing conclusions.</p>
<p>Check back soon for full resolution comparisons, dynamic range charts, and workflow notes from a month-long field test.</p>
HTML,
            ],
            [
                'title' => 'Archived: 2023 Year in Review',
                'slug' => '2023-year-in-review',
                'category_id' => 'studio-notes',
                'description' => 'A retrospective of studio milestones, team growth, and selected frames from 2023.',
                'status' => 'archived',
                'thumbnail' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&q=80&w=1200',
                'content' => <<<'HTML'
<p>Archived for internal reference. This year-in-review was published in January 2024 and superseded by our 2024 retrospective.</p>
<p>Kept here as a historical snapshot of studio output and team expansion during a pivotal growth year.</p>
HTML,
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
        foreach ($this->articles() as $article) {
            Jurnal::query()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'slug' => $article['slug'].'-u'.$user->id,
                ],
                [
                    'title' => $article['title'],
                    'category_id' => $article['category_id'],
                    'description' => $article['description'],
                    'content' => $article['content'],
                    'thumbnail' => $article['thumbnail'],
                    'status' => $article['status'],
                ]
            );
        }
    }
}
