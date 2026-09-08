<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Core\Contexts\Vocabulary\Application\Commands\SaveWordCommand;
use Core\Contexts\Vocabulary\Application\Queries\LookupWordQuery;
use Core\Shared\Application\Bus\CommandBusInterface;
use Core\Shared\Application\Bus\QueryBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DictionaryApiController extends Controller
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly CommandBusInterface $commandBus
    ) {}

    public function lookup(Request $request): JsonResponse
    {
        $word = (string) $request->input('word', '');
        $word = trim(preg_replace('/[.,?!;:\"\'()\-]/', '', $word));

        if (empty($word) || strlen($word) < 2) {
            return response()->json(['success' => false, 'message' => 'Từ tra cứu không hợp lệ.'], 422);
        }

        // 1. Check local database & Redis cache
        $vocab = $this->queryBus->ask(new LookupWordQuery($word));

        if ($vocab) {
            return response()->json([
                'success' => true,
                'word' => $vocab->word,
                'phonetic' => $vocab->phonetic_us ?: $vocab->phonetic_uk ?: '',
                'audio' => $vocab->audio_us ?: $vocab->audio_uk ?: '',
                'part_of_speech' => $vocab->part_of_speech ?: '',
                'definition_vi' => $vocab->definition_vi,
                'definition_en' => $vocab->definition_en ?: '',
                'example' => $vocab->example_sentence ?: '',
                'collocations' => $vocab->collocations ?? [],
            ]);
        }

        // 2. Built-in instant dictionary for high-frequency daily & academic IELTS/TOEIC words
        $commonDict = [
            'hello' => ['def' => 'Xin chào (lời chào hỏi thân thiện hoặc khi bắt đầu cuộc gọi)', 'pos' => 'exclamation/noun', 'ipa' => '/həˈloʊ/', 'ex' => 'Hello, could you tell me where the exam room is?'],
            'hi' => ['def' => 'Xin chào (chào thân mật)', 'pos' => 'exclamation', 'ipa' => '/haɪ/', 'ex' => 'Hi everyone, welcome to the test prep workshop.'],
            'world' => ['def' => 'Thế giới, nhân loại, toàn cầu', 'pos' => 'noun', 'ipa' => '/wɜːrld/', 'ex' => 'Online education has transformed the modern world.'],
            'learning' => ['def' => 'Sự học tập, quá trình tiếp thu kiến thức', 'pos' => 'noun', 'ipa' => '/ˈlɜːr.nɪŋ/', 'ex' => 'Active learning leads to significantly higher retention rates.'],
            'student' => ['def' => 'Học sinh, sinh viên, người nghiên cứu', 'pos' => 'noun', 'ipa' => '/ˈstuː.dənt/', 'ex' => 'Every student must submit their mock test before Friday.'],
            'teacher' => ['def' => 'Giáo viên, giảng viên, người dạy học', 'pos' => 'noun', 'ipa' => '/ˈtiː.tʃər/', 'ex' => 'The teacher provided clear feedback on Task 2 essays.'],
            'language' => ['def' => 'Ngôn ngữ, tiếng nói, hệ thống giao tiếp', 'pos' => 'noun', 'ipa' => '/ˈlæŋ.ɡwɪdʒ/', 'ex' => 'Language acquisition requires consistent daily listening.'],
            'practice' => ['def' => 'Luyện tập, thực hành, rèn luyện kỹ năng', 'pos' => 'noun/verb', 'ipa' => '/ˈpræk.tɪs/', 'ex' => 'Consistent daily practice is the key to IELTS Band 8.0.'],
            'reading' => ['def' => 'Kỹ năng đọc hiểu, bài đọc học thuật', 'pos' => 'noun', 'ipa' => '/ˈriː.dɪŋ/', 'ex' => 'She scored Band 8.5 in the Academic Reading section.'],
            'listening' => ['def' => 'Kỹ năng nghe hiểu, lắng nghe', 'pos' => 'noun', 'ipa' => '/ˈlɪs.ən.ɪŋ/', 'ex' => 'Listening for keywords helps pinpoint the right answers quickly.'],
            'writing' => ['def' => 'Kỹ năng viết luận, văn bản học thuật', 'pos' => 'noun', 'ipa' => '/ˈraɪ.tɪŋ/', 'ex' => 'Task 2 requires a well-structured linearthinking argument.'],
            'speaking' => ['def' => 'Kỹ năng nói, giao tiếp phát âm', 'pos' => 'noun', 'ipa' => '/ˈspiː.kɪŋ/', 'ex' => 'In Part 2 Speaking, candidate has one minute to take notes.'],
            'crucial' => ['def' => 'Vô cùng quan trọng, mang tính cốt lõi và quyết định', 'pos' => 'adjective', 'ipa' => '/ˈkruː.ʃəl/', 'ex' => 'Accurate time management is crucial for finishing all 40 questions.'],
            'compelling' => ['def' => 'Thuyết phục, hấp dẫn, cuốn hút không thể chối từ', 'pos' => 'adjective', 'ipa' => '/kəmˈpel.ɪŋ/', 'ex' => 'The candidate presented a compelling thesis in the opening paragraph.'],
            'meticulous' => ['def' => 'Tỉ mỉ, cẩn thận, chi tiết từng li từng tí', 'pos' => 'adjective', 'ipa' => '/məˈtɪk.jə.ləs/', 'ex' => 'Research candidates must be meticulous when recording experimental data.'],
            'autonomous' => ['def' => 'Tự hành, tự trị, hoạt động độc lập không cần can thiệp', 'pos' => 'adjective', 'ipa' => '/ɑːˈtɑː.nə.məs/', 'ex' => 'Autonomous vehicles could significantly reduce urban traffic accidents.'],
            'feasible' => ['def' => 'Khả thi, có thể thực hiện được một cách thực tế', 'pos' => 'adjective', 'ipa' => '/ˈfiː.zə.bəl/', 'ex' => 'The committee evaluated whether the proposed subway expansion is economically feasible.'],
            'mitigate' => ['def' => 'Giảm nhẹ, xoa dịu, giảm thiểu mức độ nghiêm trọng', 'pos' => 'verb', 'ipa' => '/ˈmɪt.ɪ.ɡeɪt/', 'ex' => 'Investing in green public transit helps mitigate urban carbon emissions.'],
            'deteriorate' => ['def' => 'Suy giảm, xuống cấp, xấu đi theo thời gian', 'pos' => 'verb', 'ipa' => '/dɪˈtɪr.i.ə.reɪt/', 'ex' => 'Air quality continued to deteriorate until strict industrial caps were enforced.'],
            'consensus' => ['def' => 'Sự đồng thuận, sự nhất trí chung giữa các bên', 'pos' => 'noun', 'ipa' => '/kənˈsen.səs/', 'ex' => 'International scientists reached a general consensus on climate trends.'],
            'reimburse' => ['def' => 'Hoàn trả chi phí, thanh toán bồi hoàn (TOEIC Business)', 'pos' => 'verb', 'ipa' => '/ˌriː.ɪmˈbɜːrs/', 'ex' => 'The finance division will reimburse all approved flight and lodging receipts.'],
            'itinerary' => ['def' => 'Lịch trình chuyến đi, hành trình công tác', 'pos' => 'noun', 'ipa' => '/aɪˈtɪn.ə.rer.i/', 'ex' => 'Please confirm your conference itinerary with the administrative assistant.'],
            'warranty' => ['def' => 'Phiếu bảo hành, cam kết chất lượng sản phẩm', 'pos' => 'noun', 'ipa' => '/ˈwɔːr.ən.ti/', 'ex' => 'All industrial printing equipment is covered by a three-year limited warranty.'],
            'lucrative' => ['def' => 'Sinh lời cao, mang lại nhiều lợi nhuận', 'pos' => 'adjective', 'ipa' => '/ˈluː.krə.tɪv/', 'ex' => 'The tech corporation secured a lucrative supply contract in Europe.'],
            'preliminary' => ['def' => 'Sơ bộ, bước đầu, mở đầu', 'pos' => 'adjective', 'ipa' => '/prɪˈlɪm.ə.ner.i/', 'ex' => 'Preliminary audit results indicate an overall revenue gain of ten percent.'],
        ];

        $lowerWord = strtolower($word);
        if (isset($commonDict[$lowerWord])) {
            $item = $commonDict[$lowerWord];
            return response()->json([
                'success' => true,
                'word' => $word,
                'phonetic' => $item['ipa'],
                'audio' => "https://api.dictionaryapi.dev/media/pronunciations/en/{$lowerWord}-us.mp3",
                'audio_us' => "https://api.dictionaryapi.dev/media/pronunciations/en/{$lowerWord}-us.mp3",
                'audio_uk' => "https://api.dictionaryapi.dev/media/pronunciations/en/{$lowerWord}-uk.mp3",
                'part_of_speech' => $item['pos'],
                'definition_vi' => $item['def'],
                'definition_en' => 'Standard Cambridge & Oxford dictionary definition.',
                'example' => $item['ex'] ?? "Example sentence for '{$word}'.",
                'collocations' => [],
            ]);
        }

        // 3. Online Translate & Dictionary Fallback (MyMemory Translation API)
        $phonetic = "/{$word}/";
        $defVi = '';
        $defEn = '';
        $pos = 'word';
        $audioUs = '';
        $audioUk = '';
        $example = '';

        try {
            // Instant Vietnamese translation via MyMemory API
            $transRes = Http::timeout(2.5)->get('https://api.mymemory.translated.net/get', [
                'q' => $word,
                'langpair' => 'en|vi',
            ]);

            if ($transRes->successful()) {
                $transData = $transRes->json();
                $translatedText = $transData['responseData']['translatedText'] ?? '';
                if (!empty($translatedText) && strtolower($translatedText) !== $lowerWord) {
                    $defVi = $translatedText;
                }
            }
        } catch (\Throwable $e) {
            // Ignore timeout
        }

        // 4. Try English definitions & real audio via Free Dictionary API
        try {
            $dictRes = Http::timeout(2.5)->get("https://api.dictionaryapi.dev/api/v2/entries/en/{$word}");
            if ($dictRes->successful() && !empty($dictRes->json())) {
                $data = $dictRes->json()[0];
                $phonetic = $data['phonetic'] ?? ($data['phonetics'][0]['text'] ?? $phonetic);
                
                // Extract audio tracks
                if (!empty($data['phonetics']) && is_array($data['phonetics'])) {
                    foreach ($data['phonetics'] as $ph) {
                        $aud = $ph['audio'] ?? '';
                        if (!empty($aud)) {
                            if (str_contains($aud, '-us') || str_contains($aud, '/us/')) {
                                $audioUs = $aud;
                            } elseif (str_contains($aud, '-uk') || str_contains($aud, '/uk/')) {
                                $audioUk = $aud;
                            } elseif (empty($audioUs)) {
                                $audioUs = $aud;
                            }
                        }
                    }
                }

                $meaning = $data['meanings'][0] ?? null;
                if ($meaning) {
                    $pos = $meaning['partOfSpeech'] ?? $pos;
                    $firstDef = $meaning['definitions'][0] ?? null;
                    if ($firstDef) {
                        $defEn = $firstDef['definition'] ?? '';
                        $example = $firstDef['example'] ?? '';
                    }
                }
            }
        } catch (\Throwable $e) {
            // Ignore timeout
        }

        if (empty($defVi) && !empty($defEn)) {
            $defVi = "Nghĩa tiếng Anh: {$defEn}";
        } elseif (empty($defVi)) {
            $defVi = "Từ vựng: '{$word}'. Bấm phát âm để nghe âm chuẩn.";
        }

        return response()->json([
            'success' => true,
            'word' => $word,
            'phonetic' => $phonetic,
            'audio' => $audioUs ?: $audioUk,
            'audio_us' => $audioUs,
            'audio_uk' => $audioUk,
            'part_of_speech' => $pos,
            'definition_vi' => $defVi,
            'definition_en' => $defEn,
            'example' => $example ?: "Example sentence for '{$word}' in reading context.",
            'collocations' => [],
        ]);
    }

    public function saveWord(Request $request): JsonResponse
    {
        $userId = $request->user()?->id ?? User::first()?->id ?? 1;

        $command = new SaveWordCommand(
            userId: $userId,
            word: (string) $request->input('word'),
            definitionVi: (string) $request->input('definition_vi', 'Đã lưu từ bài đọc'),
            contextSentence: (string) $request->input('context_sentence'),
            phoneticUs: (string) $request->input('phonetic'),
            audioUs: (string) $request->input('audio'),
            partOfSpeech: (string) $request->input('part_of_speech'),
            customNote: (string) $request->input('custom_note')
        );

        $flashcard = $this->commandBus->dispatch($command);

        return response()->json([
            'success' => true,
            'message' => "Đã lưu từ '{$request->input('word')}' vào Sổ từ vựng thành công!",
            'card' => $flashcard,
        ]);
    }
}
