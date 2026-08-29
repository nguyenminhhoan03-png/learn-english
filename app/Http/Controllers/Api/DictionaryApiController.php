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

        // 2. Built-in instant dictionary for high-frequency daily & academic words
        $commonDict = [
            'hello' => ['def' => 'Xin chào (lời chào hỏi thân thiện hoặc khi bắt đầu cuộc gọi)', 'pos' => 'exclamation/noun', 'ipa' => '/həˈloʊ/'],
            'hi' => ['def' => 'Xin chào (chào thân mật)', 'pos' => 'exclamation', 'ipa' => '/haɪ/'],
            'world' => ['def' => 'Thế giới, nhân loại, toàn cầu', 'pos' => 'noun', 'ipa' => '/wɜːrld/'],
            'learning' => ['def' => 'Sự học tập, quá trình tiếp thu kiến thức', 'pos' => 'noun', 'ipa' => '/ˈlɜːr.nɪŋ/'],
            'student' => ['def' => 'Học sinh, sinh viên, người nghiên cứu', 'pos' => 'noun', 'ipa' => '/ˈstuː.dənt/'],
            'teacher' => ['def' => 'Giáo viên, giảng viên, người dạy học', 'pos' => 'noun', 'ipa' => '/ˈtiː.tʃər/'],
            'language' => ['def' => 'Ngôn ngữ, tiếng nói, hệ thống giao tiếp', 'pos' => 'noun', 'ipa' => '/ˈlæŋ.ɡwɪdʒ/'],
            'practice' => ['def' => 'Luyện tập, thực hành, rèn luyện kỹ năng', 'pos' => 'noun/verb', 'ipa' => '/ˈpræk.tɪs/'],
            'reading' => ['def' => 'Kỹ năng đọc hiểu, bài đọc', 'pos' => 'noun', 'ipa' => '/ˈriː.dɪŋ/'],
            'listening' => ['def' => 'Kỹ năng nghe hiểu, lắng nghe', 'pos' => 'noun', 'ipa' => '/ˈlɪs.ən.ɪŋ/'],
            'writing' => ['def' => 'Kỹ năng viết luận, văn bản', 'pos' => 'noun', 'ipa' => '/ˈraɪ.tɪŋ/'],
            'speaking' => ['def' => 'Kỹ năng nói, giao tiếp phát âm', 'pos' => 'noun', 'ipa' => '/ˈspiː.kɪŋ/'],
            'transport' => ['def' => 'Giao thông vận tải, phương tiện chuyên chở', 'pos' => 'noun', 'ipa' => '/ˈtræn.spɔːrt/'],
            'autonomous' => ['def' => 'Tự hành, tự trị, hoạt động độc lập', 'pos' => 'adjective', 'ipa' => '/ɑːˈtɑː.nə.məs/'],
            'scandinavia' => ['def' => 'Vùng Bắc Âu (gồm Na Uy, Thụy Điển, Đan Mạch, Phần Lan)', 'pos' => 'proper noun', 'ipa' => '/ˌskæn.dɪˈneɪ.vi.ə/'],
            'mobility' => ['def' => 'Tính di động, khả năng di chuyển linh hoạt', 'pos' => 'noun', 'ipa' => '/moʊˈbɪl.ə.t̬i/'],
            'crucial' => ['def' => 'Vô cùng quan trọng, mang tính cốt lõi/quyết định', 'pos' => 'adjective', 'ipa' => '/ˈkruː.ʃəl/'],
            'meticulous' => ['def' => 'Tỉ mỉ, cẩn thận, chi tiết từng li từng tí', 'pos' => 'adjective', 'ipa' => '/məˈtɪk.jə.ləs/'],
            'effective' => ['def' => 'Có hiệu lực, hiệu quả, mang lại kết quả mong đợi', 'pos' => 'adjective', 'ipa' => '/əˈfek.tɪv/'],
        ];

        $lowerWord = strtolower($word);
        if (isset($commonDict[$lowerWord])) {
            $item = $commonDict[$lowerWord];
            return response()->json([
                'success' => true,
                'word' => $word,
                'phonetic' => $item['ipa'],
                'audio' => '',
                'part_of_speech' => $item['pos'],
                'definition_vi' => $item['def'],
                'definition_en' => '',
                'example' => "Example usage with '{$word}' in English context.",
                'collocations' => [],
            ]);
        }

        // 3. Online Translate & Dictionary Fallback (MyMemory Translation API)
        $phonetic = "/{$word}/";
        $defVi = '';
        $defEn = '';
        $pos = 'word';

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

        // 4. Try English definitions via Free Dictionary API
        try {
            $dictRes = Http::timeout(2.5)->get("https://api.dictionaryapi.dev/api/v2/entries/en/{$word}");
            if ($dictRes->successful() && !empty($dictRes->json())) {
                $data = $dictRes->json()[0];
                $phonetic = $data['phonetic'] ?? ($data['phonetics'][0]['text'] ?? $phonetic);
                $meaning = $data['meanings'][0] ?? null;
                if ($meaning) {
                    $pos = $meaning['partOfSpeech'] ?? $pos;
                    $defEn = $meaning['definitions'][0]['definition'] ?? '';
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
            'audio' => '',
            'part_of_speech' => $pos,
            'definition_vi' => $defVi,
            'definition_en' => $defEn,
            'example' => '',
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
