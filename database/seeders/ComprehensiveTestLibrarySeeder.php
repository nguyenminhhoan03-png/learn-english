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
                        'total_questions' => ($type === 'reading') ? 10 : 6,
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
                        'total_questions' => 3,
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
            // Section 1: TOEIC Part 5 - Incomplete Sentences
            $sec5 = TestSection::updateOrCreate(
                ['test_id' => $test->id, 'section_number' => 1],
                [
                    'title' => "PART 5: Incomplete Sentences (Test {$testNum})",
                    'passage_text' => '<p class="text-slate-600 font-medium">Chọn phương án thích hợp nhất (A, B, C, hoặc D) để hoàn thành các câu trắc nghiệm ngữ pháp & từ vựng công sở.</p>',
                    'translation_vi' => 'Phần 5: Điền câu trắc nghiệm ngữ pháp, từ loại, liên từ và từ vựng thương mại.',
                ]
            );
            $grp5 = QuestionGroup::updateOrCreate(
                ['section_id' => $sec5->id],
                [
                    'instruction' => 'Part 5: Choose the word or phrase that best completes each sentence.',
                    'question_type' => 'multiple_choice_single',
                ]
            );
            $p5Questions = [
                ['num' => 1, 'content' => 'The finance department confirmed that all expense claims must be ______ approved by department heads.', 'correct' => 'B', 'opts' => [['key' => 'A', 'text' => 'formal'], ['key' => 'B', 'text' => 'formally'], ['key' => 'C', 'text' => 'formality'], ['key' => 'D', 'text' => 'formalize']], 'reason' => 'Cần trạng từ formally bổ nghĩa cho động từ phân từ approved.'],
                ['num' => 2, 'content' => 'Ms. Tanaka will lead the contract negotiations ______ our chief commercial officer is attending the summit.', 'correct' => 'C', 'opts' => [['key' => 'A', 'text' => 'during'], ['key' => 'B', 'text' => 'despite'], ['key' => 'C', 'text' => 'while'], ['key' => 'D', 'text' => 'between']], 'reason' => 'While nối 2 mệnh đề diễn ra đồng thời.'],
                ['num' => 3, 'content' => 'The newly designed customer portal has significantly ______ client onboarding efficiency.', 'correct' => 'A', 'opts' => [['key' => 'A', 'text' => 'enhanced'], ['key' => 'B', 'text' => 'enhancing'], ['key' => 'C', 'text' => 'enhancement'], ['key' => 'D', 'text' => 'enhance']], 'reason' => 'Thì hiện tại hoàn thành has + V3 (enhanced).'],
                ['num' => 4, 'content' => 'All employees are strongly encouraged to provide ______ feedback on the revised health insurance policy.', 'correct' => 'D', 'opts' => [['key' => 'A', 'text' => 'construct'], ['key' => 'B', 'text' => 'construction'], ['key' => 'C', 'text' => 'constructively'], ['key' => 'D', 'text' => 'constructive']], 'reason' => 'Cần tính từ constructive bổ nghĩa cho danh từ feedback.'],
            ];
            foreach ($p5Questions as $q) {
                Question::updateOrCreate(
                    ['group_id' => $grp5->id, 'question_number' => $q['num']],
                    [
                        'content' => $q['content'],
                        'correct_answer' => $q['correct'],
                        'options' => $q['opts'],
                        'evidence_paragraph' => 'TOEIC Part 5 Grammar Structure',
                        'linearthinking_structure' => 'Word class & Syntax alignment',
                        'linearthinking_logic' => $q['reason'],
                        'paraphrase_table' => [],
                    ]
                );
            }

            // Section 2: TOEIC Part 6 - Text Completion
            $sec6 = TestSection::updateOrCreate(
                ['test_id' => $test->id, 'section_number' => 2],
                [
                    'title' => "PART 6: Text Completion (Test {$testNum})",
                    'passage_text' => <<<HTML
<div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 text-slate-800 space-y-3">
<p class="font-bold text-xs uppercase tracking-wider text-indigo-700">MEMORANDUM: Pacific Rim Logistics</p>
<p><strong>To:</strong> All Regional Warehouse Staff<br><strong>Date:</strong> October 14<br><strong>Subject:</strong> Barcode Scanner Upgrade</p>
<p>Next Monday, our technical division will deploy new laser barcode scanners across all loading docks. The upgraded devices are significantly faster and <strong>(5)</strong> ______ than previous models.</p>
<p>All floor operators must attend a brief twenty-minute instructional orientation. <strong>(6)</strong> ______. Please register for your preferred session on the employee intranet before Friday afternoon.</p>
</div>
HTML
,
                    'translation_vi' => 'Thông báo nội bộ về việc nâng cấp thiết bị quét mã vạch kho hàng.',
                ]
            );
            $grp6 = QuestionGroup::updateOrCreate(
                ['section_id' => $sec6->id],
                [
                    'instruction' => 'Part 6: Read the text and choose the best word or sentence to fill in each blank.',
                    'question_type' => 'multiple_choice_single',
                ]
            );
            $p6Questions = [
                ['num' => 5, 'content' => 'Choose the word that best fits blank (5):', 'correct' => 'B', 'opts' => [['key' => 'A', 'text' => 'light'], ['key' => 'B', 'text' => 'lighter'], ['key' => 'C', 'text' => 'lightest'], ['key' => 'D', 'text' => 'lightly']], 'reason' => 'Cấu trúc so sánh hơn song hành: faster and lighter.'],
                ['num' => 6, 'content' => 'Choose the sentence that best fits blank (6):', 'correct' => 'A', 'opts' => [['key' => 'A', 'text' => 'Sessions will be held in Conference Room B throughout the morning.'], ['key' => 'B', 'text' => 'Old scanners must be thrown into standard waste bins.'], ['key' => 'C', 'text' => 'The warehouse will remain closed indefinitely.'], ['key' => 'D', 'text' => 'All flights to Singapore have been delayed.']], 'reason' => 'Câu A nối tiếp ngữ cảnh thông báo về các buổi hướng dẫn sử dụng.'],
            ];
            foreach ($p6Questions as $q) {
                Question::updateOrCreate(
                    ['group_id' => $grp6->id, 'question_number' => $q['num']],
                    [
                        'content' => $q['content'],
                        'correct_answer' => $q['correct'],
                        'options' => $q['opts'],
                        'evidence_paragraph' => 'Warehouse Memo Paragraph 2',
                        'linearthinking_structure' => 'Discourse coherence',
                        'linearthinking_logic' => $q['reason'],
                        'paraphrase_table' => [],
                    ]
                );
            }

            // Section 3: TOEIC Part 7 - Reading Comprehension
            $sec7 = TestSection::updateOrCreate(
                ['test_id' => $test->id, 'section_number' => 3],
                [
                    'title' => "PART 7: Reading Comprehension (Test {$testNum})",
                    'passage_text' => <<<HTML
<div class="space-y-4 text-slate-800">
<div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs space-y-2">
<span class="text-xs font-bold text-rose-600 uppercase tracking-wide">E-mail Correspondence</span>
<p><strong>From:</strong> Arthur Sterling &lt;a.sterling@sterlingarch.com&gt;<br>
<strong>To:</strong> Jennifer Cho &lt;jcho@metropolistan.org&gt;<br>
<strong>Date:</strong> November 3, 2025<br>
<strong>Subject:</strong> Civic Library Renovation Bid Proposal</p>
<p class="mt-2">Dear Ms. Cho,</p>
<p>On behalf of Sterling Architectural Group, I am pleased to submit our formal tender for the Metropolitan Civic Library renovation project. Enclosed within this package are our structural blueprints, 3D daylight modeling estimates, and a comprehensive breakdown of anticipated material costs totaling $1,450,000.</p>
<p>Having completed four comparable civic restoration endeavors across the province within the past three years, our team is uniquely positioned to deliver sustainable timber retrofitting without exceeding your strict nine-month construction deadline.</p>
<p>We look forward to presenting our vision before the municipal council committee on November 18.</p>
<p class="mt-2 font-medium">Sincerely,<br>Arthur Sterling<br>Managing Partner</p>
</div>
</div>
HTML
,
                    'translation_vi' => 'Thư điện tử nộp hồ sơ dự thầu dự án cải tạo thư viện thành phố.',
                ]
            );
            $grp7 = QuestionGroup::updateOrCreate(
                ['section_id' => $sec7->id],
                [
                    'instruction' => 'Part 7: Read the passage and choose the best answer (A, B, C, or D) for each question.',
                    'question_type' => 'multiple_choice_single',
                ]
            );
            $p7Questions = [
                ['num' => 7, 'content' => 'What is the primary purpose of Mr. Sterling’s e-mail?', 'correct' => 'C', 'opts' => [['key' => 'A', 'text' => 'To request a postponement of a council hearing'], ['key' => 'B', 'text' => 'To notify library patrons about construction closures'], ['key' => 'C', 'text' => 'To submit a commercial renovation bid proposal'], ['key' => 'D', 'text' => 'To order sustainable timber materials']], 'reason' => 'Đoạn 1 nêu rõ: submit our formal tender for the Metropolitan Civic Library renovation project.'],
                ['num' => 8, 'content' => 'What is the estimated budget submitted in the tender?', 'correct' => 'B', 'opts' => [['key' => 'A', 'text' => '$900,000'], ['key' => 'B', 'text' => '$1,450,000'], ['key' => 'C', 'text' => '$3,000,000'], ['key' => 'D', 'text' => '$1,800,000']], 'reason' => 'Đoạn văn nêu số tiền dự toán: totaling $1,450,000.'],
                ['num' => 9, 'content' => 'What timeframe does the firm guarantee for completion?', 'correct' => 'D', 'opts' => [['key' => 'A', 'text' => 'Three weeks'], ['key' => 'B', 'text' => 'Four years'], ['key' => 'C', 'text' => 'Eighteen days'], ['key' => 'D', 'text' => 'Nine months']], 'reason' => 'Đoạn 2 nêu rõ: without exceeding your strict nine-month construction deadline.'],
                ['num' => 10, 'content' => 'When is the project team scheduled to present their proposal?', 'correct' => 'A', 'opts' => [['key' => 'A', 'text' => 'November 18'], ['key' => 'B', 'text' => 'November 3'], ['key' => 'C', 'text' => 'October 14'], ['key' => 'D', 'text' => 'January 1']], 'reason' => 'Đoạn cuối: presenting our vision before the municipal council committee on November 18.'],
            ];
            foreach ($p7Questions as $q) {
                Question::updateOrCreate(
                    ['group_id' => $grp7->id, 'question_number' => $q['num']],
                    [
                        'content' => $q['content'],
                        'correct_answer' => $q['correct'],
                        'options' => $q['opts'],
                        'evidence_paragraph' => 'E-mail Correspondence Lines 3-12',
                        'linearthinking_structure' => 'Business Reading & Fact Extraction',
                        'linearthinking_logic' => $q['reason'],
                        'paraphrase_table' => [],
                    ]
                );
            }
        } else {
            // TOEIC Listening (Part 1 - Photographs, Part 2 - Q&A, Part 3 - Conversations, Part 4 - Talks)
            // Section 1: Part 1 Photographs
            $secL1 = TestSection::updateOrCreate(
                ['test_id' => $test->id, 'section_number' => 1],
                [
                    'title' => "PART 1: Photographs (Test {$testNum})",
                    'passage_text' => '<p class="text-slate-700 font-medium">📷 Hãy quan sát hình ảnh trong đề thi và lắng nghe 4 câu mô tả (A, B, C, D) để chọn câu mô tả chính xác nhất.</p>',
                    'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                    'translation_vi' => 'Phần 1: Nghe 4 câu mô tả và chọn câu đúng nhất cho hình ảnh.',
                ]
            );
            $grpL1 = QuestionGroup::updateOrCreate(
                ['section_id' => $secL1->id],
                [
                    'instruction' => 'Part 1: Listen to the statements and select the statement that best describes what you see in the picture.',
                    'question_type' => 'multiple_choice_single',
                ]
            );
            Question::updateOrCreate(
                ['group_id' => $grpL1->id, 'question_number' => 1],
                [
                    'content' => 'Look at the picture marked No. 1 in your test book and choose the best description:',
                    'correct_answer' => 'A',
                    'options' => [
                        ['key' => 'A', 'text' => '(A) She is reviewing blueprints at a conference table.'],
                        ['key' => 'B', 'text' => '(B) She is boarding an express train.'],
                        ['key' => 'C', 'text' => '(C) She is serving food in a dining area.'],
                        ['key' => 'D', 'text' => '(D) She is repairing an electronic device.']
                    ],
                    'evidence_paragraph' => 'Photograph 1 Action Analysis',
                    'linearthinking_structure' => 'Subject + Action + Object pattern',
                    'linearthinking_logic' => 'Người phụ nữ đang ngồi tại bàn họp xem bản vẽ kỹ thuật.',
                    'paraphrase_table' => [],
                ]
            );

            // Section 2: Part 2 Question-Response
            $secL2 = TestSection::updateOrCreate(
                ['test_id' => $test->id, 'section_number' => 2],
                [
                    'title' => "PART 2: Question - Response (Test {$testNum})",
                    'passage_text' => '<p class="text-slate-700 font-medium">🎧 Lắng nghe câu hỏi hoặc câu nhận định và chọn câu phản hồi phù hợp nhất (A, B, hoặc C).</p>',
                    'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                    'translation_vi' => 'Phần 2: Hỏi - Đáp ngắn gọn trong giao tiếp công sở hằng ngày.',
                ]
            );
            $grpL2 = QuestionGroup::updateOrCreate(
                ['section_id' => $secL2->id],
                [
                    'instruction' => 'Part 2: Listen to the question or statement and choose the best response (A, B, or C).',
                    'question_type' => 'multiple_choice_single',
                ]
            );
            $p2Questions = [
                ['num' => 2, 'content' => 'Where should I submit the finalized quarterly expenditure report?', 'correct' => 'B', 'opts' => [['key' => 'A', 'text' => '(A) Yes, it was reviewed yesterday.'], ['key' => 'B', 'text' => '(B) Directly to Mr. Chen in Accounting on the 4th floor.'], ['key' => 'C', 'text' => '(C) An increase of fifteen percent.']], 'reason' => 'Where hỏi nơi nộp báo cáo -> Chọn phòng ban/người nhận.'],
                ['num' => 3, 'content' => 'When is the international tech conference scheduled to begin?', 'correct' => 'A', 'opts' => [['key' => 'A', 'text' => '(A) Early next month in Singapore.'], ['key' => 'B', 'text' => '(B) In the grand ballroom.'], ['key' => 'C', 'text' => '(C) We already registered forty attendees.']], 'reason' => 'When hỏi mốc thời gian -> Early next month.'],
                ['num' => 4, 'content' => 'Why hasn’t the warehouse shipment arrived yet?', 'correct' => 'C', 'opts' => [['key' => 'A', 'text' => '(A) Twenty wooden pallets.'], ['key' => 'B', 'text' => '(B) At warehouse bay number four.'], ['key' => 'C', 'text' => '(C) Severe weather delayed the cargo flight.']], 'reason' => 'Why hỏi lý do -> Thời tiết xấu làm trễ chuyến bay vận tải.'],
            ];
            foreach ($p2Questions as $q) {
                Question::updateOrCreate(
                    ['group_id' => $grpL2->id, 'question_number' => $q['num']],
                    [
                        'content' => $q['content'],
                        'correct_answer' => $q['correct'],
                        'options' => $q['opts'],
                        'evidence_paragraph' => "Audio Track Part 2 Question {$q['num']}",
                        'linearthinking_structure' => 'Wh- question response matching',
                        'linearthinking_logic' => $q['reason'],
                        'paraphrase_table' => [],
                    ]
                );
            }

            // Section 3: Part 3 Short Conversations
            $secL3 = TestSection::updateOrCreate(
                ['test_id' => $test->id, 'section_number' => 3],
                [
                    'title' => "PART 3: Short Conversations (Test {$testNum})",
                    'passage_text' => '<p class="text-slate-700 font-medium">🎧 Lắng nghe cuộc hội thoại giữa hai hoặc ba người và trả lời 3 câu hỏi cho mỗi đoạn hội thoại.</p>',
                    'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                    'translation_vi' => 'Phần 3: Đoạn hội thoại thương mại nơi công sở.',
                ]
            );
            $grpL3 = QuestionGroup::updateOrCreate(
                ['section_id' => $secL3->id],
                [
                    'instruction' => 'Part 3: Listen to the conversation and choose the best answer for each question.',
                    'question_type' => 'multiple_choice_single',
                ]
            );
            Question::updateOrCreate(
                ['group_id' => $grpL3->id, 'question_number' => 5],
                [
                    'content' => 'What department does the woman most likely work in?',
                    'correct_answer' => 'B',
                    'options' => [
                        ['key' => 'A', 'text' => 'Legal affairs'],
                        ['key' => 'B', 'text' => 'Human resources and recruitment'],
                        ['key' => 'C', 'text' => 'Building maintenance'],
                        ['key' => 'D', 'text' => 'Logistics shipping']
                    ],
                    'evidence_paragraph' => 'Part 3 Conversation (0:30 - 1:15)',
                    'linearthinking_structure' => 'Occupation identification',
                    'linearthinking_logic' => 'Người phụ nữ nhắc đến lịch phỏng vấn và tiếp nhận hồ sơ ứng viên.',
                    'paraphrase_table' => [],
                ]
            );

            // Section 4: Part 4 Short Talks
            $secL4 = TestSection::updateOrCreate(
                ['test_id' => $test->id, 'section_number' => 4],
                [
                    'title' => "PART 4: Short Talks (Test {$testNum})",
                    'passage_text' => '<p class="text-slate-700 font-medium">🎧 Lắng nghe bài nói chuyện ngắn (thông báo chuyến bay, tin nhắn thoại, bài giới thiệu) và trả lời câu hỏi.</p>',
                    'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                    'translation_vi' => 'Phần 4: Độc thoại thông báo truyền thanh hoặc tin nhắn hướng dẫn.',
                ]
            );
            $grpL4 = QuestionGroup::updateOrCreate(
                ['section_id' => $secL4->id],
                [
                    'instruction' => 'Part 4: Listen to the talk and choose the best answer.',
                    'question_type' => 'multiple_choice_single',
                ]
            );
            Question::updateOrCreate(
                ['group_id' => $grpL4->id, 'question_number' => 6],
                [
                    'content' => 'What is the speaker announcing regarding flight departures?',
                    'correct_answer' => 'A',
                    'options' => [
                        ['key' => 'A', 'text' => 'Boarding will now commence at Gate 14'],
                        ['key' => 'B', 'text' => 'Flight tickets have been cancelled'],
                        ['key' => 'C', 'text' => 'Baggage claim has moved to Terminal 2'],
                        ['key' => 'D', 'text' => 'Dinner vouchers are being distributed']
                    ],
                    'evidence_paragraph' => 'Airport Announcement Audio',
                    'linearthinking_structure' => 'Announcement detail matching',
                    'linearthinking_logic' => 'Thông báo tại sân bay: hành khách chuẩn bị lên máy bay tại Cổng số 14.',
                    'paraphrase_table' => [],
                ]
            );
        }
    }

    private function seedIeltsAcademicReadingContent(Test $test, int $vol, int $t): void
    {
        // Passage 1
        $sec1 = TestSection::updateOrCreate(
            ['test_id' => $test->id, 'section_number' => 1],
            [
                'title' => "READING PASSAGE 1: Scientific Breakthroughs & Global Ecosystems (Cam {$vol} Test {$t})",
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Paragraph A:</strong> Modern ecological research indicates that old-growth temperate rainforests sequester significantly more atmospheric carbon per hectare than previously estimated. By analyzing subterranean mycorrhizal fungal networks, botanists have revealed intricate nutrient-sharing mechanisms among disparate tree species.</p>
<p class="mb-4"><strong>Paragraph B:</strong> In addition to carbon sequestration, these ancient biomes regulate regional microclimates by generating atmospheric aerosols that nucleate precipitation. Deforestation in coastal zones disrupts moisture recycling, leading to intensified prolonged droughts inland.</p>
<p class="mb-4"><strong>Paragraph C:</strong> Conservation biologists advocate for establishing unbroken biological corridors between fragmented woodlands to sustain genetic vitality among endangered species.</p>
HTML
,
                'translation_vi' => 'Nghiên cứu khoa học về khả năng hấp thụ carbon và điều hòa vi khí hậu của các khu rừng nguyên sinh cổ xưa.',
            ]
        );
        $grp1 = QuestionGroup::updateOrCreate(
            ['section_id' => $sec1->id],
            [
                'instruction' => 'Passage 1: Do the following statements agree with the information given? Choose TRUE, FALSE, or NOT GIVEN.',
                'question_type' => 'true_false_not_given',
            ]
        );
        $p1Questions = [
            ['num' => 1, 'content' => 'Old-growth temperate rainforests capture more carbon than scientists previously calculated.', 'correct' => 'TRUE', 'reason' => 'Đoạn A: "sequester significantly more atmospheric carbon ... than previously estimated" -> TRUE.'],
            ['num' => 2, 'content' => 'Mycorrhizal fungal networks prevent trees from sharing nutrients with neighboring species.', 'correct' => 'FALSE', 'reason' => 'Đoạn A nêu rõ mạng nấm hỗ trợ cơ chế chia sẻ dưỡng chất (nutrient-sharing) -> FALSE.'],
            ['num' => 3, 'content' => 'Coastal deforestation can cause droughts in inland areas.', 'correct' => 'TRUE', 'reason' => 'Đoạn B: "Deforestation in coastal zones ... leading to intensified prolonged droughts inland" -> TRUE.'],
            ['num' => 4, 'content' => 'Tropical rainforests absorb more carbon per hectare than temperate rainforests.', 'correct' => 'NOT GIVEN', 'reason' => 'Bài đọc không so sánh lượng carbon giữa rừng nhiệt đới và ôn đới -> NOT GIVEN.'],
        ];
        foreach ($p1Questions as $q) {
            Question::updateOrCreate(
                ['group_id' => $grp1->id, 'question_number' => $q['num']],
                [
                    'content' => $q['content'],
                    'correct_answer' => $q['correct'],
                    'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                    'evidence_paragraph' => "Paragraph A/B, Lines 2-5",
                    'linearthinking_structure' => 'S-V-O Core alignment',
                    'linearthinking_logic' => $q['reason'],
                    'paraphrase_table' => [],
                ]
            );
        }

        // Passage 2
        $sec2 = TestSection::updateOrCreate(
            ['test_id' => $test->id, 'section_number' => 2],
            [
                'title' => "READING PASSAGE 2: Urban Transport Evolution & Smart Cities (Cam {$vol} Test {$t})",
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Section A:</strong> Throughout the nineteenth century, rapid industrial urbanization generated unprecedented gridlock in major European capitals. The introduction of subterranean metropolitan railways fundamentally decoupled residential neighborhoods from commercial city centers.</p>
<p class="mb-4"><strong>Section B:</strong> Contemporary urban planners emphasize multimodal transit ecosystems. By integrating autonomous electric feeder buses with high-capacity rail lines, municipalities have curtailed private vehicular dependence and curbed harmful nitrogen dioxide emissions.</p>
<p class="mb-4"><strong>Section C:</strong> Nevertheless, achieving financial viability for expansive transit projects demands sophisticated public-private financing partnerships that safeguard public accountability.</p>
HTML
,
                'translation_vi' => 'Sự phát triển của hệ thống giao thông đô thị và các mô hình thành phố thông minh.',
            ]
        );
        $grp2 = QuestionGroup::updateOrCreate(
            ['section_id' => $sec2->id],
            [
                'instruction' => 'Passage 2: Choose the correct letter, A, B, C, or D.',
                'question_type' => 'multiple_choice_single',
            ]
        );
        $p2Questions = [
            ['num' => 5, 'content' => 'What major breakthrough occurred in 19th-century European capitals?', 'correct' => 'B', 'opts' => [['key' => 'A', 'text' => 'Highways were widened drastically'], ['key' => 'B', 'text' => 'Underground metro lines separated homes from work districts'], ['key' => 'C', 'text' => 'Electric buses replaced all rail networks'], ['key' => 'D', 'text' => 'Private cars were banned completely']], 'reason' => 'Đoạn A: subterranean metropolitan railways fundamentally decoupled residential neighborhoods from commercial city centers.'],
            ['num' => 6, 'content' => 'According to Section B, what is a key benefit of multimodal transit ecosystems?', 'correct' => 'A', 'opts' => [['key' => 'A', 'text' => 'Reduction in private car reliance and emissions'], ['key' => 'B', 'text' => 'Elimination of construction expenses'], ['key' => 'C', 'text' => 'Doubling the distance commuters must walk'], ['key' => 'D', 'text' => 'Higher diesel fuel consumption']], 'reason' => 'Đoạn B: curtailed private vehicular dependence and curbed harmful emissions.'],
        ];
        foreach ($p2Questions as $q) {
            Question::updateOrCreate(
                ['group_id' => $grp2->id, 'question_number' => $q['num']],
                [
                    'content' => $q['content'],
                    'correct_answer' => $q['correct'],
                    'options' => $q['opts'],
                    'evidence_paragraph' => "Passage 2 Section A/B",
                    'linearthinking_structure' => 'Multiple choice keyword deduction',
                    'linearthinking_logic' => $q['reason'],
                    'paraphrase_table' => [],
                ]
            );
        }

        // Passage 3
        $sec3 = TestSection::updateOrCreate(
            ['test_id' => $test->id, 'section_number' => 3],
            [
                'title' => "READING PASSAGE 3: Cognitive Psychology & Behavioral Economics (Cam {$vol} Test {$t})",
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Paragraph I:</strong> Classical neoclassical economics posited that economic agents are ruthlessly rational calculators seeking optimal utility. However, seminal experiments by Daniel Kahneman and Amos Tversky unmasked systemic heuristics and biases governing human decision under uncertainty.</p>
<p class="mb-4"><strong>Paragraph II:</strong> Among these cognitive illusions, loss aversion reigns supreme: individuals perceive the psychological pain of losing an asset twice as intensely as the equivalent pleasure of acquiring it. This asymmetry distorts both investor behavior on financial exchanges and consumer brand choices.</p>
HTML
,
                'translation_vi' => 'Tâm lý học nhận thức và kinh tế học hành vi trong việc đưa ra quyết định.',
            ]
        );
        $grp3 = QuestionGroup::updateOrCreate(
            ['section_id' => $sec3->id],
            [
                'instruction' => 'Passage 3: Do the following statements agree with the claims of the writer? Choose YES, NO, or NOT GIVEN.',
                'question_type' => 'yes_no_not_given',
            ]
        );
        $p3Questions = [
            ['num' => 7, 'content' => 'Neoclassical economic theories assumed all individuals make purely rational financial choices.', 'correct' => 'YES', 'reason' => 'Đoạn I: "posited that economic agents are ruthlessly rational calculators" -> YES.'],
            ['num' => 8, 'content' => 'Loss aversion causes people to feel the pain of a loss more strongly than the pleasure of a gain.', 'correct' => 'YES', 'reason' => 'Đoạn II: "pain of losing an asset twice as intensely as the equivalent pleasure" -> YES.'],
        ];
        foreach ($p3Questions as $q) {
            Question::updateOrCreate(
                ['group_id' => $grp3->id, 'question_number' => $q['num']],
                [
                    'content' => $q['content'],
                    'correct_answer' => $q['correct'],
                    'options' => ['YES', 'NO', 'NOT GIVEN'],
                    'evidence_paragraph' => "Passage 3 Paragraphs I & II",
                    'linearthinking_structure' => 'Writer claim evaluation',
                    'linearthinking_logic' => $q['reason'],
                    'paraphrase_table' => [],
                ]
            );
        }
    }

    private function seedIeltsListeningContent(Test $test, int $vol, int $t): void
    {
        // Section 1
        $sec1 = TestSection::updateOrCreate(
            ['test_id' => $test->id, 'section_number' => 1],
            [
                'title' => "SECTION 1: Campus Library Registration & Guided Tour (Cam {$vol} Test {$t})",
                'passage_text' => '<p class="text-slate-700 font-medium">🎧 Hãy lắng nghe đoạn hội thoại hướng dẫn thủ tục đăng ký thẻ thư viện và chọn câu trả lời chính xác.</p>',
                'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                'translation_vi' => 'Hội thoại Section 1 đăng ký thẻ thư viện và mượn tài liệu học thuật cho sinh viên mới.',
            ]
        );
        $grp1 = QuestionGroup::updateOrCreate(
            ['section_id' => $sec1->id],
            [
                'instruction' => 'Section 1: Listen to the conversation and choose the correct answer (A, B, or C).',
                'question_type' => 'multiple_choice_single',
            ]
        );
        $qData1 = [
            ['num' => 1, 'content' => 'What document must students bring to register for a university library pass?', 'correct' => 'A', 'opts' => [['key' => 'A', 'text' => 'Official student identity card and proof of enrollment'], ['key' => 'B', 'text' => 'Driver’s license only'], ['key' => 'C', 'text' => 'High school graduation diploma']], 'reason' => 'Người hướng dẫn yêu cầu thẻ sinh viên và giấy xác nhận nhập học.'],
            ['num' => 2, 'content' => 'How many books are undergraduate students permitted to borrow concurrently?', 'correct' => 'B', 'opts' => [['key' => 'A', 'text' => '5 books'], ['key' => 'B', 'text' => '10 books'], ['key' => 'C', 'text' => '15 books']], 'reason' => 'Sinh viên đại học được mượn tối đa 10 cuốn cùng lúc.'],
        ];
        foreach ($qData1 as $q) {
            Question::updateOrCreate(
                ['group_id' => $grp1->id, 'question_number' => $q['num']],
                [
                    'content' => $q['content'],
                    'correct_answer' => $q['correct'],
                    'options' => $q['opts'],
                    'evidence_paragraph' => "Audio Section 1 Track",
                    'linearthinking_structure' => 'Factual extraction',
                    'linearthinking_logic' => $q['reason'],
                    'paraphrase_table' => [],
                ]
            );
        }

        // Section 2
        $sec2 = TestSection::updateOrCreate(
            ['test_id' => $test->id, 'section_number' => 2],
            [
                'title' => "SECTION 2: City Botanical Gardens Audio Guide (Cam {$vol} Test {$t})",
                'passage_text' => '<p class="text-slate-700 font-medium">🎧 Lắng nghe bài hướng dẫn du lịch vườn thực vật thành phố và chọn thông tin chính xác.</p>',
                'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                'translation_vi' => 'Bài thuyết minh Section 2 về các khu trưng bày cây thuốc và nhà kính nhiệt đới.',
            ]
        );
        $grp2 = QuestionGroup::updateOrCreate(
            ['section_id' => $sec2->id],
            [
                'instruction' => 'Section 2: Choose the correct answer.',
                'question_type' => 'multiple_choice_single',
            ]
        );
        Question::updateOrCreate(
            ['group_id' => $grp2->id, 'question_number' => 3],
            [
                'content' => 'Where is the medicinal plant sanctuary located within the gardens?',
                'correct_answer' => 'C',
                'options' => [
                    ['key' => 'A', 'text' => 'Next to the main entrance gift shop'],
                    ['key' => 'B', 'text' => 'Behind the visitor parking lot'],
                    ['key' => 'C', 'text' => 'In the south greenhouse adjacent to the lake']
                ],
                'evidence_paragraph' => 'Section 2 Audio (1:15 - 2:00)',
                'linearthinking_structure' => 'Map & location orientation',
                'linearthinking_logic' => 'Khu cây thuốc nằm ở nhà kính phía nam kế bên hồ nước.',
                'paraphrase_table' => [],
            ]
        );
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
