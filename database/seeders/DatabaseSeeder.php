<?php

namespace Database\Seeders;

use App\Models\ProgrammeCategory;
use App\Models\ProgrammeCycle;
use App\Models\ProgrammeTrack;
use App\Models\Application;
use App\Models\Lga;
use App\Models\State;
use App\Models\TrainingHub;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@nwdc.test'],
            [
                'name' => 'NWDC Portal Admin',
                'phone' => '08000000000',
                'password' => 'password',
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $states = collect([
            ['name' => 'Jigawa', 'code' => 'JIG'],
            ['name' => 'Kaduna', 'code' => 'KAD'],
            ['name' => 'Kano', 'code' => 'KAN'],
            ['name' => 'Katsina', 'code' => 'KAT'],
            ['name' => 'Kebbi', 'code' => 'KEB'],
            ['name' => 'Sokoto', 'code' => 'SOK'],
            ['name' => 'Zamfara', 'code' => 'ZAM'],
        ])->mapWithKeys(fn (array $state): array => [
            $state['name'] => State::query()->updateOrCreate(
                ['code' => $state['code']],
                ['name' => $state['name'], 'is_north_west' => true]
            ),
        ]);

        $lgas = [
            'Jigawa' => ['Auyo', 'Babura', 'Biriniwa', 'Birnin Kudu', 'Buji', 'Dutse', 'Gagarawa', 'Garki', 'Gumel', 'Guri', 'Gwaram', 'Gwiwa', 'Hadejia', 'Jahun', 'Kafin Hausa', 'Kaugama', 'Kazaure', 'Kiri Kasama', 'Kiyawa', 'Maigatari', 'Malam Madori', 'Miga', 'Ringim', 'Roni', 'Sule Tankarkar', 'Taura', 'Yankwashi'],
            'Kaduna' => ['Birnin Gwari', 'Chikun', 'Giwa', 'Igabi', 'Ikara', 'Jaba', "Jema'a", 'Kachia', 'Kaduna North', 'Kaduna South', 'Kagarko', 'Kajuru', 'Kaura', 'Kauru', 'Kubau', 'Kudan', 'Lere', 'Makarfi', 'Sabon Gari', 'Sanga', 'Soba', 'Zangon Kataf', 'Zaria'],
            'Kano' => ['Ajingi', 'Albasu', 'Bagwai', 'Bebeji', 'Bichi', 'Bunkure', 'Dala', 'Dambatta', 'Dawakin Kudu', 'Dawakin Tofa', 'Doguwa', 'Fagge', 'Gabasawa', 'Garko', 'Garun Mallam', 'Gaya', 'Gezawa', 'Gwale', 'Gwarzo', 'Kabo', 'Kano Municipal', 'Karaye', 'Kibiya', 'Kiru', 'Kumbotso', 'Kunchi', 'Kura', 'Madobi', 'Makoda', 'Minjibir', 'Nassarawa', 'Rano', 'Rimin Gado', 'Rogo', 'Shanono', 'Sumaila', 'Takai', 'Tarauni', 'Tofa', 'Tsanyawa', 'Tudun Wada', 'Ungogo', 'Warawa', 'Wudil'],
            'Katsina' => ['Bakori', 'Batagarawa', 'Batsari', 'Baure', 'Bindawa', 'Charanchi', 'Dan Musa', 'Dandume', 'Danja', 'Daura', 'Dutsi', 'Dutsin-Ma', 'Faskari', 'Funtua', 'Ingawa', 'Jibia', 'Kafur', 'Kaita', 'Kankara', 'Kankia', 'Katsina', 'Kurfi', 'Kusada', "Mai'Adua", 'Malumfashi', 'Mani', 'Mashi', 'Matazu', 'Musawa', 'Rimi', 'Sabuwa', 'Safana', 'Sandamu', 'Zango'],
            'Kebbi' => ['Aleiro', 'Arewa Dandi', 'Argungu', 'Augie', 'Bagudo', 'Birnin Kebbi', 'Bunza', 'Dandi', 'Fakai', 'Gwandu', 'Jega', 'Kalgo', 'Koko/Besse', 'Maiyama', 'Ngaski', 'Sakaba', 'Shanga', 'Suru', 'Wasagu/Danko', 'Yauri', 'Zuru'],
            'Sokoto' => ['Binji', 'Bodinga', 'Dange Shuni', 'Gada', 'Goronyo', 'Gudu', 'Gwadabawa', 'Illela', 'Isa', 'Kebbe', 'Kware', 'Rabah', 'Sabon Birni', 'Shagari', 'Silame', 'Sokoto North', 'Sokoto South', 'Tambuwal', 'Tangaza', 'Tureta', 'Wamakko', 'Wurno', 'Yabo'],
            'Zamfara' => ['Anka', 'Bakura', 'Birnin Magaji/Kiyaw', 'Bukkuyum', 'Bungudu', 'Gummi', 'Gusau', 'Kaura Namoda', 'Maradun', 'Maru', 'Shinkafi', 'Talata Mafara', 'Tsafe', 'Zurmi'],
        ];

        foreach ($lgas as $stateName => $names) {
            Lga::query()
                ->where('state_id', $states[$stateName]->id)
                ->whereNotIn('name', $names)
                ->whereNotIn('id', Application::query()->select('lga_of_origin_id'))
                ->delete();

            foreach ($names as $name) {
                Lga::query()->updateOrCreate(
                    ['state_id' => $states[$stateName]->id, 'name' => $name],
                    []
                );
            }
        }

        $cycle = ProgrammeCycle::query()->updateOrCreate(
            ['slug' => 'youth-skills-2026'],
            [
                'name' => 'NWDC Youth Skills and Empowerment Programme 2026',
                'year' => '2026',
                'application_opens_on' => now()->toDateString(),
                'application_closes_on' => now()->addWeeks(6)->toDateString(),
                'minimum_age' => 18,
                'maximum_age' => 35,
                'status' => 'active',
                'total_capacity' => 4500,
                'summary' => 'TVET and digital skills training for eligible youth across the North-West.',
                'description' => 'A repeatable NWDC intervention portal for eligibility, applications, screening, admissions, onboarding, and cohort assignment.',
            ]
        );

        $categories = collect([
            'TVET' => 'Technical and vocational training for practical trade skills.',
            'Digital Skills' => 'Technology, creative, and digital economy tracks.',
        ])->mapWithKeys(fn (string $description, string $name): array => [
            $name => ProgrammeCategory::query()->updateOrCreate(
                ['programme_cycle_id' => $cycle->id, 'slug' => Str::slug($name)],
                ['name' => $name, 'description' => $description, 'is_active' => true]
            ),
        ]);

        $tracks = [
            'TVET' => [
                'Solar Installation and Maintenance',
                'Electrical Installation',
                'Plumbing and Pipe Fitting',
                'Welding and Fabrication',
                'Tailoring and Fashion Design',
                'Automobile Mechanics',
                'Phone Repair',
                'Catering and Culinary Skills',
                'Agricultural Processing',
                'Poultry and Fishery Enterprise',
                'Carpentry and Furniture Making',
                'Masonry and Tiling',
                'Refrigeration and Air Conditioning',
                'Leatherwork and Shoemaking',
                'Beauty and Cosmetology',
            ],
            'Digital Skills' => [
                'Digital Literacy',
                'Frontend Web Development',
                'Backend Web Development',
                'UI/UX Design',
                'Data Analysis',
                'Cybersecurity Fundamentals',
                'Digital Marketing',
                'Graphics Design',
                'Video Editing and Content Creation',
                'AI Tools for Productivity',
                'Mobile App Development',
                'Cloud Computing Fundamentals',
            ],
        ];

        $createdTracks = collect();

        foreach ($tracks as $categoryName => $trackNames) {
            foreach ($trackNames as $trackName) {
                $createdTracks->push(ProgrammeTrack::query()->updateOrCreate(
                    [
                        'programme_category_id' => $categories[$categoryName]->id,
                        'slug' => Str::slug($trackName),
                    ],
                    [
                        'name' => $trackName,
                        'capacity' => 225,
                        'description' => $trackName . ' training pathway.',
                        'is_active' => true,
                    ]
                ));
            }
        }

        $hubs = collect([
            [
                'name' => 'NWDC Kano Skills Hub',
                'city' => 'Kano',
                'state' => 'Kano',
                'capacity' => 750,
                'address' => 'Kano training hub address to be confirmed.',
            ],
            [
                'name' => 'NWDC Kaduna Skills Hub',
                'city' => 'Kaduna',
                'state' => 'Kaduna',
                'capacity' => 750,
                'address' => 'Kaduna training hub address to be confirmed.',
            ],
            [
                'name' => 'NWDC Sokoto Skills Hub',
                'city' => 'Sokoto',
                'state' => 'Sokoto',
                'capacity' => 750,
                'address' => 'Sokoto training hub address to be confirmed.',
            ],
            [
                'name' => 'NWDC Jigawa Skills Hub',
                'city' => 'Dutse',
                'state' => 'Jigawa',
                'capacity' => 750,
                'address' => 'Jigawa training hub address to be confirmed.',
            ],
            [
                'name' => 'NWDC Katsina Skills Hub',
                'city' => 'Katsina',
                'state' => 'Katsina',
                'capacity' => 750,
                'address' => 'Katsina training hub address to be confirmed.',
            ],
            [
                'name' => 'NWDC Kebbi Skills Hub',
                'city' => 'Birnin Kebbi',
                'state' => 'Kebbi',
                'capacity' => 750,
                'address' => 'Kebbi training hub address to be confirmed.',
            ],
            [
                'name' => 'NWDC Zamfara Skills Hub',
                'city' => 'Gusau',
                'state' => 'Zamfara',
                'capacity' => 750,
                'address' => 'Zamfara training hub address to be confirmed.',
            ],
        ])->map(function (array $hub) use ($states): TrainingHub {
            return TrainingHub::query()->updateOrCreate(
                ['name' => $hub['name']],
                [
                    'city' => $hub['city'],
                    'state_id' => $states[$hub['state']]->id,
                    'capacity' => $hub['capacity'],
                    'address' => $hub['address'],
                    'is_active' => true,
                ]
            );
        });

        $createdTracks->each(function (ProgrammeTrack $track) use ($hubs): void {
            $hubs->each(fn (TrainingHub $hub) => $track->trainingHubs()->syncWithoutDetaching([
                $hub->id => ['capacity' => 75],
            ]));
        });
    }
}
