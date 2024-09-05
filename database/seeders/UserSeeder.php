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

        $details_from = config('wallet.wallet');
        $private_key = config('wallet.private_key');

        $platform = Platform::create([
            'hash_id'=>$user->hash_id,
            'balance'=>'0',
            'details_from'=>$details_from,
            'private_key'=>$private_key,
            'details_to'=>'TMC46QhDNpBFtq1o8iLtcNeBniHYt5X1xU'
        ]);

        $agent = Agent::create([
            'hash_id'=>$user->hash_id,
            'balance'=>'0',
            'details_from'=>$details_from,
            'private_key'=>$private_key,
            'details_to'=>'TMC46QhDNpBFtq1o8iLtcNeBniHYt5X1xU',
            'percent'=>'0'
        ]);

        new CheckBalancePlatform($platform);
        new CheckBalanceAgent($agent);                

    }
}
