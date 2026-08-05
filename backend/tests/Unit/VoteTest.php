<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\VoteOption;
use App\Repositories\VoiceRepository;
use App\Repositories\VoteOptionRepository;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\TestUserSeeder;
use Database\Seeders\TestWordSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\VoteSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VoteTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    use RefreshDatabase;
    public function test_vote(): void
    {
        $this->seed(LanguageSeeder::class);
        $this->seed(TestUserSeeder::class);
        $this->seed(VoteSeeder::class);

        $user = User::where(['email' => 'drive16052003@gmail.com'])->first();
        $voteOptionId = VoteOption::first()->id;
        $vote = (new VoteOptionRepository())->find($voteOptionId);
        $voteOptions = (new VoteOptionRepository())->findByVoteId($vote->vote_id);
        (new VoiceRepository())->deleteUserVoices($user->id, array_column($voteOptions->toArray(), 'id'));
        (new VoiceRepository())->insert([
            'vote_option_id' => $voteOptionId,
            'user_id' => $user->id,
            'time' => now()
        ]);
        $countVoices = (new VoiceRepository())->countVoices($voteOptionId);
        $this->assertEquals($countVoices, 1);
    }

    public function test_vote_cancel(): void
    {
        $this->seed(LanguageSeeder::class);
        $this->seed(TestUserSeeder::class);
        $this->seed(VoteSeeder::class);

        $user = User::where(['email' => 'drive16052003@gmail.com'])->first();
        $voteOptionId = VoteOption::first()->id;
        $vote = (new VoteOptionRepository())->find($voteOptionId);
        $voteOptions = (new VoteOptionRepository())->findByVoteId($vote->vote_id);
        (new VoiceRepository())->deleteUserVoices($user->id, array_column($voteOptions->toArray(), 'id'));
        (new VoiceRepository())->insert([
            'vote_option_id' => $voteOptionId,
            'user_id' => $user->id,
            'time' => now()
        ]);
        (new VoiceRepository())->deleteVoice($user->id, $voteOptionId);
        $countVoices = (new VoiceRepository())->countVoices($voteOptionId);
        $this->assertEquals($countVoices, 0);
    }
}
