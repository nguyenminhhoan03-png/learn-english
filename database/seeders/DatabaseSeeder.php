<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\DictationSentence;
use App\Models\DictationTopic;
use App\Models\Question;
use App\Models\QuestionGroup;
use App\Models\SpeakingSample;
use App\Models\Test;
use App\Models\TestCategory;
use App\Models\TestSection;
use App\Models\TestSet;
use App\Models\User;
use App\Models\UserFlashcard;
use App\Models\Vocabulary;
use App\Models\WritingSample;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users (Admin & Students)
        $admin = User::firstOrCreate(
            ['email' => 'admin@edulearn.vn'],
            [
                'name' => 'Admin EduLearn',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'target_band' => 8.5,
                'streak_count' => 12,
                'last_study_date' => Carbon::today(),
                'xp_points' => 1450,
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80',
            ]
        );

        $student1 = User::firstOrCreate(
            ['email' => 'student@edulearn.vn'],
            [
                'name' => 'Nguyễn Minh Anh',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'target_band' => 7.5,
                'streak_count' => 7,
                'last_study_date' => Carbon::today(),
                'xp_points' => 820,
                'avatar' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=120&q=80',
            ]
        );

        $student2 = User::firstOrCreate(
            ['email' => 'hoang.nam@gmail.com'],
            [
                'name' => 'Trần Hoàng Nam',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'target_band' => 8.0,
                'streak_count' => 15,
                'last_study_date' => Carbon::today(),
                'xp_points' => 1120,
                'avatar' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=120&q=80',
            ]
        );

        // 2. Seed Test Categories
        $ieltsAcademic = TestCategory::firstOrCreate(
            ['slug' => 'ielts-academic'],
            [
                'name' => 'IELTS Academic',
                'description' => 'Trọn bộ đề thi học thuật chuẩn quốc tế Cambridge IELTS 10 - 19 có chú giải Linearthinking.',
                'icon' => 'book-open',
                'sort_order' => 1,
            ]
        );

        $ieltsGeneral = TestCategory::firstOrCreate(
            ['slug' => 'ielts-general-training'],
            [
                'name' => 'IELTS General Training',
                'description' => 'Bộ đề thi phục vụ định cư và làm việc tại nước ngoài với ngữ cảnh thực tế.',
                'icon' => 'globe',
                'sort_order' => 2,
            ]
        );

        $toeicCategory = TestCategory::firstOrCreate(
            ['slug' => 'toeic-reading-listening'],
            [
                'name' => 'TOEIC ETS 2024',
                'description' => 'Luyện đề TOEIC chuẩn đề thi thật ETS cập nhật mới nhất kèm bẫy phát âm.',
                'icon' => 'award',
                'sort_order' => 3,
            ]
        );

        $actualCategory = TestCategory::firstOrCreate(
            ['slug' => 'ielts-recent-actual-tests'],
            [
                'name' => 'IELTS Recent Actual Tests',
                'description' => 'Tuyển tập đề thi thật tại IDP & British Council mới nhất 2024 - 2025.',
                'icon' => 'zap',
                'sort_order' => 4,
            ]
        );

        // 3. Seed Test Sets
        $cam19Set = TestSet::firstOrCreate(
            ['slug' => 'cambridge-ielts-19-academic'],
            [
                'category_id' => $ieltsAcademic->id,
                'title' => 'Cambridge IELTS 19 (Academic)',
                'description' => 'Bộ đề mới nhất từ Đại học Cambridge, bám sát 100% xu hướng đề thi thật 2024 - 2025.',
                'thumbnail' => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&w=600&q=80',
                'is_free' => true,
                'total_tests' => 4,
            ]
        );

        $cam18Set = TestSet::firstOrCreate(
            ['slug' => 'cambridge-ielts-18-academic'],
            [
                'category_id' => $ieltsAcademic->id,
                'title' => 'Cambridge IELTS 18 (Academic)',
                'description' => 'Bộ đề kinh điển phân tích sâu các dạng bài True/False/NG và Matching Information.',
                'thumbnail' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&w=600&q=80',
                'is_free' => true,
                'total_tests' => 4,
            ]
        );

        $cam17Set = TestSet::firstOrCreate(
            ['slug' => 'cambridge-ielts-17-academic'],
            [
                'category_id' => $ieltsAcademic->id,
                'title' => 'Cambridge IELTS 17 (Academic)',
                'description' => 'Bộ đề chuẩn hóa cấu trúc đề thi với bẫy từ đồng nghĩa Paraphrase nâng cao.',
                'thumbnail' => 'https://images.unsplash.com/photo-1457369804613-52c61a468e7d?auto=format&fit=crop&w=600&q=80',
                'is_free' => true,
                'total_tests' => 4,
            ]
        );

        $actual2025Set = TestSet::firstOrCreate(
            ['slug' => 'ielts-actual-test-vol-2025'],
            [
                'category_id' => $actualCategory->id,
                'title' => 'IELTS Forecast Actual Tests 2025',
                'description' => 'Bộ đề dự đoán đề thi quý 1 & quý 2 năm 2025 có tỉ lệ trúng đề cao.',
                'thumbnail' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=600&q=80',
                'is_free' => true,
                'total_tests' => 6,
            ]
        );

        // 4. Seed Tests & Sections & Linearthinking Questions
        // TEST 1: Cambridge 19 - Test 1 Reading
        $test1 = Test::firstOrCreate(
            ['slug' => 'cambridge-19-test-1-reading'],
            [
                'test_set_id' => $cam19Set->id,
                'title' => 'Cambridge 19 - Test 1 (Reading)',
                'type' => 'reading',
                'duration_minutes' => 60,
                'total_questions' => 40,
                'views_count' => 3840,
            ]
        );

        $sec1 = TestSection::updateOrCreate(
            ['test_id' => $test1->id, 'section_number' => 1],
            [
                'title' => 'READING PASSAGE 1: How Tennis Rackets are Changing the Game',
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Paragraph A:</strong> In recent years, tennis racket technology has undergone a massive transformation. From the traditional wooden frames of the mid-20th century to modern ultra-light carbon composites, the evolution of rackets has drastically altered how players approach the game. Modern materials allow for larger sweet spots, significantly higher ball velocity, and unprecedented levels of topspin.</p>

<p class="mb-4"><strong>Paragraph B:</strong> Aerodynamic design plays a crucial role in modern racket manufacturing. Engineers utilize computational fluid dynamics (CFD) to craft frames that reduce drag during rapid swings. As a result, professional players can swing their rackets with less air resistance, maximizing angular acceleration and imparting heavy spin on the ball without expending additional muscular effort.</p>

<p class="mb-4"><strong>Paragraph C:</strong> Another critical advancement is the introduction of vibration-dampening polymers inside the racket grip. Historically, continuous high-impact ball contact caused severe tendon vibrations, frequently resulting in repetitive strain injuries such as "tennis elbow." Modern polymers absorb up to 40% of harmful vibrations before they reach the player's wrist and forearm, prolonging athletic careers.</p>
HTML
,
                'translation_vi' => 'Đoạn văn phân tích sự thay đổi công nghệ chế tạo vợt tennis từ gỗ sang vật liệu composite carbon và cơ chế giảm chấn.',
            ]
        );

        $group1 = QuestionGroup::updateOrCreate(
            ['section_id' => $sec1->id],
            [
                'instruction' => 'Do the following statements agree with the information given in Reading Passage 1? In boxes 1-3, choose TRUE, FALSE, or NOT GIVEN.',
                'question_type' => 'true_false_not_given',
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $group1->id, 'question_number' => 1],
            [
                'content' => 'Modern carbon composite rackets allow players to generate greater ball velocity than wooden rackets.',
                'correct_answer' => 'TRUE',
                'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                'evidence_paragraph' => 'Paragraph A, Lines 3-5',
                'linearthinking_structure' => 'Chủ ngữ (Modern materials) + Động từ (allow for) + Tân ngữ (higher ball velocity).',
                'linearthinking_logic' => 'Đoạn A khẳng định: "Modern materials allow for ... significantly higher ball velocity" đồng nghĩa với câu hỏi.',
                'paraphrase_table' => [
                    ['question_word' => 'generate greater ball velocity', 'passage_word' => 'allow for significantly higher ball velocity'],
                ],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $group1->id, 'question_number' => 2],
            [
                'content' => 'Aerodynamic designs require players to exert significantly more muscular effort during swings.',
                'correct_answer' => 'FALSE',
                'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                'evidence_paragraph' => 'Paragraph B, Last Sentence',
                'linearthinking_structure' => 'Chủ ngữ (players) + Động từ (can swing with less air resistance) + Trạng từ (without expending additional muscular effort).',
                'linearthinking_logic' => 'Câu hỏi nói "require more muscular effort" mâu thuẫn với bài đọc "without expending additional muscular effort" -> FALSE.',
                'paraphrase_table' => [
                    ['question_word' => 'exert significantly more muscular effort', 'passage_word' => 'without expending additional muscular effort'],
                ],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $group1->id, 'question_number' => 3],
            [
                'content' => 'Carbon composite rackets were first invented in the United Kingdom.',
                'correct_answer' => 'NOT GIVEN',
                'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                'evidence_paragraph' => 'Paragraph A',
                'linearthinking_structure' => 'Không có thông tin về quốc gia sáng chế.',
                'linearthinking_logic' => 'Bài đọc không hề đề cập đến quốc gia hay địa điểm nơi vợt carbon được phát minh đầu tiên -> NOT GIVEN.',
                'paraphrase_table' => [],
            ]
        );

        // TEST 2: Cambridge 19 - Test 2 Reading
        $test2 = Test::updateOrCreate(
            ['slug' => 'cambridge-19-test-2-reading'],
            [
                'test_set_id' => $cam19Set->id,
                'title' => 'Cambridge 19 - Test 2 (Reading)',
                'type' => 'reading',
                'duration_minutes' => 60,
                'total_questions' => 40,
                'views_count' => 2190,
            ]
        );

        $sec2 = TestSection::updateOrCreate(
            ['test_id' => $test2->id, 'section_number' => 1],
            [
                'title' => 'READING PASSAGE 1: The Psychology of Urban Green Spaces',
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Paragraph A:</strong> Urban green spaces, including public parks, botanical gardens, and tree-lined avenues, provide measurable cognitive benefits to city dwellers. Clinical neuroscience studies reveal that exposure to natural environments reduces cortisol levels by 28% within 20 minutes of immersion.</p>
<p class="mb-4"><strong>Paragraph B:</strong> In addition to mental tranquility, biodiverse flora in urban environments actively filters micro-particulate matter (PM2.5), mitigating respiratory conditions among children and senior citizens.</p>
HTML
,
                'translation_vi' => 'Tác động tâm lý và sức khỏe sinh học của không gian xanh đối với cư dân đô thị.',
            ]
        );

        $group2 = QuestionGroup::updateOrCreate(
            ['section_id' => $sec2->id],
            [
                'instruction' => 'Choose TRUE, FALSE, or NOT GIVEN for questions 1-2.',
                'question_type' => 'true_false_not_given',
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $group2->id, 'question_number' => 1],
            [
                'content' => 'Spending time in nature can lower stress hormone levels in human beings.',
                'correct_answer' => 'TRUE',
                'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                'evidence_paragraph' => 'Paragraph A, Sentence 2',
                'linearthinking_structure' => 'S (exposure to nature) + V (reduces) + O (cortisol levels - stress hormone).',
                'linearthinking_logic' => 'Cortisol là hormone gây căng thẳng, việc giảm 28% cortisol tương ứng với "lower stress hormone levels" -> TRUE.',
                'paraphrase_table' => [
                    ['question_word' => 'lower stress hormone levels', 'passage_word' => 'reduces cortisol levels'],
                ],
            ]
        );

        // TEST 3: Cambridge 18 - Test 1 Reading
        $test3 = Test::updateOrCreate(
            ['slug' => 'cambridge-18-test-1-reading'],
            [
                'test_set_id' => $cam18Set->id,
                'title' => 'Cambridge 18 - Test 1 (Reading)',
                'type' => 'reading',
                'duration_minutes' => 60,
                'total_questions' => 40,
                'views_count' => 4520,
            ]
        );

        $sec3 = TestSection::updateOrCreate(
            ['test_id' => $test3->id, 'section_number' => 1],
            [
                'title' => 'READING PASSAGE 1: Urban Transport and Autonomous Mobility in Scandinavia',
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Paragraph A:</strong> The rise of automated transport networks is fundamentally reshaping city infrastructures across Scandinavia. In cities like Oslo and Helsinki, municipal authorities have deployed fleets of zero-emission autonomous shuttles to connect suburban commuters with high-speed commuter rail hubs.</p>
<p class="mb-4"><strong>Paragraph B:</strong> Telemetric sensor arrays, including LiDAR and high-definition optical cameras, allow these vehicles to navigate unpredictable Nordic weather conditions such as sudden blizzards and icy road surfaces with a 99.7% safety reliability rating.</p>
<p class="mb-4"><strong>Paragraph C:</strong> Urban planners report that the shift towards autonomous public transport has reduced private vehicle ownership in central districts by 24%, freeing up former parking lots for public community plazas and pediatric playgrounds.</p>
HTML
,
                'translation_vi' => 'Sự phát triển của mạng lưới giao thông tự hành không phát thải tại các đô thị Bắc Âu giúp giảm xe cá nhân và nâng cao an toàn giao thông.',
            ]
        );

        $group3 = QuestionGroup::updateOrCreate(
            ['section_id' => $sec3->id],
            [
                'instruction' => 'Do the following statements agree with the information given in Reading Passage 1? In boxes 1-3, choose TRUE, FALSE, or NOT GIVEN.',
                'question_type' => 'true_false_not_given',
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $group3->id, 'question_number' => 1],
            [
                'content' => 'Autonomous shuttles in Scandinavian cities operate on zero-emission energy systems.',
                'correct_answer' => 'TRUE',
                'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                'evidence_paragraph' => 'Paragraph A, Sentence 2',
                'linearthinking_structure' => 'S (municipal authorities) + V (deployed) + O (fleets of zero-emission autonomous shuttles).',
                'linearthinking_logic' => 'Đoạn A nêu rõ "zero-emission autonomous shuttles" hoàn toàn trùng khớp với mệnh đề trong câu hỏi -> TRUE.',
                'paraphrase_table' => [
                    ['question_word' => 'operate on zero-emission energy systems', 'passage_word' => 'zero-emission autonomous shuttles'],
                ],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $group3->id, 'question_number' => 2],
            [
                'content' => 'Nordic blizzards have caused autonomous sensors to fail in more than 10% of test runs.',
                'correct_answer' => 'FALSE',
                'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                'evidence_paragraph' => 'Paragraph B, Sentence 1',
                'linearthinking_structure' => 'LiDAR & optical cameras allow vehicles to navigate blizzards with 99.7% safety reliability rating.',
                'linearthinking_logic' => 'Bài đọc khẳng định độ tin cậy an toàn đạt 99.7% (tỉ lệ lỗi chỉ 0.3%), trái ngược với câu hỏi nói tỷ lệ lỗi > 10% -> FALSE.',
                'paraphrase_table' => [
                    ['question_word' => 'fail in more than 10%', 'passage_word' => '99.7% safety reliability rating'],
                ],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $group3->id, 'question_number' => 3],
            [
                'content' => 'Private car ownership increased significantly after autonomous transport was introduced.',
                'correct_answer' => 'FALSE',
                'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                'evidence_paragraph' => 'Paragraph C, Sentence 1',
                'linearthinking_structure' => 'Shift towards autonomous transport has reduced private vehicle ownership by 24%.',
                'linearthinking_logic' => 'Bài đọc nêu "reduced private vehicle ownership by 24%" (giảm 24%), câu hỏi nói "increased significantly" (tăng mạnh) -> FALSE.',
                'paraphrase_table' => [
                    ['question_word' => 'increased significantly', 'passage_word' => 'reduced by 24%'],
                ],
            ]
        );

        // TEST 4: Cambridge 19 - Test 1 Listening
        $test4 = Test::updateOrCreate(
            ['slug' => 'cambridge-19-test-1-listening'],
            [
                'test_set_id' => $cam19Set->id,
                'title' => 'Cambridge 19 - Test 1 (Listening)',
                'type' => 'listening',
                'duration_minutes' => 30,
                'total_questions' => 40,
                'views_count' => 3100,
            ]
        );

        $sec4 = TestSection::updateOrCreate(
            ['test_id' => $test4->id, 'section_number' => 1],
            [
                'title' => 'SECTION 1: Community Art Workshop Registration',
                'passage_text' => '<p class="text-slate-700 italic">🎧 Hãy lắng nghe đoạn ghi âm bên dưới và hoàn thành các câu hỏi từ 1 đến 3 bằng cách chọn đáp án chính xác hoặc điền từ vào chỗ trống.</p>',
                'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                'translation_vi' => 'Đoạn hội thoại đăng ký tham gia lớp học vẽ và nghệ thuật cộng đồng tại trung tâm văn hóa.',
            ]
        );

        $group4 = QuestionGroup::updateOrCreate(
            ['section_id' => $sec4->id],
            [
                'instruction' => 'Choose the correct letter, A, B, or C for questions 1-2.',
                'question_type' => 'multiple_choice_single',
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $group4->id, 'question_number' => 1],
            [
                'content' => 'What type of art class is the customer inquiring about?',
                'correct_answer' => 'B',
                'options' => [
                    ['key' => 'A', 'text' => 'Oil painting for advanced artists'],
                    ['key' => 'B', 'text' => 'Watercolor landscape for beginners'],
                    ['key' => 'C', 'text' => 'Digital illustration with tablets']
                ],
                'evidence_paragraph' => 'Audio Track Section 1 (0:15 - 0:45)',
                'linearthinking_structure' => 'Speaker: "I am looking for a beginner course focusing on watercolor techniques outdoors."',
                'linearthinking_logic' => 'Người nói đăng ký khóa học màu nước cơ bản -> Chọn B.',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $group4->id, 'question_number' => 2],
            [
                'content' => 'On which day of the week does the workshop meet?',
                'correct_answer' => 'A',
                'options' => [
                    ['key' => 'A', 'text' => 'Saturday morning'],
                    ['key' => 'B', 'text' => 'Tuesday evening'],
                    ['key' => 'C', 'text' => 'Sunday afternoon']
                ],
                'evidence_paragraph' => 'Audio Track Section 1 (1:10 - 1:30)',
                'linearthinking_structure' => 'Speaker: "Classes take place every Saturday from 9:00 AM to 11:30 AM."',
                'linearthinking_logic' => 'Lớp học diễn ra sáng thứ Bảy hàng tuần -> Chọn A.',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $group4->id, 'question_number' => 3],
            [
                'content' => 'What materials are participants expected to bring for their first session?',
                'correct_answer' => 'A',
                'options' => [
                    ['key' => 'A', 'text' => 'A basic sketchbook and watercolor pencils'],
                    ['key' => 'B', 'text' => 'Heavy wooden easel and canvas support'],
                    ['key' => 'C', 'text' => 'Professional acrylic tube set']
                ],
                'evidence_paragraph' => 'Audio Track Section 1 (2:00 - 2:20)',
                'linearthinking_structure' => 'Speaker: "All you need on day one is a portable sketchbook and standard watercolor pencils."',
                'linearthinking_logic' => 'Chỉ cần mang theo sổ phác thảo và chì màu nước cơ bản -> Chọn A.',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $group4->id, 'question_number' => 4],
            [
                'content' => 'Where is the studio workshop located?',
                'correct_answer' => 'B',
                'options' => [
                    ['key' => 'A', 'text' => '15 High Street shopping promenade'],
                    ['key' => 'B', 'text' => '42 Riverside Boulevard adjacent to the botanical garden'],
                    ['key' => 'C', 'text' => 'Central Train Station concourse']
                ],
                'evidence_paragraph' => 'Audio Track Section 1 (2:45 - 3:00)',
                'linearthinking_structure' => 'Speaker: "Our main studio is located at 42 Riverside Boulevard, right next to the botanical garden."',
                'linearthinking_logic' => 'Địa chỉ phòng vẽ tại số 42 Riverside Boulevard -> Chọn B.',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $group4->id, 'question_number' => 5],
            [
                'content' => 'What is the discounted early-bird registration fee for full-time students?',
                'correct_answer' => 'C',
                'options' => [
                    ['key' => 'A', 'text' => '£140'],
                    ['key' => 'B', 'text' => '£110'],
                    ['key' => 'C', 'text' => '£85']
                ],
                'evidence_paragraph' => 'Audio Track Section 1 (3:20 - 3:40)',
                'linearthinking_structure' => 'Speaker: "Full-time students qualify for our concessionary rate of £85 per term."',
                'linearthinking_logic' => 'Học phí ưu đãi cho sinh viên là £85 -> Chọn C.',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $group4->id, 'question_number' => 6],
            [
                'content' => 'How can the applicant secure their booking before the course capacity is reached?',
                'correct_answer' => 'A',
                'options' => [
                    ['key' => 'A', 'text' => 'By submitting a £20 deposit on the studio online portal'],
                    ['key' => 'B', 'text' => 'By mailing a signed physical registration form'],
                    ['key' => 'C', 'text' => 'By visiting the reception desk in person on Monday']
                ],
                'evidence_paragraph' => 'Audio Track Section 1 (4:10 - 4:30)',
                'linearthinking_structure' => 'Speaker: "You can lock in your spot by paying a £20 deposit directly through our website."',
                'linearthinking_logic' => 'Đặt cọc £20 trực tiếp trên website để giữ chỗ -> Chọn A.',
                'paraphrase_table' => [],
            ]
        );

        // TEST 5: TOEIC ETS 2024 - Test 1 (Reading Part 5 & 7)
        $toeicSet = TestSet::updateOrCreate(
            ['slug' => 'toeic-ets-2024-practice-set'],
            [
                'category_id' => $toeicCategory->id,
                'title' => 'ETS TOEIC 2024 (Full Practice Set)',
                'description' => 'Bộ đề chuẩn ETS 2024 mới nhất có phân tích bẫy ngữ pháp Part 5 trong 15 giây và đọc quét Part 7.',
                'thumbnail' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=600&q=80',
                'is_free' => true,
                'total_tests' => 4,
            ]
        );

        $testToeic1 = Test::updateOrCreate(
            ['slug' => 'ets-toeic-2024-test-1-reading'],
            [
                'test_set_id' => $toeicSet->id,
                'title' => 'ETS TOEIC 2024 - Test 1 (Reading)',
                'type' => 'reading',
                'duration_minutes' => 75,
                'total_questions' => 40,
                'views_count' => 5210,
            ]
        );

        $secToeic1 = TestSection::updateOrCreate(
            ['test_id' => $testToeic1->id, 'section_number' => 1],
            [
                'title' => 'PART 5 & PART 7: Incomplete Sentences & Business Memo',
                'passage_text' => <<<HTML
<p class="mb-4"><strong>MEMORANDUM: Apex Global Logistics</strong></p>
<p class="mb-4"><strong>To:</strong> All Regional Department Managers</p>
<p class="mb-4"><strong>From:</strong> Sandra Chen, Chief Operations Officer</p>
<p class="mb-4"><strong>Date:</strong> October 14, 2025</p>
<p class="mb-4"><strong>Subject:</strong> Mandatory Transition to Automated Cloud ERP System</p>
<p class="mb-4">Effective November 1, our logistics network will transition from legacy desktop software to the centralized ApexCloud ERP platform. All invoice processing and fleet dispatch operations must be routed exclusively through the new digital dashboard. Department leads must schedule training webinars for their teams before October 28 to avoid supply chain disruptions.</p>
HTML
,
                'translation_vi' => 'Thông báo nội bộ về việc bắt buộc chuyển đổi sang hệ thống quản trị đám mây ERP tự động từ ngày 1/11.',
            ]
        );

        $groupToeic1 = QuestionGroup::updateOrCreate(
            ['section_id' => $secToeic1->id],
            [
                'instruction' => 'Choose the best answer (A, B, C, or D) to complete each sentence or question based on the text.',
                'question_type' => 'multiple_choice_single',
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeic1->id, 'question_number' => 1],
            [
                'content' => 'The revised travel reimbursement policy will become ______ on the first day of next month.',
                'correct_answer' => 'A',
                'options' => [
                    ['key' => 'A', 'text' => 'effective'],
                    ['key' => 'B', 'text' => 'effectively'],
                    ['key' => 'C', 'text' => 'effectiveness'],
                    ['key' => 'D', 'text' => 'effect']
                ],
                'evidence_paragraph' => 'TOEIC Part 5 Grammar Structure',
                'linearthinking_structure' => 'Linking verb (become) + Adjective predicate (effective).',
                'linearthinking_logic' => 'Sau linking verb "become" cần một tính từ chỉ trạng thái -> Chọn A (effective).',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeic1->id, 'question_number' => 2],
            [
                'content' => 'What is the primary deadline for department managers to schedule staff training?',
                'correct_answer' => 'C',
                'options' => [
                    ['key' => 'A', 'text' => 'November 1'],
                    ['key' => 'B', 'text' => 'October 14'],
                    ['key' => 'C', 'text' => 'October 28'],
                    ['key' => 'D', 'text' => 'December 31']
                ],
                'evidence_paragraph' => 'Memo Last Sentence (Lines 6-7)',
                'linearthinking_structure' => 'S (Department leads) + V (must schedule webinars) + Time constraint (before October 28).',
                'linearthinking_logic' => 'Đoạn văn nêu rõ hạn chót tổ chức tập huấn là trước ngày 28/10 -> Chọn C.',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeic1->id, 'question_number' => 3],
            [
                'content' => 'Mr. Henderson requested that all expense reports be submitted ______ Friday afternoon.',
                'correct_answer' => 'A',
                'options' => [
                    ['key' => 'A', 'text' => 'before'],
                    ['key' => 'B', 'text' => 'during'],
                    ['key' => 'C', 'text' => 'between'],
                    ['key' => 'D', 'text' => 'along']
                ],
                'evidence_paragraph' => 'TOEIC Part 5 Preposition Usage',
                'linearthinking_structure' => 'Preposition of deadline + Point in time (Friday afternoon) -> "before".',
                'linearthinking_logic' => 'Giới từ chỉ thời hạn trước một mốc thời gian cụ thể (Friday afternoon) -> Chọn A (before).',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeic1->id, 'question_number' => 4],
            [
                'content' => 'The marketing team worked ______ to ensure the promotional campaign launched on schedule.',
                'correct_answer' => 'B',
                'options' => [
                    ['key' => 'A', 'text' => 'diligent'],
                    ['key' => 'B', 'text' => 'diligently'],
                    ['key' => 'C', 'text' => 'diligence'],
                    ['key' => 'D', 'text' => 'most diligent']
                ],
                'evidence_paragraph' => 'TOEIC Part 5 Adverb Modification',
                'linearthinking_structure' => 'Verb (worked) + Adverb of manner (diligently).',
                'linearthinking_logic' => 'Bổ nghĩa cho động từ thường "worked" cần một trạng từ chỉ cách thức -> Chọn B (diligently).',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeic1->id, 'question_number' => 5],
            [
                'content' => 'According to the memorandum, which software system will replace legacy desktop applications?',
                'correct_answer' => 'A',
                'options' => [
                    ['key' => 'A', 'text' => 'ApexCloud ERP'],
                    ['key' => 'B', 'text' => 'Microsoft Excel Desk'],
                    ['key' => 'C', 'text' => 'Salesforce Express'],
                    ['key' => 'D', 'text' => 'Oracle Database Server']
                ],
                'evidence_paragraph' => 'Memo Sentence 1 (Lines 4-5)',
                'linearthinking_structure' => 'Transition from legacy desktop software to centralized ApexCloud ERP platform.',
                'linearthinking_logic' => 'Đoạn văn nêu rõ hệ thống thay thế là ApexCloud ERP platform -> Chọn A.',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeic1->id, 'question_number' => 6],
            [
                'content' => 'The new manufacturing plant is projected to ______ operational capacity by forty percent.',
                'correct_answer' => 'A',
                'options' => [
                    ['key' => 'A', 'text' => 'increase'],
                    ['key' => 'B', 'text' => 'increasing'],
                    ['key' => 'C', 'text' => 'increased'],
                    ['key' => 'D', 'text' => 'increasingly']
                ],
                'evidence_paragraph' => 'TOEIC Part 5 Infinitive Structure',
                'linearthinking_structure' => 'To-infinitive (to + Verb base form) -> "increase".',
                'linearthinking_logic' => 'Sau "to" trong cấu trúc "is projected to" là động từ nguyên mẫu không chia -> Chọn A (increase).',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeic1->id, 'question_number' => 7],
            [
                'content' => 'Guests staying at the boutique hotel are entitled to ______ high-speed wireless internet access.',
                'correct_answer' => 'A',
                'options' => [
                    ['key' => 'A', 'text' => 'complimentary'],
                    ['key' => 'B', 'text' => 'complement'],
                    ['key' => 'C', 'text' => 'complimenting'],
                    ['key' => 'D', 'text' => 'compliment']
                ],
                'evidence_paragraph' => 'TOEIC Part 5 Business Vocabulary',
                'linearthinking_structure' => 'Adjective (complimentary = miễn phí) + Noun phrase (internet access).',
                'linearthinking_logic' => 'Tính từ thương mại "complimentary" mang nghĩa miễn phí kèm theo dịch vụ -> Chọn A.',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeic1->id, 'question_number' => 8],
            [
                'content' => 'All invoice processing and fleet dispatch operations must be routed ______ through the new digital dashboard.',
                'correct_answer' => 'D',
                'options' => [
                    ['key' => 'A', 'text' => 'exclusive'],
                    ['key' => 'B', 'text' => 'exclusion'],
                    ['key' => 'C', 'text' => 'exclusiveness'],
                    ['key' => 'D', 'text' => 'exclusively']
                ],
                'evidence_paragraph' => 'Memo Sentence 2 (Line 5)',
                'linearthinking_structure' => 'Passive verb (be routed) + Adverb (exclusively) + Prepositional phrase.',
                'linearthinking_logic' => 'Đoạn văn nêu rõ: "must be routed exclusively through the new digital dashboard" -> Chọn D.',
                'paraphrase_table' => [],
            ]
        );

        // TEST 6: IELTS General Training - Test 1 Reading
        $gtSet = TestSet::updateOrCreate(
            ['slug' => 'cambridge-ielts-19-general-training'],
            [
                'category_id' => $ieltsGeneral->id,
                'title' => 'Cambridge IELTS 19 (General Training)',
                'description' => 'Bộ đề General Training chuẩn Cambridge dành cho người chuẩn bị hồ sơ định cư và lao động nước ngoài.',
                'thumbnail' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=80',
                'is_free' => true,
                'total_tests' => 4,
            ]
        );

        $testGt1 = Test::updateOrCreate(
            ['slug' => 'cambridge-19-gt-test-1-reading'],
            [
                'test_set_id' => $gtSet->id,
                'title' => 'Cambridge 19 GT - Test 1 (Reading)',
                'type' => 'reading',
                'duration_minutes' => 60,
                'total_questions' => 40,
                'views_count' => 2940,
            ]
        );

        $secGt1 = TestSection::updateOrCreate(
            ['test_id' => $testGt1->id, 'section_number' => 1],
            [
                'title' => 'SECTION 1: Employee Health and Flexible Working Guidelines',
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Workplace Flexibility Policy:</strong> All full-time employees with at least six months of continuous service are eligible to request hybrid telecommuting arrangements up to two days per week. Requests must be submitted via the HR portal at least two weeks prior to the intended start date.</p>
<p class="mb-4"><strong>Ergonomic Allowance:</strong> Approved remote workers receive a one-off tax-free stipend of $250 to purchase certified ergonomic office chairs or height-adjustable desk converters.</p>
HTML
,
                'translation_vi' => 'Quy định về làm việc linh hoạt kết hợp từ xa và trợ cấp trang thiết bị bàn ghế công thái học cho nhân viên.',
            ]
        );

        $groupGt1 = QuestionGroup::updateOrCreate(
            ['section_id' => $secGt1->id],
            [
                'instruction' => 'Do the following statements agree with the information given in Section 1? Choose TRUE, FALSE, or NOT GIVEN.',
                'question_type' => 'true_false_not_given',
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupGt1->id, 'question_number' => 1],
            [
                'content' => 'New employees can apply for remote working immediately upon joining the company.',
                'correct_answer' => 'FALSE',
                'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                'evidence_paragraph' => 'Paragraph 1, Sentence 1',
                'linearthinking_structure' => 'Condition (with at least six months of continuous service) mâu thuẫn với câu hỏi (immediately upon joining).',
                'linearthinking_logic' => 'Quy định bắt buộc nhân viên phải làm tối thiểu 6 tháng liên tục mới được đăng ký -> FALSE.',
                'paraphrase_table' => [],
            ]
        );

        // TEST 7: IELTS Forecast 2025 Test
        $testActual1 = Test::updateOrCreate(
            ['slug' => 'ielts-forecast-2025-test-1-reading'],
            [
                'test_set_id' => $actual2025Set->id,
                'title' => 'IELTS Forecast 2025 - Test 1 (Reading)',
                'type' => 'reading',
                'duration_minutes' => 60,
                'total_questions' => 40,
                'views_count' => 6100,
            ]
        );

        $secActual1 = TestSection::updateOrCreate(
            ['test_id' => $testActual1->id, 'section_number' => 1],
            [
                'title' => 'READING PASSAGE 1: Quantum Computing in Early Cancer Diagnostics',
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Paragraph A:</strong> Quantum annealing algorithms have demonstrated unprecedented speed in analyzing sub-cellular genetic mutations. By evaluating billions of protein folding permutations simultaneously, quantum processors identify anomalous oncological patterns years before conventional MRI scans can detect physical tumors.</p>
<p class="mb-4"><strong>Paragraph B:</strong> Leading oncology clinics in Zurich and Boston have commenced phase-three clinical trials integrating quantum molecular modeling with personalized immunotherapy treatments, boosting five-year remission rates to 88%.</p>
HTML
,
                'translation_vi' => 'Ứng dụng thuật toán điện toán lượng tử trong việc phát hiện sớm đột biến gen gây ung thư trước khi xuất hiện khối u.',
            ]
        );

        $groupActual1 = QuestionGroup::updateOrCreate(
            ['section_id' => $secActual1->id],
            [
                'instruction' => 'Choose TRUE, FALSE, or NOT GIVEN for questions 1-2.',
                'question_type' => 'true_false_not_given',
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupActual1->id, 'question_number' => 1],
            [
                'content' => 'Quantum processors can detect cancer markers before standard MRI equipment is able to spot tumors.',
                'correct_answer' => 'TRUE',
                'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                'evidence_paragraph' => 'Paragraph A, Sentence 2',
                'linearthinking_structure' => 'S (quantum processors) + V (identify patterns) + Time advantage (years before MRI scans).',
                'linearthinking_logic' => 'Bài đọc khẳng định phát hiện trước nhiều năm so với chụp MRI truyền thống -> TRUE.',
                'paraphrase_table' => [],
            ]
        );

        // TEST 8: TOEIC ETS 2024 - Test 1 (Full Listening Parts 1 - 3)
        $testToeicListen1 = Test::updateOrCreate(
            ['slug' => 'ets-toeic-2024-test-1-listening'],
            [
                'test_set_id' => $toeicSet->id,
                'title' => 'ETS TOEIC 2024 - Test 1 (Listening)',
                'type' => 'listening',
                'duration_minutes' => 45,
                'total_questions' => 14,
                'views_count' => 4120,
            ]
        );

        // Section 1: Part 1 Photographs
        $secToeicListen1 = TestSection::updateOrCreate(
            ['test_id' => $testToeicListen1->id, 'section_number' => 1],
            [
                'title' => 'PART 1: Photographs (Miêu Tả Hình Ảnh Công Sở)',
                'passage_text' => <<<HTML
<div class="space-y-4">
    <p class="text-slate-700 font-medium leading-relaxed">🎧 <strong>Hướng dẫn Part 1:</strong> Bạn sẽ nghe 4 câu miêu tả về mỗi bức tranh. Hãy chọn câu miêu tả chính xác nhất những gì bạn thấy trong ảnh.</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="p-3 bg-slate-50 border border-slate-200 rounded-2xl">
            <span class="text-xs font-bold text-slate-500 uppercase block mb-1">Bức Tranh 1: Phòng họp chiến lược</span>
            <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&w=600&q=80" alt="Office Meeting" class="w-full h-40 object-cover rounded-xl shadow-xs">
        </div>
        <div class="p-3 bg-slate-50 border border-slate-200 rounded-2xl">
            <span class="text-xs font-bold text-slate-500 uppercase block mb-1">Bức Tranh 2: Kho vận chuyển hàng</span>
            <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=600&q=80" alt="Warehouse Logistics" class="w-full h-40 object-cover rounded-xl shadow-xs">
        </div>
    </div>
</div>
HTML
,
                'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                'translation_vi' => 'Phần thi Part 1 kiểm tra khả năng nghe hiểu và nhận diện hành động, vị trí của đồ vật trong tranh.',
            ]
        );

        $groupToeicListen1 = QuestionGroup::updateOrCreate(
            ['section_id' => $secToeicListen1->id],
            [
                'instruction' => 'For each question, listen to the 4 statements (A, B, C, D) and select the one that best describes the picture.',
                'question_type' => 'multiple_choice_single',
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeicListen1->id, 'question_number' => 1],
            [
                'content' => 'Look at the picture marked No. 1 in your test book (Strategic Office Meeting).',
                'correct_answer' => 'A',
                'options' => [
                    ['key' => 'A', 'text' => '(A) They are presenting a financial chart on the screen.'],
                    ['key' => 'B', 'text' => '(B) They are walking outside the lobby entrance.'],
                    ['key' => 'C', 'text' => '(C) They are taking off their winter coats.'],
                    ['key' => 'D', 'text' => '(D) They are repairing a broken laser printer.']
                ],
                'evidence_paragraph' => 'Audio Track Part 1 (Picture 1)',
                'linearthinking_structure' => 'Subject (They) + Action (presenting a chart on the screen) matches photo.',
                'linearthinking_logic' => 'Hình ảnh thể hiện các nhân viên đang thảo luận trước màn hình biểu đồ -> Chọn A.',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeicListen1->id, 'question_number' => 2],
            [
                'content' => 'Look at the picture marked No. 2 in your test book (Warehouse Storage Facility).',
                'correct_answer' => 'A',
                'options' => [
                    ['key' => 'A', 'text' => '(A) Cardboard boxes are stacked neatly on wooden pallets.'],
                    ['key' => 'B', 'text' => '(B) Vehicles are parked along the pedestrian sidewalk.'],
                    ['key' => 'C', 'text' => '(C) Merchandise is being loaded directly onto a cargo ship.'],
                    ['key' => 'D', 'text' => '(D) The warehouse shelves are completely empty.']
                ],
                'evidence_paragraph' => 'Audio Track Part 1 (Picture 2)',
                'linearthinking_structure' => 'Passive state (Boxes are stacked on wooden pallets) matches picture.',
                'linearthinking_logic' => 'Hình ảnh kho hàng có các thùng carton xếp ngăn nắp trên kệ gỗ -> Chọn A.',
                'paraphrase_table' => [],
            ]
        );

        // Section 2: Part 2 Question-Response
        $secToeicListen2 = TestSection::updateOrCreate(
            ['test_id' => $testToeicListen1->id, 'section_number' => 2],
            [
                'title' => 'PART 2: Question-Response (Hỏi - Đáp Thương Mại 1-Chạm)',
                'passage_text' => '<p class="text-slate-700 font-medium leading-relaxed">🎧 <strong>Hướng dẫn Part 2:</strong> Bạn sẽ nghe một câu hỏi hoặc câu phát biểu ngắn, theo sau là ba phương án trả lời (A, B, C). Hãy chọn câu phản hồi hợp lý nhất.</p>',
                'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                'translation_vi' => 'Phần thi Part 2 luyện phản xạ hỏi đáp thương mại nhanh không có đề in sẵn.',
            ]
        );

        $groupToeicListen2 = QuestionGroup::updateOrCreate(
            ['section_id' => $secToeicListen2->id],
            [
                'instruction' => 'Listen to the question or statement and choose the best response (A, B, or C).',
                'question_type' => 'multiple_choice_single',
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeicListen2->id, 'question_number' => 3],
            [
                'content' => 'Where should I submit the revised quarterly budget proposal?',
                'correct_answer' => 'B',
                'options' => [
                    ['key' => 'A', 'text' => '(A) Yes, it was approved by the board yesterday.'],
                    ['key' => 'B', 'text' => '(B) Directly to Ms. Alvarez in the Accounting Department.'],
                    ['key' => 'C', 'text' => '(C) About twenty-five percent increase over last year.']
                ],
                'evidence_paragraph' => 'Audio Track Part 2 (Question 3)',
                'linearthinking_structure' => 'Where question requires a location/recipient -> Option B matches.',
                'linearthinking_logic' => 'Câu hỏi "Where" cần câu trả lời chỉ địa điểm hoặc người tiếp nhận -> Chọn B.',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeicListen2->id, 'question_number' => 4],
            [
                'content' => 'Why hasn’t the shipment of printer toner arrived yet?',
                'correct_answer' => 'A',
                'options' => [
                    ['key' => 'A', 'text' => '(A) The delivery van was caught in highway traffic.'],
                    ['key' => 'B', 'text' => '(B) In the supply cabinet on the third floor.'],
                    ['key' => 'C', 'text' => '(C) We ordered thirty reams of standard paper.']
                ],
                'evidence_paragraph' => 'Audio Track Part 2 (Question 4)',
                'linearthinking_structure' => 'Why question requires reason -> Option A explains traffic delay.',
                'linearthinking_logic' => 'Câu hỏi "Why" hỏi lý do chậm trễ -> Chọn A (giao hàng bị kẹt xe).',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeicListen2->id, 'question_number' => 5],
            [
                'content' => 'Who is in charge of organizing the upcoming corporate team-building retreat?',
                'correct_answer' => 'C',
                'options' => [
                    ['key' => 'A', 'text' => '(A) At the seaside resort in Da Nang.'],
                    ['key' => 'B', 'text' => '(B) Next Friday morning at eight o’clock.'],
                    ['key' => 'C', 'text' => '(C) Mr. Davis and the human resources team.']
                ],
                'evidence_paragraph' => 'Audio Track Part 2 (Question 5)',
                'linearthinking_structure' => 'Who question requires person/committee -> Option C.',
                'linearthinking_logic' => 'Câu hỏi "Who" hỏi ai phụ trách -> Chọn C (Mr. Davis và phòng nhân sự).',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeicListen2->id, 'question_number' => 6],
            [
                'content' => 'Would you prefer to review the partnership contract now or after lunch?',
                'correct_answer' => 'B',
                'options' => [
                    ['key' => 'A', 'text' => '(A) I already had a tuna sandwich for breakfast.'],
                    ['key' => 'B', 'text' => '(B) Let’s examine it together right after we finish eating.'],
                    ['key' => 'C', 'text' => '(C) The contract signature is at the bottom.']
                ],
                'evidence_paragraph' => 'Audio Track Part 2 (Question 6)',
                'linearthinking_structure' => 'Choice question (now or after lunch) -> Option B picks after eating.',
                'linearthinking_logic' => 'Câu hỏi lựa chọn thời điểm -> Chọn B (sau khi ăn xong).',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeicListen2->id, 'question_number' => 7],
            [
                'content' => 'Didn’t you attend the advanced cloud architecture seminar last Thursday?',
                'correct_answer' => 'A',
                'options' => [
                    ['key' => 'A', 'text' => '(A) No, I was visiting an offshore client facility.'],
                    ['key' => 'B', 'text' => '(B) Yes, the server room has been renovated.'],
                    ['key' => 'C', 'text' => '(C) Every Thursday afternoon at two.']
                ],
                'evidence_paragraph' => 'Audio Track Part 2 (Question 7)',
                'linearthinking_structure' => 'Negative question -> Option A provides direct explanation of absence.',
                'linearthinking_logic' => 'Giải thích lý do không đi dự hội thảo -> Chọn A (bận đi công tác gặp khách hàng).',
                'paraphrase_table' => [],
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupToeicListen2->id, 'question_number' => 8],
            [
                'content' => 'How much is the surcharge for international priority express courier shipping?',
                'correct_answer' => 'B',
                'options' => [
                    ['key' => 'A', 'text' => '(A) It usually arrives within two business days.'],
                    ['key' => 'B', 'text' => '(B) It is an additional twenty-five dollars per parcel.'],
                    ['key' => 'C', 'text' => '(C) To our branch office in Frankfurt, Germany.']
                ],
                'evidence_paragraph' => 'Audio Track Part 2 (Question 8)',
                'linearthinking_structure' => 'How much question requires price/fee -> Option B.',
                'linearthinking_logic' => 'Câu hỏi "How much" hỏi chi phí phát sinh -> Chọn B ($25/kiện).',
                'paraphrase_table' => [],
            ]
        );

        // TEST 9: Cambridge 17 Academic - Test 1 Reading
        $testCam17_1 = Test::updateOrCreate(
            ['slug' => 'cambridge-17-test-1-reading'],
            [
                'test_set_id' => $cam17Set->id,
                'title' => 'Cambridge 17 - Test 1 (Reading)',
                'type' => 'reading',
                'duration_minutes' => 60,
                'total_questions' => 40,
                'views_count' => 3950,
            ]
        );

        $secCam17_1 = TestSection::updateOrCreate(
            ['test_id' => $testCam17_1->id, 'section_number' => 1],
            [
                'title' => 'READING PASSAGE 1: The Development of the London Underground',
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Paragraph A:</strong> In the first half of the 19th century, London experienced explosive demographic expansion. By 1850, horse-drawn omnibuses and horse carriages clogged the city center, resulting in crippling gridlock. Charles Pearson, a visionary City solicitor, proposed an audacious subterranean railway network to alleviate urban congestion.</p>
<p class="mb-4"><strong>Paragraph B:</strong> The Metropolitan Railway opened in January 1863, utilizing steam locomotives with water-condensation condensing systems to mitigate subterranean smoke accumulation. Over 30,000 passengers rode the line on its inaugural operating day.</p>
HTML
,
                'translation_vi' => 'Lịch sử hình thành và phát triển của tuyến tàu điện ngầm đầu tiên trên thế giới tại London năm 1863.',
            ]
        );

        $groupCam17_1 = QuestionGroup::updateOrCreate(
            ['section_id' => $secCam17_1->id],
            [
                'instruction' => 'Do the following statements agree with the information in Reading Passage 1? Choose TRUE, FALSE, or NOT GIVEN.',
                'question_type' => 'true_false_not_given',
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupCam17_1->id, 'question_number' => 1],
            [
                'content' => 'Charles Pearson proposed an underground railway to solve traffic congestion in 19th-century London.',
                'correct_answer' => 'TRUE',
                'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                'evidence_paragraph' => 'Paragraph A, Sentence 3',
                'linearthinking_structure' => 'S (Charles Pearson) + V (proposed subterranean railway) + Purpose (to alleviate urban congestion).',
                'linearthinking_logic' => 'Nội dung bài đọc nêu rõ mục đích của Charles Pearson là giảm ùn tắc giao thông đô thị -> TRUE.',
                'paraphrase_table' => [
                    ['question_word' => 'underground railway', 'passage_word' => 'subterranean railway network'],
                    ['question_word' => 'solve traffic congestion', 'passage_word' => 'alleviate urban congestion'],
                ],
            ]
        );

        // TEST 10: Cambridge 18 Academic - Test 2 Reading
        $testCam18_2 = Test::updateOrCreate(
            ['slug' => 'cambridge-18-test-2-reading'],
            [
                'test_set_id' => $cam18Set->id,
                'title' => 'Cambridge 18 - Test 2 (Reading)',
                'type' => 'reading',
                'duration_minutes' => 60,
                'total_questions' => 40,
                'views_count' => 2870,
            ]
        );

        $secCam18_2 = TestSection::updateOrCreate(
            ['test_id' => $testCam18_2->id, 'section_number' => 1],
            [
                'title' => 'READING PASSAGE 1: Roman Civil Engineering and Aqueduct Systems',
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Paragraph A:</strong> Ancient Roman hydraulic engineers constructed vast aqueduct networks spanning thousands of kilometers across the Mediterranean basin. Utilizing the natural force of gravity, these stone channels maintained subtle downward gradients of less than 0.2%, transporting potable alpine water into metropolitan public bathhouses and fountains.</p>
<p class="mb-4"><strong>Paragraph B:</strong> The durability of Roman concrete, formulated by blending volcanic pozzolana ash with slaked lime, enabled underwater curing and seismic resilience that modern Portland cements struggle to replicate.</p>
HTML
,
                'translation_vi' => 'Kỹ thuật thủy lực và bí quyết chế tạo bê tông núi lửa siêu bền của người La Mã cổ đại.',
            ]
        );

        $groupCam18_2 = QuestionGroup::updateOrCreate(
            ['section_id' => $secCam18_2->id],
            [
                'instruction' => 'Choose TRUE, FALSE, or NOT GIVEN for questions 1-2.',
                'question_type' => 'true_false_not_given',
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupCam18_2->id, 'question_number' => 1],
            [
                'content' => 'Roman aqueducts relied primarily on mechanical water pumps to move water.',
                'correct_answer' => 'FALSE',
                'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                'evidence_paragraph' => 'Paragraph A, Sentence 2',
                'linearthinking_structure' => 'Mechanism (natural force of gravity) mâu thuẫn với câu hỏi (mechanical water pumps).',
                'linearthinking_logic' => 'Hệ thống dẫn nước La Mã tận dụng trọng lực tự nhiên và độ dốc thoải, không dùng máy bơm cơ học -> FALSE.',
                'paraphrase_table' => [],
            ]
        );

        // TEST 11: Cambridge 19 General Training - Test 2 Reading
        $testGt2 = Test::updateOrCreate(
            ['slug' => 'cambridge-19-gt-test-2-reading'],
            [
                'test_set_id' => $gtSet->id,
                'title' => 'Cambridge 19 GT - Test 2 (Reading)',
                'type' => 'reading',
                'duration_minutes' => 60,
                'total_questions' => 40,
                'views_count' => 1890,
            ]
        );

        $secGt2 = TestSection::updateOrCreate(
            ['test_id' => $testGt2->id, 'section_number' => 1],
            [
                'title' => 'SECTION 1: Public Library Digital Loan Services & Community Workshops',
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Digital Media Borrowing:</strong> Registered library cardholders may borrow up to six audiobooks and ten e-books simultaneously via the CloudLibrary smartphone application. Loans automatically expire after 21 calendar days, precluding any late return fines.</p>
<p class="mb-4"><strong>Meeting Room Bookings:</strong> Community non-profit organizations can reserve soundproof workshop rooms free of charge for up to three hours per session, provided reservations are made at least 48 hours in advance.</p>
HTML
,
                'translation_vi' => 'Quy chế mượn sách điện tử kỹ thuật số và đăng ký phòng hội thảo cộng đồng miễn phí tại thư viện.',
            ]
        );

        $groupGt2 = QuestionGroup::updateOrCreate(
            ['section_id' => $secGt2->id],
            [
                'instruction' => 'Do the following statements agree with the text? Choose TRUE, FALSE, or NOT GIVEN.',
                'question_type' => 'true_false_not_given',
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupGt2->id, 'question_number' => 1],
            [
                'content' => 'Borrowers are charged late fines if they forget to return digital e-books.',
                'correct_answer' => 'FALSE',
                'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                'evidence_paragraph' => 'Paragraph 1, Sentence 2',
                'linearthinking_structure' => 'Loans automatically expire -> precluding (preventing) late return fines.',
                'linearthinking_logic' => 'Sách tự động hết hạn và thu hồi trên app nên không bao giờ bị phạt tiền trả muộn -> FALSE.',
                'paraphrase_table' => [],
            ]
        );

        // TEST 12: IELTS Forecast 2025 - Test 2 Reading
        $testActual2 = Test::updateOrCreate(
            ['slug' => 'ielts-forecast-2025-test-2-reading'],
            [
                'test_set_id' => $actual2025Set->id,
                'title' => 'IELTS Forecast 2025 - Test 2 (Reading)',
                'type' => 'reading',
                'duration_minutes' => 60,
                'total_questions' => 40,
                'views_count' => 4820,
            ]
        );

        $secActual2 = TestSection::updateOrCreate(
            ['test_id' => $testActual2->id, 'section_number' => 1],
            [
                'title' => 'READING PASSAGE 1: Autonomous Submersibles and Deep-Sea Marine Biology',
                'passage_text' => <<<HTML
<p class="mb-4"><strong>Paragraph A:</strong> Robotic unmanned submersibles deployed in the Mariana Trench have discovered thriving benthic ecosystems powered by hydrothermal vent chemosynthesis. Unlike surface organisms dependent on solar photosynthesis, these organisms derive metabolic energy from hydrogen sulfide and methane emissions.</p>
<p class="mb-4"><strong>Paragraph B:</strong> Marine microbiologists believe studying these extremophiles will illuminate potential biological pathways for life on ice-covered planetary moons such as Jupiter’s Europa and Saturn’s Enceladus.</p>
HTML
,
                'translation_vi' => 'Khám phá hệ sinh thái biển sâu đáy rãnh Mariana bằng tàu lặn tự hành và tiềm năng sinh học ngoài vũ trụ.',
            ]
        );

        $groupActual2 = QuestionGroup::updateOrCreate(
            ['section_id' => $secActual2->id],
            [
                'instruction' => 'Choose TRUE, FALSE, or NOT GIVEN for question 1.',
                'question_type' => 'true_false_not_given',
            ]
        );

        Question::updateOrCreate(
            ['group_id' => $groupActual2->id, 'question_number' => 1],
            [
                'content' => 'Deep-sea hydrothermal organisms rely primarily on sunlight for metabolic energy.',
                'correct_answer' => 'FALSE',
                'options' => ['TRUE', 'FALSE', 'NOT GIVEN'],
                'evidence_paragraph' => 'Paragraph A, Sentence 1',
                'linearthinking_structure' => 'Energy source (hydrogen sulfide and methane chemosynthesis) contradicts sunlight.',
                'linearthinking_logic' => 'Sinh vật rãnh Mariana sống nhờ hóa tổng hợp từ khí metan và lưu huỳnh, không phụ thuộc ánh sáng mặt trời -> FALSE.',
                'paraphrase_table' => [],
            ]
        );

        // 5. Seed Dictation Topics & Timestamped Sentences
        $dict1 = DictationTopic::firstOrCreate(
            ['slug' => 'the-art-of-public-speaking'],
            [
                'title' => 'TED: The Secret Structure of Great Talks',
                'level' => 'intermediate',
                'category' => 'TED Talks & Public Speaking',
                'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                'duration_seconds' => 120,
                'thumbnail' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&w=600&q=80',
                'total_sentences' => 3,
            ]
        );

        DictationSentence::firstOrCreate(
            ['topic_id' => $dict1->id, 'sentence_order' => 1],
            [
                'audio_start_time' => 0.00,
                'audio_end_time' => 5.20,
                'original_text' => 'Good communication is the most powerful tool for spreading impactful ideas.',
                'translation_vi' => 'Giao tiếp tốt là công cụ mạnh mẽ nhất để lan tỏa những ý tưởng có sức ảnh hưởng.',
                'phonetic_notes' => 'Nối âm: /gʊd kəˌmjuːnɪˈkeɪʃən ɪz ðə moʊst ˈpaʊərfəl tuːl/',
            ]
        );

        DictationSentence::firstOrCreate(
            ['topic_id' => $dict1->id, 'sentence_order' => 2],
            [
                'audio_start_time' => 5.21,
                'audio_end_time' => 10.50,
                'original_text' => 'When you share a compelling story, your audience naturally connects with your message.',
                'translation_vi' => 'Khi bạn chia sẻ một câu chuyện lôi cuốn, khán giả sẽ tự nhiên kết nối với thông điệp của bạn.',
                'phonetic_notes' => 'Trọng âm từ: com-PEL-ling, AU-di-ence.',
            ]
        );

        DictationSentence::firstOrCreate(
            ['topic_id' => $dict1->id, 'sentence_order' => 3],
            [
                'audio_start_time' => 10.51,
                'audio_end_time' => 16.00,
                'original_text' => 'Clarity and empathy are essential pillars of persuasive leadership.',
                'translation_vi' => 'Sự rõ ràng và thấu cảm là hai trụ cột thiết yếu của một nhà lãnh đạo có sức thuyết phục.',
                'phonetic_notes' => 'Nuốt âm: /d/ trong "and" trước nguyên âm /e/.',
            ]
        );

        $dict2 = DictationTopic::firstOrCreate(
            ['slug' => 'artificial-intelligence-in-education'],
            [
                'title' => 'BBC Learning: How AI is Personalizing Classroom Education',
                'level' => 'beginner',
                'category' => 'Technology & Education',
                'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                'duration_seconds' => 95,
                'thumbnail' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=600&q=80',
                'total_sentences' => 2,
            ]
        );

        DictationSentence::firstOrCreate(
            ['topic_id' => $dict2->id, 'sentence_order' => 1],
            [
                'audio_start_time' => 0.00,
                'audio_end_time' => 4.80,
                'original_text' => 'Adaptive learning algorithms customize lessons to fit each student pace.',
                'translation_vi' => 'Các thuật toán học tập thích ứng cá nhân hóa bài giảng để phù hợp với tốc độ của từng học sinh.',
                'phonetic_notes' => 'Âm đuôi: /s/ trong "lessons" và "pace".',
            ]
        );

        // 6. Seed Writing Samples (Band 8.0 - 8.5)
        WritingSample::firstOrCreate(
            ['slug' => 'global-environmental-crisis-individual-responsibility'],
            [
                'title' => 'Global Environmental Crisis & Individual Responsibility',
                'task_type' => 'task2',
                'chart_or_essay_type' => 'Opinion Essay (Discuss Both Views)',
                'band_score' => 8.5,
                'prompt' => 'Some people believe that individuals can do little to improve the environment, while others believe that governments and large corporations should take major action. Discuss both views and give your opinion.',
                'outline_linearthinking' => <<<TEXT
- Introduction: Paraphrase prompt + State thesis (both parties must collaborate synergistically).
- Body 1 (Corporate & Governmental power): Large-scale systemic policies, carbon taxation, renewable subsidies provide fundamental structural shifts.
- Body 2 (Individual responsibility): Consumer purchasing power drives market demand; collective behavioral changes force corporate compliance.
- Conclusion: Restate stance emphasizing mutual dependency between policy and civic habits.
TEXT
,
                'sample_essay' => <<<TEXT
The escalating severity of global ecological degradation has sparked heated debate regarding where the primary onus of environmental stewardship lies. While some contend that solitary individual initiatives are insignificant compared to the sweeping legislative power of governments and transnational corporations, I maintain that meaningful remediation necessitates a reciprocal synergy between systemic regulation and conscientious civic behavior.

On the one hand, state authorities and industrial enterprises possess unparalleled regulatory and financial leverage. Governments can enforce stringent carbon caps, levy environmental taxes on high-polluting sectors, and heavily subsidize green infrastructure such as wind and solar grids. Concurrently, large corporations hold the capital required to re-engineer global supply chains toward sustainable circular economies. Without such structural interventions, localized grassroots efforts risk being overwhelmed by industrial emissions.

On the other hand, dismissing individual agency overlooks the profound market dynamics driven by consumer behavior. When populations collectively pivot toward zero-waste lifestyles and boycotts of unsustainable brands, corporations are economically compelled to reform their manufacturing practices. Furthermore, civic pressure directly shapes democratic policy agendas, illustrating that institutional change is fundamentally catalyzed by proactive citizens.

In conclusion, environmental preservation cannot succeed as a unilateral endeavor. While governments must lay the regulatory framework, individuals must actively animate these policies through conscious consumption and collective advocacy.
TEXT
,
                'translation_vi' => 'Bài luận phân tích trách nhiệm song hành giữa chính phủ, doanh nghiệp và hành vi tiêu dùng cá nhân trong bảo vệ môi trường.',
                'key_vocab_list' => [
                    ['word' => 'ecological degradation', 'meaning' => 'suy thoái sinh thái môi trường'],
                    ['word' => 'reciprocal synergy', 'meaning' => 'sự cộng hưởng hỗ trợ lẫn nhau'],
                    ['word' => 'stringent carbon caps', 'meaning' => 'hạn mức khí thải carbon nghiêm ngặt'],
                    ['word' => 'unilateral endeavor', 'meaning' => 'nỗ lực đơn phương từ một phía'],
                ],
            ]
        );

        WritingSample::firstOrCreate(
            ['slug' => 'renewable-energy-transition-in-5-european-nations'],
            [
                'title' => 'Renewable Energy Transition in 5 European Nations',
                'task_type' => 'task1_academic',
                'chart_or_essay_type' => 'Bar Chart',
                'band_score' => 8.0,
                'prompt' => 'The chart illustrates the percentage of electricity generated from renewable energy sources across five European countries between 2010 and 2020.',
                'outline_linearthinking' => "- Overview: All five nations recorded upward trajectories, with Germany consistently leading.\n- Grouping 1: Germany and Denmark (high performers).\n- Grouping 2: France, Spain, and Italy (moderate growth).",
                'sample_essay' => 'The bar graph delineates the proportion of electricity produced via renewable energy sources in five European nations over a ten-year timeframe from 2010 to 2020. Overall, a pervasive upward trajectory was evident across all surveyed countries with Germany demonstrating dominant output throughout the decade.',
                'translation_vi' => 'Bài viết biểu đồ cột miêu tả tỉ lệ điện tái tạo tại 5 quốc gia châu Âu giai đoạn 2010 - 2020.',
                'key_vocab_list' => [
                    ['word' => 'upward trajectory', 'meaning' => 'xu hướng đi lên'],
                    ['word' => 'delineate', 'meaning' => 'mô tả, phác họa rõ ràng'],
                ],
            ]
        );

        // 7. Seed Speaking Samples (Part 1, 2, 3)
        SpeakingSample::firstOrCreate(
            ['slug' => 'describe-a-memorable-journey-you-took-with-family'],
            [
                'title' => 'Describe a Memorable Journey with Family (Band 8.5)',
                'part' => 'part2',
                'topic' => 'Travel & Memorable Experiences',
                'band_score' => 8.5,
                'cue_card_prompt' => "You should say:\n- Where you went\n- Who you went with\n- What you did during the trip\n- And explain why this journey was so memorable to you.",
                'sample_transcript' => <<<TEXT
I would like to talk about a breathtaking road trip across the northern mountainous loop of Ha Giang that I took with my family two summers ago. 

We embarked on a four-day expedition navigating winding mountain passes flanked by towering limestone karsts and deep ravines. What made this expedition truly unforgettable was not merely the awe-inspiring scenery, but the opportunity to disconnect from digital distractions and immerse ourselves in authentic local ethnic cultures. Standing atop the Ma Pi Leng Pass at sunset overlooking the turquoise Nho Que River was a profoundly serene moment that deepened our familial bonds.
TEXT
,
                'linearthinking_notes' => 'Cấu trúc câu mở rộng: What made this... was not merely X, but Y. Sử dụng các tính từ miêu tả cảm xúc đắt giá.',
                'audio_url' => 'https://actions.google.com/sounds/v1/speech/spelling_bee_introduction.ogg',
                'useful_phrases' => [
                    ['word' => 'breathtaking road trip', 'meaning' => 'chuyến đi phượt đường dài đẹp ngoạn mục'],
                    ['word' => 'limestone karsts', 'meaning' => 'những dãy núi đá vôi trùng điệp'],
                    ['word' => 'profoundly serene', 'meaning' => 'vô cùng yên bình và thanh tịnh'],
                ],
            ]
        );

        // 8. Seed Rich High-Frequency IELTS Vocabulary
        $words = [
            [
                'word' => 'compelling',
                'phonetic_us' => '/kəmˈpel.ɪŋ/',
                'phonetic_uk' => '/kəmˈpel.ɪŋ/',
                'audio_us' => 'https://ssl.gstatic.com/dictionary/static/sounds/20200429/compelling--_us_1.mp3',
                'part_of_speech' => 'adjective',
                'definition_vi' => 'Hấp dẫn, thuyết phục, không thể cưỡng lại được',
                'definition_en' => 'Evoking interest, attention, or admiration in a powerfully irresistible way.',
                'example_sentence' => 'The author presents a compelling argument for sustainable urban development.',
                'word_family' => ['verb' => 'compel', 'noun' => 'compulsion', 'adjective' => 'compelling'],
                'collocations' => ['compelling evidence', 'compelling story', 'compelling reason'],
            ],
            [
                'word' => 'meticulously',
                'phonetic_us' => '/məˈtɪk.jə.ləs.li/',
                'phonetic_uk' => '/məˈtɪk.jə.ləs.li/',
                'audio_us' => 'https://ssl.gstatic.com/dictionary/static/sounds/20200429/meticulously--_us_1.mp3',
                'part_of_speech' => 'adverb',
                'definition_vi' => 'Một cách tỉ mỉ, kỹ lưỡng từng chi tiết',
                'definition_en' => 'In a way that shows great attention to detail; very thoroughly.',
                'example_sentence' => 'The clinical trial data was meticulously verified before publication.',
                'word_family' => ['adjective' => 'meticulous', 'noun' => 'meticulousness'],
                'collocations' => ['meticulously planned', 'meticulously documented'],
            ],
            [
                'word' => 'ubiquitous',
                'phonetic_us' => '/juːˈbɪk.wə.t̬əs/',
                'phonetic_uk' => '/juːˈbɪk.wɪ.təs/',
                'audio_us' => 'https://ssl.gstatic.com/dictionary/static/sounds/20200429/ubiquitous--_us_1.mp3',
                'part_of_speech' => 'adjective',
                'definition_vi' => 'Phổ biến khắp nơi, nhan nhản',
                'definition_en' => 'Present, appearing, or found everywhere.',
                'example_sentence' => 'Smartphones have become ubiquitous in contemporary daily life.',
                'word_family' => ['noun' => 'ubiquity'],
                'collocations' => ['ubiquitous presence', 'ubiquitous technology'],
            ],
            [
                'word' => 'corroborate',
                'phonetic_us' => '/kəˈrɑː.bə.reɪt/',
                'phonetic_uk' => '/kəˈrɒb.ə.reɪt/',
                'audio_us' => 'https://ssl.gstatic.com/dictionary/static/sounds/20200429/corroborate--_us_1.mp3',
                'part_of_speech' => 'verb',
                'definition_vi' => 'Chứng thực, xác nhận tính xác thực của thông tin',
                'definition_en' => 'Confirm or give support to a statement, theory, or finding.',
                'example_sentence' => 'Recent satellite imagery corroborates the researchers hypothesis on ice melt.',
                'word_family' => ['noun' => 'corroboration', 'adjective' => 'corroborative'],
                'collocations' => ['corroborate evidence', 'corroborate findings'],
            ],
            [
                'word' => 'alleviate',
                'phonetic_us' => '/əˈliː.vi.eɪt/',
                'phonetic_uk' => '/əˈliː.vi.eɪt/',
                'audio_us' => 'https://ssl.gstatic.com/dictionary/static/sounds/20200429/alleviate--_us_1.mp3',
                'part_of_speech' => 'verb',
                'definition_vi' => 'Làm giảm bớt, xoa dịu (nỗi đau, áp lực, nghèo đói)',
                'definition_en' => 'Make suffering, deficiency, or a problem less severe.',
                'example_sentence' => 'Investment in mass transit helps alleviate severe traffic congestion in metropolitan areas.',
                'word_family' => ['noun' => 'alleviation'],
                'collocations' => ['alleviate poverty', 'alleviate symptoms', 'alleviate congestion'],
            ],
            [
                'word' => 'detrimental',
                'phonetic_us' => '/ˌdet.rəˈmen.t̬əl/',
                'phonetic_uk' => '/ˌdet.rɪˈmen.təl/',
                'audio_us' => 'https://ssl.gstatic.com/dictionary/static/sounds/20200429/detrimental--_us_1.mp3',
                'part_of_speech' => 'adjective',
                'definition_vi' => 'Có hại, gây tổn hại nghiêm trọng',
                'definition_en' => 'Tending to cause harm or damage.',
                'example_sentence' => 'Chronic sleep deprivation exerts a detrimental impact on cognitive memory performance.',
                'word_family' => ['noun' => 'detriment', 'adverb' => 'detrimentally'],
                'collocations' => ['detrimental effect', 'detrimental impact'],
            ],
        ];

        foreach ($words as $w) {
            $vocab = Vocabulary::firstOrCreate(['word' => $w['word']], $w);

            UserFlashcard::firstOrCreate(
                ['user_id' => $student1->id, 'vocab_id' => $vocab->id],
                [
                    'custom_note' => 'Từ vựng học thuật IELTS band 8.0+',
                    'context_sentence' => $w['example_sentence'],
                    'repetitions' => 1,
                    'ease_factor' => 2.50,
                    'interval_days' => 1,
                    'next_review_at' => Carbon::today(),
                ]
            );
        }

        // 9. Seed Full Structured Learning Roadmaps (IELTS, TOEIC, Communication)
        // ROADMAP 1: IELTS 0 -> 6.5+ (12 Weeks)
        $roadmap1 = \App\Models\LearningRoadmap::firstOrCreate(
            ['slug' => 'ielts-0-to-65-toan-dien'],
            [
                'title' => 'Lộ Trình Tự Học IELTS 0 -> 6.5+ Toàn Diện (12 Tuần)',
                'category' => 'ielts',
                'target_level' => 'Band 6.5+',
                'duration_weeks' => 12,
                'color_theme' => 'rose',
                'badge_title' => 'Cực Kỳ Phổ Biến',
                'description' => 'Lộ trình bài bản 3 giai đoạn dành cho người mất gốc hoặc mới bắt đầu: từ xây dựng nền tảng ngữ pháp nòng cốt S-V-O đến bứt phá 4 kỹ năng IELTS đạt chuẩn xét tuyển đại học.',
                'sort_order' => 1,
            ]
        );

        \App\Models\RoadmapPhase::firstOrCreate(
            ['roadmap_id' => $roadmap1->id, 'phase_number' => 1],
            [
                'title' => 'Giai Đoạn 1: Xây Gốc Phát Âm & Ngữ Pháp Nòng Cốt S-V-O',
                'duration_text' => 'Tuần 1 - Tuần 4',
                'goal_description' => 'Chuẩn hóa bảng 44 âm IPA, làm chủ kỹ thuật bóc tách câu nòng cốt S-V-O (Linearthinking) và nạp 500 từ vựng cốt lõi.',
                'milestones' => [
                    [
                        'type' => 'Nghe chép',
                        'title' => 'Luyện nghe chép chính tả bắt âm căn bản',
                        'description' => 'Hoàn thành 3 bài nghe chép chính tả cấp độ Beginner để nhận diện bẫy nuốt âm.',
                        'reward' => '+40 XP',
                        'action_text' => 'Luyện Nghe Ngay →',
                        'action_url' => route('dictation.index'),
                    ],
                    [
                        'type' => 'Từ vựng',
                        'title' => 'Ghi nhớ 100 từ vựng cốt lõi bằng Flashcard SM-2',
                        'description' => 'Học và vượt qua chu kỳ ôn tập ngắt quãng 3 ngày liên tiếp trên sổ từ.',
                        'reward' => '+30 XP',
                        'action_text' => 'Ôn Flashcard →',
                        'action_url' => route('flashcards.index'),
                    ],
                ],
            ]
        );

        \App\Models\RoadmapPhase::firstOrCreate(
            ['roadmap_id' => $roadmap1->id, 'phase_number' => 2],
            [
                'title' => 'Giai Đoạn 2: Làm Chủ Dạng Bài Reading & Listening',
                'duration_text' => 'Tuần 5 - Tuần 8',
                'goal_description' => 'Chinh phục toàn bộ các dạng bài trọng điểm: True/False/NG, Matching Headings, Multiple Choice và Form Completion.',
                'milestones' => [
                    [
                        'type' => 'Luyện đề',
                        'title' => 'Giải chi tiết Đề Cambridge 18 Test 1 Reading',
                        'description' => 'Áp dụng tư duy phân tích đoạn văn và bảng từ đồng nghĩa Paraphrase Table.',
                        'reward' => '+50 XP',
                        'action_text' => 'Làm Đề Cam 18 →',
                        'action_url' => route('ielts.take', ['slug' => 'cambridge-18-test-1-reading']),
                    ],
                    [
                        'type' => 'Luyện đề',
                        'title' => 'Thi thử Cambridge 19 Section 1 Listening',
                        'description' => 'Luyện bắt từ khóa (Keywords) và phân biệt bẫy gây nhiễu thông tin trong hội thoại.',
                        'reward' => '+50 XP',
                        'action_text' => 'Làm Đề Cam 19 →',
                        'action_url' => route('ielts.take', ['slug' => 'cambridge-19-test-1-listening']),
                    ],
                ],
            ]
        );

        \App\Models\RoadmapPhase::firstOrCreate(
            ['roadmap_id' => $roadmap1->id, 'phase_number' => 3],
            [
                'title' => 'Giai Đoạn 3: Bứt Phá Writing & Luyện Đề Full Test 60 Phút',
                'duration_text' => 'Tuần 9 - Tuần 12',
                'goal_description' => 'Luyện viết dàn bài Writing Task 1 & Task 2 bằng AI Grader, bấm giờ thi thử full 60 phút để đạt phản xạ phòng thi thực chiến.',
                'milestones' => [
                    [
                        'type' => 'AI Grader',
                        'title' => 'Chấm thử 1 bài viết IELTS Writing Task 2',
                        'description' => 'Gửi bài văn lên trợ lý AI để nhận phân tích 4 tiêu chí TR, CC, LR, GRA và sửa lỗi.',
                        'reward' => '+60 XP',
                        'action_text' => 'Chấm Điểm Bằng AI →',
                        'action_url' => route('ai.writing.index'),
                    ],
                    [
                        'type' => 'Kho bài mẫu',
                        'title' => 'Học dàn ý và từ vựng từ Bài Mẫu Band 8.5',
                        'description' => 'Phân tích cấu trúc lập luận nhân quả từ kho bài mẫu mẫu chuẩn giám khảo.',
                        'reward' => '+30 XP',
                        'action_text' => 'Xem Bài Mẫu →',
                        'action_url' => route('samples.writing.index'),
                    ],
                ],
            ]
        );

        // ROADMAP 2: IELTS 6.5 -> 8.0+ (8 Weeks)
        $roadmap2 = \App\Models\LearningRoadmap::firstOrCreate(
            ['slug' => 'ielts-65-to-80-linearthinking-chuyen-sau'],
            [
                'title' => 'Lộ Trình IELTS 6.5 -> 8.0+ Bứt Phá Linearthinking (8 Tuần)',
                'category' => 'ielts',
                'target_level' => 'Band 8.0+',
                'duration_weeks' => 8,
                'color_theme' => 'indigo',
                'badge_title' => 'Nâng Cao C1/C2',
                'description' => 'Dành cho học viên đã có nền tảng 6.0 - 6.5 muốn bứt phá lên Band 8.0+: chuyên sâu phân tích văn bản khoa học phức tạp, Collocations C1/C2 và tư duy viết phản biện chuyên sâu.',
                'sort_order' => 2,
            ]
        );

        \App\Models\RoadmapPhase::firstOrCreate(
            ['roadmap_id' => $roadmap2->id, 'phase_number' => 1],
            [
                'title' => 'Giai Đoạn 1: Tối Đa Hóa Điểm Reading & Listening 8.5+',
                'duration_text' => 'Tuần 1 - Tuần 4',
                'goal_description' => 'Xử lý triệt để bẫy Matching Information và các đoạn văn học thuật trừu tượng trong Cambridge 19.',
                'milestones' => [
                    [
                        'type' => 'Thi thử',
                        'title' => 'Giải đề Cambridge 19 Test 1 Reading (Target: 36/40)',
                        'description' => 'Tập trung bóc tách mệnh đề phức và liên kết logic giữa các câu.',
                        'reward' => '+60 XP',
                        'action_text' => 'Vào Phòng Thi →',
                        'action_url' => route('ielts.take', ['slug' => 'cambridge-19-test-1-reading']),
                    ],
                ],
            ]
        );

        // ROADMAP 3: TOEIC 450 -> 750+ / 900 (6 Weeks)
        $roadmap3 = \App\Models\LearningRoadmap::firstOrCreate(
            ['slug' => 'toeic-450-to-750-cap-toc'],
            [
                'title' => 'Lộ Trình Bứt Phá TOEIC 450 -> 750+ / 900 Cấp Tốc (6 Tuần)',
                'category' => 'toeic',
                'target_level' => 'TOEIC 750+',
                'duration_weeks' => 6,
                'color_theme' => 'indigo',
                'badge_title' => 'Doanh Nghiệp & Đi Làm',
                'description' => 'Chiến thuật làm bài ETS TOEIC mới nhất: mẹo tránh bẫy ngữ pháp Part 5 trong 15s/câu, chiến thuật đọc quét Email & Đoạn văn kép Part 7 và bắt âm hội thoại thương mại.',
                'sort_order' => 3,
            ]
        );

        \App\Models\RoadmapPhase::firstOrCreate(
            ['roadmap_id' => $roadmap3->id, 'phase_number' => 1],
            [
                'title' => 'Giai Đoạn 1: Quét Sạch 20 Bẫy Ngữ Pháp & Từ Vựng Part 5-6',
                'duration_text' => 'Tuần 1 - Tuần 3',
                'goal_description' => 'Xử lý nhanh các dạng bài biến thể từ loại (Word Families), liên từ và giới từ chỉ trong 10-15 giây/câu.',
                'milestones' => [
                    [
                        'type' => 'Từ vựng',
                        'title' => 'Học 200 Collocation thương mại hay gặp trong TOEIC',
                        'description' => 'Ghi nhớ các cụm từ đắt giá như "meticulously planned", "corroborate findings".',
                        'reward' => '+40 XP',
                        'action_text' => 'Học Từ Vựng →',
                        'action_url' => route('flashcards.index'),
                    ],
                ],
            ]
        );

        // ROADMAP 4: Tiếng Anh Giao Tiếp & TED Talks (4 Weeks)
        $roadmap4 = \App\Models\LearningRoadmap::firstOrCreate(
            ['slug' => 'tieng-anh-giao-tiep-va-thuyet-trinh-ted'],
            [
                'title' => 'Lộ Trình Tiếng Anh Giao Tiếp Tự Nhiên & Thuyết Trình TED (4 Tuần)',
                'category' => 'communication',
                'target_level' => 'Fluency B2-C1',
                'duration_weeks' => 4,
                'color_theme' => 'amber',
                'badge_title' => 'Tự Nhiên Như Người Bản Xứ',
                'description' => 'Luyện tai bắt âm với các bài nói TED nổi tiếng, khắc phục lỗi phát âm, phản xạ nói trôi chảy và phong thái tự tin trước đám đông.',
                'sort_order' => 4,
            ]
        );

        \App\Models\RoadmapPhase::firstOrCreate(
            ['roadmap_id' => $roadmap4->id, 'phase_number' => 1],
            [
                'title' => 'Giai Đoạn 1: Luyện Tai Bắt Âm & Ngữ Điệu TED Talks',
                'duration_text' => 'Tuần 1 - Tuần 4',
                'goal_description' => 'Tập trung luyện nghe chép chính tả chuyên sâu và bắt chước ngữ điệu (Shadowing Technique).',
                'milestones' => [
                    [
                        'type' => 'Nghe chép',
                        'title' => 'Luyện chép bài TED: The Secret Structure of Great Talks',
                        'description' => 'Luyện nghe từng câu lặp lại A-B và kiểm tra độ chính xác phát âm.',
                        'reward' => '+50 XP',
                        'action_text' => 'Bắt Đầu Luyện Nghe →',
                        'action_url' => route('dictation.practice', ['slug' => 'the-art-of-public-speaking']),
                    ],
                    [
                        'type' => 'Speaking',
                        'title' => 'Xem bài mẫu Speaking mô tả chuyến đi đáng nhớ',
                        'description' => 'Học các tính từ chỉ cảm xúc và cụm từ mô tả tự nhiên.',
                        'reward' => '+30 XP',
                        'action_text' => 'Xem Bài Nói Mẫu →',
                        'action_url' => route('samples.speaking.index'),
                    ],
                ],
            ]
        );

        // 7. Seed Full Comprehensive Test Library (80+ Tests across TOEIC, Cambridge 10-19, GT, Forecast)
        $this->call(ComprehensiveTestLibrarySeeder::class);
    }
}
