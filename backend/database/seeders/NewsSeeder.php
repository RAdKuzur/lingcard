<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news')->truncate();

        DB::table('news')->insert([
            'content' => 'С этого момента наш проект LingCard можно считать запущенным и готовым к экспуатации!',
            'date' => now(),
            'title' => 'LingCard запущено!',
            'language_id' => DB::table('languages')->where(['code' => 'ru'])->first()->id,
        ]);
        DB::table('news')->insert([
            'content' => 'Мы добавили русский и казахский языки для обучения!',
            'date' => now()->addSecond(),
            'title' => 'Русский и Қазақша',
            'language_id' => DB::table('languages')->where(['code' => 'ru'])->first()->id,
        ]);

        DB::table('news')->insert([
            'content' => 'Осы сәттен бастап біздің LingCard жобасын іске қосылды және пайдалануға дайын деп санауға болады!',
            'date' => now(),
            'title' => 'LingCard іске қосылды!',
            'language_id' => DB::table('languages')->where(['code' => 'kz'])->first()->id,
        ]);
        DB::table('news')->insert([
            'content' => 'Біз оқытуға арналған орыс және қазақ тілдерін қостық!',
            'date' => now()->addSecond(),
            'title' => 'Русский и Қазақша',
            'language_id' => DB::table('languages')->where(['code' => 'kz'])->first()->id,
        ]);

        DB::table('news')->insert([
            'content' => 'From this moment, our LingCard project can be considered launched and ready for use!',
            'date' => now(),
            'title' => 'LingCard is launched!',
            'language_id' => DB::table('languages')->where(['code' => 'en'])->first()->id,
        ]);
        DB::table('news')->insert([
            'content' => 'We have added Russian and Kazakh languages for learning!',
            'date' => now()->addSecond(),
            'title' => 'Russian and Kazakh',
            'language_id' => DB::table('languages')->where(['code' => 'en'])->first()->id,
        ]);

        DB::table('news')->insert([
            'content' => 'Были добавлен английский язык для изучения (более 5000 слов)',
            'date' => now()->addSeconds(2),
            'title' => 'Английский язык!',
            'language_id' => DB::table('languages')->where(['code' => 'ru'])->first()->id,
        ]);
        DB::table('news')->insert([
            'content' => 'Ағылшын тілі оқу үшін қосылды (5000-нан астам сөз)',
            'date' => now()->addSeconds(2),
            'title' => 'Ағылшын тілі!',
            'language_id' => DB::table('languages')->where(['code' => 'kz'])->first()->id,
        ]);
        DB::table('news')->insert([
            'content' => 'English language has been added for learning (more than 5000 words)',
            'date' => now()->addSeconds(2),
            'title' => 'English language!',
            'language_id' => DB::table('languages')->where(['code' => 'en'])->first()->id,
        ]);
    }
}
