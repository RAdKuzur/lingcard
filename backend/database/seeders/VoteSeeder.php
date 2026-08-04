<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('votes')->truncate();
        DB::table('vote_options')->truncate();
        DB::table('voices')->truncate();

        $vote = [
            'title' => json_encode([
                'en' => 'Select a new language to add!',
                'ru' => 'Выберите новый язык для добавления!',
                'kz' => 'Қосу үшін жаңа тілді таңдаңыз!',
                'fr' => 'Sélectionnez une nouvelle langue à ajouter !',
                'cn' => '选择要添加的新语言！',
                'de' => 'Wählen Sie eine neue Sprache zum Hinzufügen!',
                'es' => '¡Selecciona un nuevo idioma para agregar!',
                'jp' => '追加する新しい言語を選択してください！',
                'kr' => '추가할 새 언어를 선택하세요!',
                'pt' => 'Selecione um novo idioma para adicionar!',
                'sa' => 'اختر لغة جديدة لإضافتها!'
            ]),
            'content' => json_encode([
                'en' => 'This is the first vote on LingCard! Your opinion is extremely important to us, because it is you who shape the future of our project. We invite you to choose the next language to be added for learning.',
                'ru' => 'Это первое голосование на LingCard! Ваше мнение крайне важно для нас, потому что именно вы формируете будущее нашего проекта. Мы приглашаем вас выбрать следующий язык для изучения.',
                'kz' => 'Бұл LingCard-тағы алғашқы дауыс беру! Сіздің пікіріңіз біз үшін өте маңызды, өйткені дәл сіз біздің жобамыздың болашағын қалыптастырасыз. Сізді оқу үшін келесі тілді таңдауға шақырамыз.',
                'fr' => 'C\'est le premier vote sur LingCard ! Votre avis est extrêmement important pour nous, car c\'est vous qui façonnez l\'avenir de notre projet. Nous vous invitons à choisir la prochaine langue à ajouter pour l\'apprentissage.',
                'cn' => '这是LingCard上的第一次投票！您的意见对我们极为重要，因为正是您塑造了我们项目的未来。我们邀请您选择下一个要添加学习的语言。',
                'de' => 'Dies ist die erste Abstimmung auf LingCard! Ihre Meinung ist uns äußerst wichtig, denn Sie sind es, die die Zukunft unseres Projekts gestalten. Wir laden Sie ein, die nächste Sprache zum Lernen auszuwählen.',
                'es' => '¡Esta es la primera votación en LingCard! Tu opinión es extremadamente importante para nosotros, porque eres tú quien da forma al futuro de nuestro proyecto. Te invitamos a elegir el próximo idioma para aprender.',
                'jp' => 'これはLingCardでの最初の投票です！あなたのご意見は私たちにとって非常に重要です。なぜなら、あなたが私たちのプロジェクトの未来を形作るからです。学習用に追加する次の言語を選択してください。',
                'kr' => '이것은 LingCard의 첫 번째 투표입니다! 귀하의 의견은 우리에게 매우 중요합니다. 귀하가 우리 프로젝트의 미래를 만들기 때문입니다. 학습에 추가할 다음 언어를 선택해 주세요.',
                'pt' => 'Esta é a primeira votação no LingCard! Sua opinião é extremamente importante para nós, porque é você quem molda o futuro do nosso projeto. Convidamos você a escolher o próximo idioma a ser adicionado para aprendizado.',
                'sa' => 'هذا هو التصويت الأول على LingCard! رأيك مهم جداً بالنسبة لنا، لأنك أنت من تشكل مستقبل مشروعنا. ندعوك لاختيار اللغة التالية لإضافتها للتعلم.'
            ]),
            'is_active' => true
        ];

        $voteId = DB::table('votes')->insertGetId($vote);
        $languages = DB::table('languages')->where(['is_active' => false])->get();
        foreach ($languages as $language) {
            $content = json_encode([
                'picture' => "/flags/$language->code.svg",
                'code' => $language->code
            ]);
            DB::table('vote_options')->insert([
                'vote_id' => $voteId,
                'title' => $language->name,
                'content' => $content
            ]);
        }
    }
}
