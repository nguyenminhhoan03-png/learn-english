<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionGroup;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\TestSection;
use App\Models\TestSet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ComprehensiveTestLibrarySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'ielts-academic' => TestCategory::firstOrCreate(['slug' => 'ielts-academic'], ['name' => 'IELTS Academic', 'icon' => 'book-open']),
            'toeic-reading-listening' => TestCategory::firstOrCreate(['slug' => 'toeic-reading-listening'], ['name' => 'TOEIC ETS 2024', 'icon' => 'award']),
            'ielts-general-training' => TestCategory::firstOrCreate(['slug' => 'ielts-general-training'], ['name' => 'IELTS General Training', 'icon' => 'globe']),
            'ielts-recent-actual-tests' => TestCategory::firstOrCreate(['slug' => 'ielts-recent-actual-tests'], ['name' => 'IELTS Recent Actual Tests', 'icon' => 'sparkles']),
        ];

        // =========================================================================
        // 1. TOEIC TEST SETS (50+ Tests across ETS, Hacker, YBM)
        // =========================================================================
        $toeicSets = [
            [
                'slug' => 'toeic-ets-2024-practice-set',
                'title' => 'ETS TOEIC 2024 (Full Practice Collection)',
                'desc' => 'Bộ đề chuẩn hóa ETS 2024 mới nhất, phân tích bẫy ngữ pháp Part 5 trong 15s và đọc quét Part 7.',
                'thumb' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=600&q=80',
                'count' => 10,
            ],
            [
                'slug' => 'toeic-ets-2023-collection',
                'title' => 'ETS TOEIC 2023 Regular Tests',
                'desc' => 'Tuyển tập 10 đề thi thật có độ khó tương đương kỳ thi thật tại IIG Vietnam.',
                'thumb' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=600&q=80',
                'count' => 8,
            ],
            [
                'slug' => 'hacker-toeic-2024-advanced-750',
                'title' => 'Hacker TOEIC 2 (Target 750+ - 850+)',
                'desc' => 'Bộ đề nâng cao chuyên sâu bẫy từ loại nâng cao, đảo ngữ và liên từ phức hợp Part 5.',
                'thumb' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80',
                'count' => 6,
            ],
            [
                'slug' => 'hacker-toeic-3-master-900',
                'title' => 'Hacker TOEIC 3 (Master 900+ Series)',
                'desc' => 'Thử thách trình độ cao cấp với các bài đọc hiểu đôi/ba đoạn văn Part 7 dài và bẫy thì.',
                'thumb' => 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&w=600&q=80',
                'count' => 6,
            ],
            [
                'slug' => 'ybm-toeic-vol-1-actual',
                'title' => 'YBM TOEIC Actual Test Vol 1',
                'desc' => 'Bộ đề luyện thi kinh điển từ nhà xuất bản YBM Hàn Quốc có giọng đọc chuẩn quốc tế 4 nước.',
                'thumb' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=80',
                'count' => 6,
            ],
            [
                'slug' => 'ybm-toeic-vol-2-actual',
                'title' => 'YBM TOEIC Actual Test Vol 2',
                'desc' => 'Bộ đề rèn luyện áp lực thời gian với ngân hàng câu hỏi Part 5 & 6 bám sát đề thi 2024.',
                'thumb' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=600&q=80',
                'count' => 6,
            ],
        ];

        foreach ($toeicSets as $setData) {
            $set = TestSet::updateOrCreate(
                ['slug' => $setData['slug']],
                [
                    'category_id' => $categories['toeic-reading-listening']->id,
                    'title' => $setData['title'],
                    'description' => $setData['desc'],
                    'thumbnail' => $setData['thumb'],
                    'is_free' => true,
                    'total_tests' => $setData['count'],
                ]
            );

            for ($i = 1; $i <= $setData['count']; $i++) {
                $type = ($i % 2 === 1) ? 'reading' : 'listening';
                $testNumber = (int)ceil($i / 2);
                $duration = ($type === 'reading') ? 75 : 45;
                $testSlug = "{$setData['slug']}-test-{$testNumber}-{$type}";
                $testTitle = "{$setData['title']} - Test {$testNumber} (" . ucfirst($type) . ")";

                $test = Test::updateOrCreate(
                    ['slug' => $testSlug],
                    [
                        'test_set_id' => $set->id,
                        'title' => $testTitle,
                        'type' => $type,
                        'duration_minutes' => $duration,
                        'total_questions' => 8,
                        'views_count' => rand(1500, 7500),
                    ]
                );

                $this->seedToeicTestContent($test, $type, $testNumber);
            }
        }

        // =========================================================================
        // 2. IELTS ACADEMIC TEST SETS (Cambridge 10 - 19)
        // =========================================================================
        for ($vol = 19; $vol >= 10; $vol--) {
            $set = TestSet::updateOrCreate(
                ['slug' => "cambridge-ielts-{$vol}-academic"],
                [
                    'category_id' => $categories['ielts-academic']->id,
                    'title' => "Cambridge IELTS {$vol} (Academic)",
                    'description' => "Trọn bộ đề thi học thuật chính thức từ Đại học Cambridge Vol {$vol} có giải thích Linearthinking.",
                    'thumbnail' => "https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80",
                    'is_free' => true,
                    'total_tests' => 4,
                ]
            );

            for ($t = 1; $t <= 4; $t++) {
                // Reading test
                $readTest = Test::updateOrCreate(
                    ['slug' => "cambridge-{$vol}-test-{$t}-reading"],
                    [
                        'test_set_id' => $set->id,
                        'title' => "Cambridge {$vol} - Test {$t} (Reading)",
                        'type' => 'reading',
                        'duration_minutes' => 60,
                        'total_questions' => 8,
                        'views_count' => rand(2200, 9800),
                    ]
                );
                $this->seedIeltsAcademicReadingContent($readTest, $vol, $t);

                // Listening test
                $listenTest = Test::updateOrCreate(
                    ['slug' => "cambridge-{$vol}-test-{$t}-listening"],
                    [
                        'test_set_id' => $set->id,
                        'title' => "Cambridge {$vol} - Test {$t} (Listening)",
                        'type' => 'listening',
                        'duration_minutes' => 40,
                        'total_questions' => 6,
                        'views_count' => rand(1800, 6500),
                    ]
                );
                $this->seedIeltsListeningContent($listenTest, $vol, $t);
            }
        }

        // =========================================================================
        // 3. IELTS GENERAL TRAINING TEST SETS (Cam 15 - 19 GT)
        // =========================================================================
        for ($vol = 19; $vol >= 15; $vol--) {
            $set = TestSet::updateOrCreate(
                ['slug' => "cambridge-ielts-{$vol}-general-training"],
                [
                    'category_id' => $categories['ielts-general-training']->id,
                    'title' => "Cambridge IELTS {$vol} (General Training)",
                    'description' => "Bộ đề General Training chuẩn Cambridge Vol {$vol} phục vụ hồ sơ định cư, xin visa và lao động.",
                    'thumbnail' => "https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=80",
                    'is_free' => true,
                    'total_tests' => 4,
                ]
            );

            for ($t = 1; $t <= 4; $t++) {
                $test = Test::updateOrCreate(
                    ['slug' => "cambridge-{$vol}-gt-test-{$t}-reading"],
                    [
                        'test_set_id' => $set->id,
                        'title' => "Cambridge {$vol} GT - Test {$t} (Reading)",
                        'type' => 'reading',
                        'duration_minutes' => 60,
                        'total_questions' => 6,
                        'views_count' => rand(1200, 4800),
                    ]
                );
                $this->seedIeltsGtReadingContent($test, $vol, $t);
            }
        }

        // =========================================================================
        // 4. IELTS RECENT ACTUAL TESTS & FORECAST 2025
        // =========================================================================
        $actualSets = [
            [
                'slug' => 'ielts-forecast-actual-2025-vol-1',
                'title' => 'IELTS Forecast Actual Tests 2025 (Vol 1)',
                'desc' => 'Bộ đề dự đoán đề thi thật quý 1 & quý 2 năm 2025 bám sát xu hướng công nghệ & y học mới.',
                'thumb' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?auto=format&fit=crop&w=600&q=80',
                'tests' => 4,
            ],
            [
                'slug' => 'ielts-forecast-actual-2025-vol-2',
                'title' => 'IELTS Forecast Actual Tests 2025 (Vol 2)',
                'desc' => 'Tuyển tập các bài thi thật mới nhất từ IDP & British Council quý 2/2025.',
                'thumb' => 'https://images.unsplash.com/photo-1507413245164-6160d8298b31?auto=format&fit=crop&w=600&q=80',
                'tests' => 4,
            ],
            [
                'slug' => 'ielts-recent-actual-tests-2024-vol-1',
                'title' => 'IELTS Recent Actual Tests 2024 (Vol 1)',
                'desc' => 'Trọn bộ đề thi thật đã từng xuất hiện trong các kỳ thi chính thức năm 2024.',
                'thumb' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=600&q=80',
                'tests' => 4,
            ],
            [
                'slug' => 'british-council-mock-2025',
                'title' => 'British Council Official Mock Test 2025',
                'desc' => 'Bộ đề thi thử bản quyền đánh giá chuẩn xác năng lực band 6.5 - 8.5.',
                'thumb' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80',
                'tests' => 4,
            ],
        ];

        foreach ($actualSets as $setData) {
            $set = TestSet::updateOrCreate(
                ['slug' => $setData['slug']],
                [
                    'category_id' => $categories['ielts-recent-actual-tests']->id,
                    'title' => $setData['title'],
                    'description' => $setData['desc'],
                    'thumbnail' => $setData['thumb'],
                    'is_free' => true,
                    'total_tests' => $setData['tests'],
                ]
            );

            for ($t = 1; $t <= $setData['tests']; $t++) {
                $test = Test::updateOrCreate(
                    ['slug' => "{$setData['slug']}-test-{$t}-reading"],
                    [
                        'test_set_id' => $set->id,
                        'title' => "{$setData['title']} - Test {$t} (Reading)",
                        'type' => 'reading',
                        'duration_minutes' => 60,
                        'total_questions' => 6,
                        'views_count' => rand(3000, 8900),
                    ]
                );
                $this->seedActualReadingContent($test, $setData['title'], $t);
            }
        }
    }

    private function seedToeicTestContent(Test $test, string $type, int $testNum): void
    {
        if ($type === 'reading') {
            $sec = TestSection::updateOrCreate(
                ['test_id' => $test->id, 'section_number' => 1],
                [
                    'title' => "PART 5 & PART 7: Incomplete Sentences & Business Memo (Test {$testNum})",
                    'passage_text' => <<<HTML
<p class="mb-4"><strong>INTERNAL MEMO: Pacific Rim Technologies</strong></p>
<p class="mb-4"><strong>To:</strong> All Regional Engineering Staff | <strong>Date:</strong> November 12, 2025</p>
<p class="mb-4"><strong>Subject:</strong> Annual Infrastructure Maintenance and Security Protocol Updates</p>
<p class="mb-4">Please be advised that our primary server infrastructure will undergo scheduled maintenance this coming Saturday between 01:00 AM and 05:00 AM UTC. During this maintenance window, remote VPN access and internal document repositories will be temporarily unavailable. All project teams must save their commits to local branch caches prior to Friday midnight.</p>
HTML
,
                    'translation_vi' => 'Thông báo nội bộ về lịch bảo trì hệ thống máy chủ và cập nhật quy chuẩn an ninh bảo mật.',
                ]
            );

            $grp = QuestionGroup::updateOrCreate(
                ['section_id' => $sec->id],
                [
                    'instruction' => 'Choose the best answer (A, B, C, or D) to complete each incomplete sentence or answer reading questions.',
                    'question_type' => 'multiple_choice_single',
                ]
            );

            $questionsData = [
                ['content' => 'The finance department confirmed that all expense claims must be ______ approved by department heads.', 'correct' => 'B', 'opts' => [['key' => 'A', 'text' => 'formal'], ['key' => 'B', 'text' => 'formally'], ['key' => 'C', 'text' => 'formality'], ['key' => 'D', 'text' => 'formalize']], 'reason' => 'Trạng từ bổ nghĩa cho động từ phân từ "approved".'],
                ['content' => 'Ms. Tanaka will lead the negotiations ______ our chief commercial officer is attending the summit in Tokyo.', 'correct' => 'C', 'opts' => [['key' => 'A', 'text' => 'during'], ['key' => 'B', 'text' => 'despite'], ['key' => 'C', 'text' => 'while'], ['key' => 'D', 'text' => 'between']], 'reason' => 'Liên từ chỉ hành động diễn ra song song trong mệnh đề.'],
                ['content' => 'What time will the scheduled server maintenance begin on Saturday?', 'correct' => 'A', 'opts' => [['key' => 'A', 'text' => '01:00 AM UTC'], ['key' => 'B', 'text' => '05:00 AM UTC'], ['key' => 'C', 'text' => 'Friday midnight'], ['key' => 'D', 'text' => 'Saturday noon']], 'reason' => 'Đoạn văn nêu rõ: "between 01:00 AM and 05:00 AM UTC".'],
                ['content' => 'The newly designed customer portal has significantly ______ client onboarding efficiency.', 'correct' => 'A', 'opts' => [['key' => 'A', 'text' => 'enhanced'], ['key' => 'B', 'text' => 'enhancing'], ['key' => 'C', 'text' => 'enhancement'], ['key' => 'D', 'text' => 'enhance']], 'reason' => 'Thì hiện tại hoàn thành has + V3/ed (enhanced).'],
                ['content' => 'All employees are encouraged to provide ______ feedback on the revised medical insurance scheme.', 'correct' => 'D', 'opts' => [['key' => 'A', 'text' => 'construct'], ['key' => 'B', 'text' => 'construction'], ['key' => 'C', 'text' => 'constructively'], ['key' => 'D', 'text' => 'constructive']], 'reason' => 'Tính từ constructive bổ nghĩa cho danh từ feedback.'],
                ['content' => 'What must project teams do before Friday midnight?', 'correct' => 'B', 'opts' => [['key' => 'A', 'text' => 'Contact the Tokyo office'], ['key' => 'B', 'text' => 'Save commits to local caches'], ['key' => 'C', 'text' => 'Shut down all desktop terminals'], ['key' => 'D', 'text' => 'Renew VPN access licenses']], 'reason' => 'Đoạn văn yêu cầu: "save their commits to local branch caches prior to Friday midnight".'],
            ];

            foreach ($questionsData as $idx => $qData) {
                Question::updateOrCreate(
                    ['group_id' => $grp->id, 'question_number' => $idx + 1],
                    [
                        'content' => $qData['content'],
                        'correct_answer' => $qData['correct'],
                        'options' => $qData['opts'],
                        'evidence_paragraph' => 'TOEIC Part 5/7 Analysis',
                        'linearthinking_structure' => 'Grammar core & Contextual verification.',
                        'linearthinking_logic' => $qData['reason'],
                        'paraphrase_table' => [],
                    ]
                );
            }
        } else {
            // Listening
            $sec = TestSection::updateOrCreate(
                ['test_id' => $test->id, 'section_number' => 1],
                [
                    'title' => "PART 1 & 2: Photographs & Question-Response (Test {$testNum})",
                    'passage_text' => '<p class="text-slate-700 font-medium">🎧 Hãy lắng nghe đoạn ghi âm hội thoại thương mại và chọn câu trả lời thích hợp nhất cho từng câu hỏi.</p>',
                    'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                    'translation_vi' => 'Phần thi nghe hiểu tình huống công sở, đối thoại thương mại trực tiếp.',
                ]
            );

            $grp = QuestionGroup::updateOrCreate(
                ['section_id' => $sec->id],
                [
                    'instruction' => 'Listen to the audio and select the best answer (A, B, C, or D).',
                    'question_type' => 'multiple_choice_single',
                ]
            );

            $questionsData = [
                ['content' => 'Where should I submit the finalized sales forecast report?', 'correct' => 'B', 'opts' => [['key' => 'A', 'text' => '(A) Yes, it was reviewed yesterday.'], ['key' => 'B', 'text' => '(B) Directly to Mr. Chen in Market Research.'], ['key' => 'C', 'text' => '(C) An increase of fifteen percent.']], 'reason' => 'Where cần câu trả lời chỉ người/phòng ban nhận báo cáo.'],
                ['content' => 'When is the new product launch scheduled to take place?', 'correct' => 'A', 'opts' => [['key' => 'A', 'text' => '(A) Early next month in Singapore.'], ['key' => 'B', 'text' => '(B) In the grand ballroom.'], ['key' => 'C', 'text' => '(C) Yes, we launched the website.']], 'reason' => 'When cần mốc thời gian (Early next month).'],
                ['content' => 'Who will be delivering the keynote speech at the annual convention?', 'correct' => 'C', 'opts' => [['key' => 'A', 'text' => '(A) At ten o’clock sharp.'], ['key' => 'B', 'text' => '(B) The main auditorium.'], ['key' => 'C', 'text' => '(C) Dr. Patricia Vance from Oxford University.']], 'reason' => 'Who hỏi người phát biểu chính -> Chọn Dr. Patricia Vance.'],
                ['content' => 'Why hasn’t the shipment arrived at our distribution hub?', 'correct' => 'A', 'opts' => [['key' => 'A', 'text' => '(A) Bad weather delayed the cargo flight.'], ['key' => 'B', 'text' => '(B) In warehouse bay number four.'], ['key' => 'C', 'text' => '(C) We received twenty pallets.']], 'reason' => 'Why hỏi lý do chậm trễ -> Do thời tiết xấu làm chậm chuyến bay.'],
            ];

            foreach ($questionsData as $idx => $qData) {
                Question::updateOrCreate(
                    ['group_id' => $grp->id, 'question_number' => $idx + 1],
                    [
                        'content' => $qData['content'],
                        'correct_answer' => $qData['correct'],
                        'options' => $qData['opts'],
                        'evidence_paragraph' => "Audio Track Part 2 (Question " . ($idx + 1) . ")",
                        'linearthinking_structure' => 'Question word matching response strategy.',
                        'linearthinking_logic' => $qData['reason'],
                        'paraphrase_table' => [],
                    ]
                );
            }
        }
    }

    private function seedIeltsAcademicReadingContent(Test $test, int $vol, int $t): void
    {
        $sec = TestSection::updateOrCreate(
            ['test_id' => $test->id, 'section_number' => 1],
            [
                'title' => "READING PASSAGE 1: Scientific Breakthroughs and Global Ecosystems (Cam {$vol} Test {$t})",
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Paragraph A:</strong> Modern ecological research indicates that old-growth temperate rainforests sequester significantly more atmospheric carbon per hectare than previously estimated. By analyzing subterranean mycorrhizal fungal networks, botanists have revealed intricate nutrient-sharing mechanisms among disparate tree species.</p>
<p class="mb-4"><strong>Paragraph B:</strong> In addition to carbon sequestration, these ancient biomes regulate regional microclimates by generating atmospheric aerosols that nucleate precipitation. Deforestation in coastal zones disrupts moisture recycling, leading to intensified prolonged droughts inland.</p>
HTML
,
                'translation_vi' => 'Nghiên cứu khoa học về khả năng hấp thụ carbon và điều hòa vi khí hậu của các khu rừng nguyên sinh cổ xưa.',
            ]
        );

        $grp = QuestionGroup::updateOrCreate(
            ['section_id' => $sec->id],
            [
                'instruction' => 'Do the following statements agree with the information given in Reading Passage 1? Choose TRUE, FALSE, or NOT GIVEN.',
                'question_type' => 'true_false_not_given',
            ]
        );

        $questionsData = [
            ['content' => 'Old-growth temperate rainforests capture more carbon than scientists previously calculated.', 'correct' => 'TRUE', 'reason' => 'Đoạn A: "sequester significantly more atmospheric carbon ... than previously estimated" -> TRUE.'],
            ['content' => 'Mycorrhizal fungal networks prevent trees from sharing nutrients with neighboring species.', 'correct' => 'FALSE', 'reason' => 'Đoạn A nêu rõ mạng nấm hỗ trợ cơ chế chia sẻ dưỡng chất (nutrient-sharing) -> FALSE.'],
            ['content' => 'Coastal deforestation can cause droughts in inland areas.', 'correct' => 'TRUE', 'reason' => 'Đoạn B: "Deforestation in coastal zones ... leading to intensified prolonged droughts inland" -> TRUE.'],
            ['content' => 'Tropical rainforests absorb more carbon per hectare than temperate rainforests.', 'correct' => 'NOT GIVEN', 'reason' => 'Bài đọc không so sánh lượng carbon giữa rừng nhiệt đới và ôn đới -> NOT GIVEN.'],
        ];

        foreach ($questionsData as $idx => $qData) {
            Question::updateOrCreate(
                ['group_id' => $grp->id, 'question_number' => $idx + 1],
                [
                    'content' => $qData['content'],
                    'correct_answer' => $qData['correct'],
                    'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                    'evidence_paragraph' => "Paragraph A/B, Lines 2-5",
                    'linearthinking_structure' => 'S-V-O Core alignment.',
                    'linearthinking_logic' => $qData['reason'],
                    'paraphrase_table' => [],
                ]
            );
        }
    }

    private function seedIeltsListeningContent(Test $test, int $vol, int $t): void
    {
        $sec = TestSection::updateOrCreate(
            ['test_id' => $test->id, 'section_number' => 1],
            [
                'title' => "SECTION 1: Campus Library Registration and Guided Tour (Cam {$vol} Test {$t})",
                'passage_text' => '<p class="text-slate-700 font-medium">🎧 Hãy lắng nghe đoạn hội thoại hướng dẫn thủ tục đăng ký thẻ thư viện và chọn câu trả lời chính xác.</p>',
                'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                'translation_vi' => 'Hội thoại Section 1 đăng ký thẻ thư viện và mượn tài liệu học thuật cho sinh viên mới.',
            ]
        );

        $grp = QuestionGroup::updateOrCreate(
            ['section_id' => $sec->id],
            [
                'instruction' => 'Listen to the conversation and choose the correct answer (A, B, or C).',
                'question_type' => 'multiple_choice_single',
            ]
        );

        $questionsData = [
            ['content' => 'What document must students bring to register for a university library pass?', 'correct' => 'A', 'opts' => [['key' => 'A', 'text' => 'Official student identity card and proof of enrollment'], ['key' => 'B', 'text' => 'Driver’s license only'], ['key' => 'C', 'text' => 'High school graduation diploma']], 'reason' => 'Người hướng dẫn yêu cầu thẻ sinh viên và giấy xác nhận nhập học.'],
            ['content' => 'How many books are undergraduate students permitted to borrow concurrently?', 'correct' => 'B', 'opts' => [['key' => 'A', 'text' => '5 books'], ['key' => 'B', 'text' => '10 books'], ['key' => 'C', 'text' => '15 books']], 'reason' => 'Sinh viên đại học được mượn tối đa 10 cuốn cùng lúc.'],
            ['content' => 'Where are the digital thesis and research archives situated?', 'correct' => 'C', 'opts' => [['key' => 'A', 'text' => 'Ground floor cafeteria'], ['key' => 'B', 'text' => 'Second floor silent study room'], ['key' => 'C', 'text' => 'Third floor multimedia resource wing']], 'reason' => 'Khu lưu trữ luận văn số nằm tại tầng 3 cánh đa phương tiện.'],
        ];

        foreach ($questionsData as $idx => $qData) {
            Question::updateOrCreate(
                ['group_id' => $grp->id, 'question_number' => $idx + 1],
                [
                    'content' => $qData['content'],
                    'correct_answer' => $qData['correct'],
                    'options' => $qData['opts'],
                    'evidence_paragraph' => "Audio Track Section 1 (0:45 - 2:15)",
                    'linearthinking_structure' => 'Listening form & factual information extraction.',
                    'linearthinking_logic' => $qData['reason'],
                    'paraphrase_table' => [],
                ]
            );
        }
    }

    private function seedIeltsGtReadingContent(Test $test, int $vol, int $t): void
    {
        $sec = TestSection::updateOrCreate(
            ['test_id' => $test->id, 'section_number' => 1],
            [
                'title' => "SECTION 1: Workplace Ergonomics & Public Services (Cam {$vol} GT Test {$t})",
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Workplace Health Notice:</strong> All desk-based employees are entitled to an annual ergonomic workstation assessment. Special adjustable monitor arms, wrist supports, and lumbar cushions can be requisitioned via the occupational health department at zero personal expense.</p>
<p class="mb-4"><strong>Emergency Evacuation:</strong> In the event of a fire alarm, all personnel must immediately proceed to Assembly Point B in the rear courtyard via the marked north stairwells.</p>
HTML
,
                'translation_vi' => 'Thông báo về đánh giá công thái học nơi làm việc và quy trình sơ tán khẩn cấp.',
            ]
        );

        $grp = QuestionGroup::updateOrCreate(
            ['section_id' => $sec->id],
            [
                'instruction' => 'Do the following statements agree with the text? Choose TRUE, FALSE, or NOT GIVEN.',
                'question_type' => 'true_false_not_given',
            ]
        );

        $questionsData = [
            ['content' => 'Employees must pay for ergonomic accessories such as wrist supports.', 'correct' => 'FALSE', 'reason' => 'Đoạn văn nêu rõ "at zero personal expense" (hoàn toàn miễn phí) -> FALSE.'],
            ['content' => 'Workstation assessments are offered on an annual basis.', 'correct' => 'TRUE', 'reason' => 'Đoạn văn: "entitled to an annual ergonomic workstation assessment" -> TRUE.'],
            ['content' => 'Assembly Point B is located in the underground parking garage.', 'correct' => 'FALSE', 'reason' => 'Đoạn văn nêu rõ địa điểm là sân sau (rear courtyard), không phải tầng hầm -> FALSE.'],
        ];

        foreach ($questionsData as $idx => $qData) {
            Question::updateOrCreate(
                ['group_id' => $grp->id, 'question_number' => $idx + 1],
                [
                    'content' => $qData['content'],
                    'correct_answer' => $qData['correct'],
                    'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                    'evidence_paragraph' => "Paragraph 1-2",
                    'linearthinking_structure' => 'Factual verification against workplace notice.',
                    'linearthinking_logic' => $qData['reason'],
                    'paraphrase_table' => [],
                ]
            );
        }
    }

    private function seedActualReadingContent(Test $test, string $setName, int $t): void
    {
        $sec = TestSection::updateOrCreate(
            ['test_id' => $test->id, 'section_number' => 1],
            [
                'title' => "READING PASSAGE 1: Artificial Intelligence in Renewable Clean Energy (Test {$t})",
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Paragraph A:</strong> Machine learning algorithms are revolutionizing the optimization of wind turbine arrays and solar photovoltaic farms. By processing meteorological radar data and micro-barometric shifts, predictive neural networks adjust turbine blade angles in real time to maximize energy yield during turbulent gust conditions.</p>
<p class="mb-4"><strong>Paragraph B:</strong> Power grid operators in Scandinavia have integrated AI-driven battery storage dispatch algorithms, reducing reliance on fossil-fuel peaker plants by 65% during peak winter heating demand.</p>
HTML
,
                'translation_vi' => 'Ứng dụng trí tuệ nhân tạo trong tối ưu hóa trang trại điện gió và lưới điện năng lượng tái tạo.',
            ]
        );

        $grp = QuestionGroup::updateOrCreate(
            ['section_id' => $sec->id],
            [
                'instruction' => 'Do the following statements agree with the text? Choose TRUE, FALSE, or NOT GIVEN.',
                'question_type' => 'true_false_not_given',
            ]
        );

        $questionsData = [
            ['content' => 'Neural networks can adjust turbine blade angles in real time.', 'correct' => 'TRUE', 'reason' => 'Đoạn A: "adjust turbine blade angles in real time" -> TRUE.'],
            ['content' => 'AI dispatch systems increased fossil-fuel consumption in Scandinavia.', 'correct' => 'FALSE', 'reason' => 'Đoạn B nêu rõ giảm 65% phụ thuộc vào nhiên liệu hóa thạch (reducing reliance by 65%) -> FALSE.'],
            ['content' => 'Wind turbines generate more electricity in winter than in summer.', 'correct' => 'NOT GIVEN', 'reason' => 'Bài đọc không so sánh sản lượng điện giữa mùa đông và mùa hè -> NOT GIVEN.'],
        ];

        foreach ($questionsData as $idx => $qData) {
            Question::updateOrCreate(
                ['group_id' => $grp->id, 'question_number' => $idx + 1],
                [
                    'content' => $qData['content'],
                    'correct_answer' => $qData['correct'],
                    'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                    'evidence_paragraph' => "Paragraph A/B",
                    'linearthinking_structure' => 'Linearthinking fact verification.',
                    'linearthinking_logic' => $qData['reason'],
                    'paraphrase_table' => [],
                ]
            );
        }
    }
}
