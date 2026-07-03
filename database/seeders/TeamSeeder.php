<?php

namespace Database\Seeders;

use App\Models\Team;

class TeamSeeder extends UserScopedSeeder
{
    /**
     * @return list<array{name: string, job: string, biography: string, social_media: list<array{type: string, label: string, link: string}>}>
     */
    private function members(): array
    {
        return [
            [
                'name' => 'Evan Wijaya',
                'job' => 'Lead Photographer',
                'biography' => 'Specializes in high-contrast editorial portraiture with a cinematic eye. Evan has shot campaigns for regional fashion houses and personal documentary series across Southeast Asia.',
                'social_media' => [
                    ['type' => 'instagram', 'label' => '@evanw.studio', 'link' => 'https://instagram.com/evanw.studio'],
                    ['type' => 'linkedin', 'label' => 'Evan Wijaya', 'link' => 'https://linkedin.com/in/evanwijaya'],
                ],
            ],
            [
                'name' => 'Marco Rossi',
                'job' => 'Senior Stylist',
                'biography' => 'Former Milan fashion week stylist now based in Jakarta. Marco builds wardrobe narratives that bridge European tailoring with tropical textures and bold color stories.',
                'social_media' => [
                    ['type' => 'instagram', 'label' => '@marcorossi.style', 'link' => 'https://instagram.com/marcorossi.style'],
                    ['type' => 'tiktok', 'label' => '@marcorossi', 'link' => 'https://tiktok.com/@marcorossi'],
                ],
            ],
            [
                'name' => 'Aisha Karim',
                'job' => 'Creative Director',
                'biography' => 'Shapes the visual identity of every shoot from concept to final delivery. Aisha leads moodboarding, art direction, and client presentations for commercial and editorial projects.',
                'social_media' => [
                    ['type' => 'instagram', 'label' => '@aisha.karim', 'link' => 'https://instagram.com/aisha.karim'],
                    ['type' => 'linkedin', 'label' => 'Aisha Karim', 'link' => 'https://linkedin.com/in/aishakarim'],
                ],
            ],
            [
                'name' => 'Daniel Pratama',
                'job' => 'Lighting Technician',
                'biography' => 'Proficient in studio strobes, continuous LED arrays, and on-location grip work. Daniel designs lighting setups that sculpt subjects without overpowering natural atmosphere.',
                'social_media' => [
                    ['type' => 'instagram', 'label' => '@daniel.lights', 'link' => 'https://instagram.com/daniel.lights'],
                ],
            ],
            [
                'name' => 'Sofia Laurent',
                'job' => 'Makeup Artist',
                'biography' => 'Trained in Paris and known for skin-first beauty looks. Sofia works across bridal, editorial, and commercial sets with a focus on luminous, camera-ready finishes.',
                'social_media' => [
                    ['type' => 'instagram', 'label' => '@sofia.beauty', 'link' => 'https://instagram.com/sofia.beauty'],
                    ['type' => 'facebook', 'label' => 'Sofia Laurent MUA', 'link' => 'https://facebook.com/sofialaurentmua'],
                ],
            ],
            [
                'name' => 'Rizky Hidayat',
                'job' => 'Retoucher',
                'biography' => 'Handles RAW development, color grading, and high-end skin retouching. Rizky maintains a consistent house look while preserving texture and authenticity in every frame.',
                'social_media' => [
                    ['type' => 'instagram', 'label' => '@rizky.retouch', 'link' => 'https://instagram.com/rizky.retouch'],
                    ['type' => 'linkedin', 'label' => 'Rizky Hidayat', 'link' => 'https://linkedin.com/in/rizkyhidayat'],
                ],
            ],
            [
                'name' => 'Nina Okonkwo',
                'job' => 'Producer',
                'biography' => 'Coordinates casting, locations, permits, and day-of logistics. Nina keeps productions on schedule and ensures every department has what it needs before the first light.',
                'social_media' => [
                    ['type' => 'linkedin', 'label' => 'Nina Okonkwo', 'link' => 'https://linkedin.com/in/ninaokonkwo'],
                    ['type' => 'instagram', 'label' => '@nina.produces', 'link' => 'https://instagram.com/nina.produces'],
                ],
            ],
            [
                'name' => 'Kenji Tanaka',
                'job' => 'Second Shooter',
                'biography' => 'Covers B-roll, candid moments, and alternate angles on wedding and event assignments. Kenji is agile on fast-moving sets and excels at capturing unscripted emotion.',
                'social_media' => [
                    ['type' => 'instagram', 'label' => '@kenji.frames', 'link' => 'https://instagram.com/kenji.frames'],
                    ['type' => 'tiktok', 'label' => '@kenjitanaka', 'link' => 'https://tiktok.com/@kenjitanaka'],
                ],
            ],
        ];
    }

    public function run(): void
    {
        foreach ($this->users() as $user) {
            foreach ($this->members() as $member) {
                Team::query()->updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'name' => $member['name'],
                    ],
                    [
                        'job' => $member['job'],
                        'biography' => $member['biography'],
                        'social_media' => $member['social_media'],
                        'number' => 0,
                        'picture' => null,
                    ]
                );
            }
        }
    }
}
