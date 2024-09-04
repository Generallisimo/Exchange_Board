<?php

namespace Database\Seeders;

use App\Components\checkBalance\CheckBalanceAgent;
use App\Components\checkBalance\CheckBalancePlatform;
use App\Components\CheckBalanceUsers;
use App\Models\Agent;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        $platform = Platform::create([
            'hash_id'=>$user->hash_id,
            'balance'=>'0',
            'details_from'=>'TLwBnPPSnqyze6Z5PFupUHMdpcknRghKrc',
            'private_key'=>'6285daf813fe3497148a2420cf9f30adcae49f4a38ec03db89b0a37d4b5d223e',
            'details_to'=>'TMC46QhDNpBFtq1o8iLtcNeBniHYt5X1xU'
        ]);

        $agent = Agent::create([
            'hash_id'=>$user->hash_id,
            'balance'=>'0',
            'details_from'=>'TLwBnPPSnqyze6Z5PFupUHMdpcknRghKrc',
            'private_key'=>'6285daf813fe3497148a2420cf9f30adcae49f4a38ec03db89b0a37d4b5d223e',
            'details_to'=>'TMC46QhDNpBFtq1o8iLtcNeBniHYt5X1xU',
            'percent'=>'0'
        ]);

        new CheckBalancePlatform($platform);
        new CheckBalanceAgent($agent);                

    }
}
