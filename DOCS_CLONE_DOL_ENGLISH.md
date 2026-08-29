# TÀI LIỆU ĐẶC TẢ THIẾT KẾ VÀ HƯỚNG DẪN SETUP CLONE NỀN TẢNG DOL TỰ HỌC (TUHOC.DOLENGLISH.VN)

> **Tên dự án:** EduLearn English (Hệ thống Luyện thi & Tự học Tiếng Anh Chuẩn DOL Linearthinking)  
> **Framework Backend:** PHP 8.2+ / Laravel 11.x  
> **Frontend Stack:** Tailwind CSS v3.4 + Alpine.js (hoặc Inertia.js với Vue 3 / React) + Livewire 3  
> **Database:** MySQL 8.0+ (hoặc PostgreSQL 15+) & Redis  
> **Admin Dashboard:** Filament PHP v3  
> **Phiên bản tài liệu:** 2.0.0 (Master Production Specification)

---

## MỤC LỤC

1. [Tổng Quan Hệ Thống & Phương Pháp Luận](#1-tổng-quan-hệ-thống--phương-pháp-luận)
2. [Hệ Thống Thiết Kế UI/UX Cao Cấp (Modern Neo-Academic Design System)](#2-hệ-thống-thiết-kế-uiux-cao-cấp-modern-neo-academic-design-system)
3. [Đặc Tả Chi Tiết Toàn Bộ Tính Năng Cốt Lõi (Core Feature Modules)](#3-đặc-tả-chi-tiết-toàn-bộ-tính-năng-cốt-lõi-core-feature-modules)
   - [3.1. Module Luyện Thi IELTS / TOEIC Online (IELTS Test Room)](#31-module-luyện-thi-ielts--toeic-online-ielts-test-room)
   - [3.2. Module Nghe Chép Chính Tả (Dictation Mastery Studio)](#32-module-nghe-chép-chính-tả-dictation-mastery-studio)
   - [3.3. Module Sổ Từ Vựng & Flashcard Thông Minh (SuperMemo SM-2)](#33-module-sổ-từ-vựng--flashcard-thông-minh-supermemo-sm-2)
   - [3.4. Module Thư Viện Bài Mẫu Writing & Speaking (Linearthinking Samples)](#34-module-thư-viện-bài-mẫu-writing--speaking-linearthinking-samples)
   - [3.5. Module Tích Hợp Trí Tuệ Nhân Tạo (AI Assistant & Essay Scorer)](#35-module-tích-hợp-trí-tuệ-nhân-tạo-ai-assistant--essay-scorer)
   - [3.6. Module Gamification, Báo Cáo Tiến Độ & Radar Điểm Yếu](#36-module-gamification-báo-cáo-tiến-độ--radar-điểm-yếu)
4. [Thiết Kế Cơ Sở Dữ Liệu Hoàn Chỉnh (Database Schema / 16 Tables)](#4-thiết-kế-cơ-sở-dữ-liệu-hoàn-chỉnh-database-schema--16-tables)
5. [Thuật Toán & Logic Nghiệp Vụ Cốt Lõi (Laravel Service Classes)](#5-thuật-toán--logic-nghiệp-vụ-cốt-lõi-laravel-service-classes)
   - [5.1. Bảng quy đổi Band Score IELTS Reading & Listening](#51-bảng-quy-đổi-band-score-ielts-reading--listening)
   - [5.2. Thuật toán Lặp lại ngắt quãng SuperMemo SM-2](#52-thuật-toán-lặp-lại-ngắt-quãng-supermemo-sm-2)
   - [5.3. Thuật toán So khớp Chép chính tả Realtime & Levenshtein Diff](#53-thuật-toán-so-khớp-chép-chính-tả-realtime--levenshtein-diff)
   - [5.4. Service Phân tích Lời giải Linearthinking & Paraphrase](#54-service-phân-tích-lời-giải-linearthinking--paraphrase)
6. [Hệ Thống Routing & RESTful API Endpoints](#6-hệ-thống-routing--restful-api-endpoints)
7. [Kiến Trúc & Thiết Kế Module Quản Trị (Admin CMS - Filament v3)](#7-kiến-trúc--thiết-kế-module-quản-trị-admin-cms---filament-v3)
8. [Cấu Trúc Thư Mục Chuẩn Của Dự Án Laravel 11](#8-cấu-trúc-thư-mục-chuẩn-của-dự-án-laravel-11)
9. [Hướng Dẫn Cài Đặt Chi Tiết Từng Bước (Step-by-Step Setup Guide)](#9-hướng-dẫn-cài-đặt-chi-tiết-từng-bước-step-by-step-setup-guide)
10. [Lộ Trình Triển Khai (Roadmap)](#10-lộ-trình-triển-khai-roadmap)

---

## 1. TỔNG QUAN HỆ THỐNG & PHƯƠNG PHÁP LUẬN

### 1.1. Mục Tiêu Nền Tảng
Nền tảng được xây dựng nhằm cung cấp giải pháp **tự học tiếng Anh thông minh toàn diện** (chuẩn theo mô hình tự học của DOL English). Trọng tâm của hệ thống là áp dụng phương pháp **Linearthinking** (Tư duy tuyến tính) vào việc giải đề, học từ vựng, rèn luyện nghe chép chính tả và phát triển kỹ năng Viết - Nói.

### 1.2. Sơ Đồ Kiến Trúc Hệ Thống (High-Level Architecture)

```
+-----------------------------------------------------------------------------------------------+
|                                        CLIENT LAYER (UI/UX)                                   |
|  +--------------------+  +----------------------+  +---------------------+  +---------------+  |
|  | Split-Screen Exam  |  | Dictation Audio Lab  |  | 3D Flashcard SRS    |  | AI Essay Grader|  |
|  | (Reading/Listening)|  | (Waveform & AB Loop) |  | (Memory Review SM-2)|  | (4 Band Criteria)|
|  +--------------------+  +----------------------+  +---------------------+  +---------------+  |
|  +--------------------+  +----------------------+  +---------------------+  +---------------+  |
|  | 1-Click Dictionary |  | Linearthinking Box   |  | Weakness Radar Map  |  | Streak & Leader|  |
|  | (Selection Popup)  |  | (S-V-O & Connection) |  | (Skill Analytics)   |  | (Gamification)|  |
|  +--------------------+  +----------------------+  +---------------------+  +---------------+  |
+-----------------------------------------------+-----------------------------------------------+
                                                | HTTP / Livewire / Websockets / REST API
+-----------------------------------------------v-----------------------------------------------+
|                                    LARAVEL 11 CORE BACKEND                                    |
|  +-----------------------+  +-------------------------+  +---------------------------------+  |
|  | Authentication        |  | Test Scoring Engine     |  | Dictation Verification Engine   |  |
|  | (Sanctum, Socialite)  |  | (Band 9.0 Calculator)   |  | (Levenshtein Diff & Punctuation)|  |
|  +-----------------------+  +-------------------------+  +---------------------------------+  |
|  +-----------------------+  +-------------------------+  +---------------------------------+  |
|  | Spaced Repetition Svc |  | Linearthinking Parser   |  | AI Prompt Orchestrator (OpenAI) |  |
|  | (SuperMemo SM-2)      |  | (Structure & Paraphrase)|  | (Essay Feedback & Speaking S2T) |  |
|  +-----------------------+  +-------------------------+  +---------------------------------+  |
+-----------------------------------------------+-----------------------------------------------+
                                                |
+-----------------------------------------------v-----------------------------------------------+
|                                     DATA & INFRASTRUCTURE                                     |
|  +--------------------+  +------------------------+  +--------------------+  +--------------+  |
|  | MySQL 8.0 / PGSQL  |  | Redis (Cache & Queue)  |  | S3 / Local Storage |  | Meilisearch  |  |
|  | (Relational Data)  |  | (Leaderboard, Session) |  | (Audio MP3, PDF)   |  | (Full-text)  |  |
|  +--------------------+  +------------------------+  +--------------------+  +--------------+  |
+-----------------------------------------------------------------------------------------------+
```

---

## 2. HỆ THỐNG THIẾT KẾ UI/UX CAO CẤP (MODERN NEO-ACADEMIC DESIGN SYSTEM)

Giao diện được thiết kế theo phong cách **Neo-Academic Tech** (Hiện đại, tối giản, sang trọng, tập trung tối đa vào trải nghiệm đọc và tương tác thi cử không gây mỏi mắt).

### 2.1. Bảng Màu Chuẩn (Color Tokens)

```css
/* Color Palette Config */
:root {
  /* Primary DOL Crimson (Đỏ Đô Sang Trọng) */
  --primary-50:  #FFF1F2;
  --primary-100: #FFE4E6;
  --primary-500: #E11D48; /* Accent chính */
  --primary-600: #BE123C; /* Nút chính / Primary Action */
  --primary-700: #9F1239;
  --primary-900: #4C0519;

  /* Secondary Navy Slate (Nền học thuật) */
  --slate-900:   #0F172A; /* Nền Header / Dark mode */
  --slate-800:   #1E293B;
  --slate-700:   #334155;
  --slate-100:   #F1F5F9;
  --slate-50:    #F8FAFC; /* Nền trang Light mode */

  /* Trạng thái làm bài (Status Colors) */
  --color-correct:    #10B981; /* Xanh lá: Đáp án đúng / Đã làm */
  --color-wrong:      #F43F5E; /* Đỏ hồng: Đáp án sai / Lỗi gõ */
  --color-flagged:    #F59E0B; /* Vàng hổ phách: Đánh dấu cần xem lại */
  --color-highlight:  #FEF08A; /* Vàng chanh: Bôi highlight bài đọc */
  --color-linearthinking: #6366F1; /* Tím Indigo: Box tư duy logic */
}
```

### 2.2. Nghệ Thuật Chữ (Typography)
* **Giao diện người dùng (UI Elements):** Font `Plus Jakarta Sans` hoặc `Inter` (rõ ràng, hiện đại ở mọi kích thước nút bấm, menu, bảng điểm).
* **Văn bản bài đọc học thuật (IELTS Passages & Essays):** Font `Merriweather` hoặc `Lora` với `line-height: 1.85` và cỡ chữ tiêu chuẩn `16px - 18px` giúp mắt tập trung đọc hiểu văn bản dài trên 1000 từ.

### 2.3. Quy Chuẩn Các Thành Phần Giao Diện Đặc Thù

#### A. Phòng Thi Tách Đôi Kéo Thả (Split-Screen Test Room)
* **Thanh phân cách Resizable Gutter:** Thanh trượt ở giữa cho phép học viên kéo chuột thay đổi độ rộng giữa 2 cột (Bài đọc 55% - Câu hỏi 45%).
* **Thanh công cụ làm bài nổi (Floating Action Bar):**
  * Đồng hồ đếm ngược với tính năng cảnh báo khi còn 10 phút / 5 phút.
  * Bộ công cụ: Highlight màu vàng/xanh, Thêm ghi chú (Sticky Note), Tra từ nhanh.
  * Nút "Flag Question" (Đánh dấu cờ) để lưu lại câu chưa chắc chắn.
* **Ma trận câu hỏi (Bottom Drawer Question Matrix):** Bảng số 1 đến 40 hiển thị trạng thái động (Chưa làm, Đã làm, Đã gắn cờ). Nhấp vào số câu sẽ tự động cuộn mượt (smooth scroll) đến vị trí câu đó.

#### B. Trình Chép Chính Tả Tương Tác (Dictation Player UI)
* **Visual Waveform:** Hiển thị biểu đồ âm thanh dạng sóng đang phát.
* **Interactive Keystroke Input:** Ô nhập liệu gõ câu theo thời gian thực.
  * Ký tự/từ đúng: Hiển thị màu xanh ngọc bích `text-emerald-600`.
  * Lỗi gõ sai: Hiển thị gạch chân ziczac nhẹ `underline decoration-rose-500`.
* **Phím tắt điều khiển (Hotkeys):**
  * `Space`: Play / Pause audio đoạn hiện tại.
  * `Ctrl + Left Arrow`: Tua lại 3 giây.
  * `Tab`: Nghe lại câu hiện tại (A-B Repeat).
  * `Ctrl + H`: Gợi ý ký tự đầu tiên (Hint mode).

#### C. Popup Tra Từ Tức Thì (1-Click In-Text Dictionary)
* Bôi đen bất kỳ từ hoặc cụm từ trong bài đọc -> Một thẻ Popup nổi bóng kính (Glassmorphic Card) xuất hiện ngay trên từ đó với độ trễ 100ms.
* Hiển thị: Từ gốc, Phiên âm quốc tế IPA, Nút phát âm loa US / UK, Nghĩa cô đọng tiếng Việt, Ví dụ thực tế và Nút bấm 1 chạm `+ Thêm vào sổ từ vựng`.

---

## 3. ĐẶC TẢ CHI TIẾT TOÀN BỘ TÍNH NĂNG CỐT LÕI (CORE FEATURE MODULES)

### 3.1. Module Luyện Thi IELTS / TOEIC Online (IELTS Test Room)

#### 1. Thư viện đề thi
* Kho đề chuẩn Cambridge IELTS từ quyển 10 đến quyển 20.
* Bộ đề IELTS Practice Test Plus 1-3, Road to IELTS, Actual Tests, Đề dự đoán Real Test.
* Phân loại theo bộ lọc: Học thuật (Academic) / Tổng quát (General), Kỹ năng (Reading / Listening), Cấp độ, Thời gian làm bài.

#### 2. Hai chế độ thi (Two Taking Modes)
* **Full Test Mode (Chế độ thi thật):** Bấm giờ chuẩn 60 phút, giao diện full màn hình, khóa phím tắt thoát trang bất thường, không xem trước đáp án, tự động nộp bài khi hết giờ.
* **Practice Mode (Chế độ luyện tập từng phần):** Làm từng Passage hoặc từng Part riêng lẻ, không giới hạn thời gian, có nút "Xem giải thích ngay" sau mỗi câu.

#### 3. Đầy đủ các dạng câu hỏi chuẩn quốc tế
1. `multiple_choice_single`: Trắc nghiệm 1 đáp án (A, B, C, D).
2. `multiple_choice_multiple`: Trắc nghiệm chọn nhiều đáp án (VD: Chọn 2 trong số 5).
3. `true_false_not_given` & `yes_no_not_given`: Kiểm tra tính xác thực thông tin.
4. `matching_headings`: Nối tiêu đề cho các đoạn văn (hỗ trợ kéo thả hoặc dropdown).
5. `matching_information` / `matching_features`: Nối thông tin với đoạn văn hoặc tên chuyên gia.
6. `fill_in_the_blank`: Điền từ vào ô trống (Sentence Completion, Summary Completion, Flow-chart, Table, Diagram Labelling).
7. `drag_and_drop_summary`: Kéo từ vựng cho sẵn vào các chỗ trống của bài tóm tắt.

#### 4. Hệ thống Giải thích Chi tiết Chuẩn Linearthinking
Trang kết quả sau khi nộp bài hiển thị:
* **Evidence Locator:** Bấm vào câu hỏi lập tức cuộn và làm nổi bật (Highlight) đoạn văn chứa manh mối trả lời trong bài đọc.
* **Linearthinking Breakdown Box:**
  * **Cấu trúc câu (Sentence Simplification):** Phân tích thành phần ngữ pháp cốt lõi `S (Chủ ngữ) + V (Động từ) + O (Tân ngữ)`, lược bỏ mệnh đề bổ nghĩa phức tạp gây nhiễu.
  * **Liên kết ý (Connection Logic):** Chỉ rõ mối liên hệ giữa các câu xung quanh để học viên hiểu vì sao chọn đáp án này mà không bị bẫy paraphrase.
  * **Bảng Từ Đồng Nghĩa (Paraphrase Table):** Bảng so sánh trực quan từ khóa trong câu hỏi và từ tương đương trong bài đọc.

---

### 3.2. Module Nghe Chép Chính Tả (Dictation Mastery Studio)

#### 1. Quy trình luyện nghe 4 bước chuẩn khoa học
1. **Bước 1: Nghe tổng quát (Global Listening):** Nghe trọn vẹn đoạn âm thanh 1-2 lần không transcript để nắm bắt bối cảnh chung.
2. **Bước 2: Nghe chép từng câu (Intensive Dictation):** Hệ thống chia audio thành từng câu ngắn (dựa trên timestamp). Audio tự động lặp lại cho đến khi học viên gõ xong.
3. **Bước 3: So sánh & Chấm điểm (Instant Feedback & Diff):** Hệ thống tính % chính xác theo từng từ. Hiển thị màu xanh cho từ đúng, màu đỏ cho từ sai hoặc bị thiếu.
4. **Bước 4: Học nối âm & Phát âm (Phonetics & Connected Speech):** Hiển thị transcript song ngữ hoàn chỉnh, đánh dấu các hiện tượng âm thanh đặc biệt (Nối âm - Linking sounds, Biến âm - Assimilation, Nuốt âm - Elision).

#### 2. Tính năng Audio Player nâng cao
* Tua chậm/nhanh: `0.5x`, `0.75x`, `1.0x`, `1.25x`, `1.5x`.
* Lặp vô hạn câu hiện tại (A-B Repeat) hoặc phát tiếp câu kế tiếp sau khi hoàn thành.
* Hint Mode: Nút gợi ý ký tự đầu của các từ khó.

---

### 3.3. Module Sổ Từ Vựng & Flashcard Thông Minh (SuperMemo SM-2)

#### 1. Thu thập từ vựng 1 chạm
* Lưu từ trực tiếp từ bài đọc/bài nghe kèm theo **câu ngữ cảnh gốc** (Context Sentence) giúp ghi nhớ từ vựng tự nhiên theo văn cảnh chứ không học vẹt.
* Tự động đồng bộ nghĩa tiếng Việt, phát âm US/UK chuẩn, từ loại, phiên âm IPA, họ từ (Word Family) và Collocations.

#### 2. Thuật toán Lặp lại ngắt quãng (Spaced Repetition System - SM-2)
* Mỗi thẻ từ vựng khi ôn tập sẽ được học viên đánh giá theo 4 mức độ:
  * `0: Quên hoàn toàn (Blackout)` -> Ôn lại ngay trong phiên học.
  * `1: Khó (Hard)` -> Ôn lại sau 1 ngày.
  * `2: Vừa phải (Good)` -> Ôn lại sau 3-6 ngày.
  * `3: Rất dễ (Easy)` -> Tăng hệ số ghi nhớ và dãn ngày ôn dài hơn (10 - 30 ngày).
* Thuật toán tự động tính toán `Ease Factor (EF)` và `Interval Days` tối ưu để từ vựng rơi đúng vào "điểm sắp quên" của não bộ.
* Giao diện lật thẻ 3D (3D Card Flip) mượt mà với hiệu ứng âm thanh sống động.

---

### 3.4. Module Thư Viện Bài Mẫu Writing & Speaking (Linearthinking Samples)

#### 1. IELTS Writing Sample Bank
* **Task 1:** Line Graph, Bar Chart, Pie Chart, Table, Mixed Chart, Map, Process.
* **Task 2:** Opinion / Agree or Disagree, Discussion with Opinion, Problem & Solution, Advantages & Disadvantages, Two-part question.
* **Cấu trúc mỗi bài mẫu:**
  1. Đề bài + Phân tích câu hỏi (Task Breakdown).
  2. Dàn ý tư duy Linearthinking (Outline logic rõ ràng từng đoạn Mở bài - Tổng quan - Chi tiết).
  3. Bài viết mẫu hoàn chỉnh Band 8.0+.
  4. Bộ từ vựng & Collocation ăn điểm (Lexical Resource) được bôi đậm có kèm nghĩa.
  5. Bản dịch tiếng Việt song ngữ đối chiếu chuẩn xác.

#### 2. IELTS Speaking Forecast & Audio Bank
* Đầy đủ Part 1, Part 2 (Cue Card) và Part 3 theo bộ đề dự đoán từng quý.
* Audio thu âm mẫu giọng bản ngữ chuẩn cho từng câu trả lời.
* Công thức trả lời theo tư duy mở rộng ý (Framework: **A.R.E.A** - Answer -> Reason -> Example -> Alternative).

---

### 3.5. Module Tích Hợp Trí Tuệ Nhân Tạo (AI Assistant & Essay Scorer)

#### 1. AI IELTS Essay Grader (Chấm bài Writing tự động)
* Học viên nhập đề bài và dán bài luận Writing Task 1 hoặc Task 2.
* Hệ thống tích hợp OpenAI / Claude API chấm điểm chi tiết theo 4 tiêu chí chính thức của IELTS:
  * **Task Achievement / Task Response (TR):** Đánh giá mức độ trả lời trọng tâm đề.
  * **Coherence & Cohesion (CC):** Đánh giá tính mạch lạc và liên kết câu/đoạn.
  * **Lexical Resource (LR):** Đánh giá sự đa dạng và độ chính xác của từ vựng.
  * **Grammatical Range & Accuracy (GRA):** Đánh giá độ phức tạp và lỗi ngữ pháp.
* Chỉ rõ từng câu bị lỗi ngữ pháp và đưa ra câu viết lại hay hơn (Upgraded Version).

#### 2. AI Speaking Pronunciation Analyzer
* Học viên ghi âm câu trả lời qua Micro trình duyệt.
* Hệ thống chuyển đổi giọng nói thành văn bản (Speech-to-Text) và phân tích độ chuẩn phát âm, tốc độ nói (WPM - Words Per Minute) và sự ngập ngừng (Pauses).

---

### 3.6. Module Gamification, Báo Cáo Tiến Độ & Radar Điểm Yếu

* **Chuỗi ngày học liên tục (Daily Study Streak):** Hiển thị biểu tượng ngọn lửa streak. Bắn thông báo nhắc nhở giữ chuỗi học mỗi ngày.
* **Mục tiêu học tập hàng ngày (Daily Goals):** Hoàn thành 1 bài nghe chép + Ôn 20 từ flashcard + Làm 1 bài đọc ngắn.
* **Huy hiệu thành tích (Achievement Badges):** "Chiến binh Cam 19", "Bậc thầy chính tả 100 câu", "Nhớ dai 500 từ".
* **Biểu đồ Radar Điểm Yếu (Weakness Radar Chart):**
  * Tự động thống kê tỷ lệ đúng/sai theo từng dạng câu hỏi (Ví dụ: Đúng 85% *Matching Headings*, nhưng chỉ đúng 42% *True/False/Not Given*).
  * Đề xuất tự động các bộ đề luyện tập chuyên sâu cho dạng bài học viên đang yếu nhất.

---

## 4. THIẾT KẾ CƠ SỞ DỮ LIỆU HOÀN CHỈNH (DATABASE SCHEMA / 16 TABLES)

Dưới đây là mã SQL chuẩn hóa 3NF có đầy đủ ràng buộc khóa ngoại (Foreign Keys) và Indexes tối ưu cho cơ sở dữ liệu MySQL 8.0+:

```sql
-- ==========================================================
-- 1. BẢNG NGƯỜI DÙNG & PHÂN QUYỀN
-- ==========================================================
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) NULL,
    role ENUM('user', 'teacher', 'admin') DEFAULT 'user',
    target_band DECIMAL(2,1) DEFAULT 6.5,
    streak_count INT UNSIGNED DEFAULT 0,
    last_study_date DATE NULL,
    xp_points INT UNSIGNED DEFAULT 0,
    email_verified_at TIMESTAMP NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================
-- 2. BẢNG DANH MỤC & BỘ ĐỀ THI (TEST CATEGORIES & SETS)
-- ==========================================================
CREATE TABLE test_categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL, -- IELTS Academic, IELTS General, TOEIC, SAT
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    icon VARCHAR(255) NULL,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE test_sets (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL, -- Cambridge IELTS 19, IELTS Practice Plus 3
    slug VARCHAR(255) UNIQUE NOT NULL,
    thumbnail VARCHAR(255) NULL,
    description TEXT NULL,
    is_free BOOLEAN DEFAULT TRUE,
    total_tests INT DEFAULT 4,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (category_id) REFERENCES test_categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================
-- 3. BẢNG BÀI TEST & PHẦN THI (TESTS & PASSAGES/SECTIONS)
-- ==========================================================
CREATE TABLE tests (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    test_set_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL, -- Test 1 - Reading
    slug VARCHAR(255) UNIQUE NOT NULL,
    type ENUM('reading', 'listening', 'full_test') NOT NULL,
    duration_minutes INT DEFAULT 60,
    total_questions INT DEFAULT 40,
    views_count INT UNSIGNED DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (test_set_id) REFERENCES test_sets(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE test_sections (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    test_id BIGINT UNSIGNED NOT NULL,
    section_number INT NOT NULL, -- Passage 1, 2, 3 hoặc Section 1, 2, 3, 4
    title VARCHAR(255) NOT NULL,
    passage_text LONGTEXT NULL, -- Nội dung bài đọc (hỗ trợ HTML/RichText & Thẻ Đoạn A, B, C...)
    audio_url VARCHAR(255) NULL, -- File âm thanh nếu là bài Listening
    transcript LONGTEXT NULL, -- Toàn văn transcript nghe
    translation_vi LONGTEXT NULL, -- Bản dịch bài đọc tiếng Việt
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (test_id) REFERENCES tests(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================
-- 4. BẢNG NHÓM CÂU HỎI & CÂU HỎI (QUESTIONS & EXPLANATIONS)
-- ==========================================================
CREATE TABLE question_groups (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    section_id BIGINT UNSIGNED NOT NULL,
    instruction TEXT NOT NULL, -- "Questions 1-5: Choose TRUE/FALSE/NOT GIVEN..."
    question_type ENUM(
        'multiple_choice_single',
        'multiple_choice_multiple',
        'true_false_not_given',
        'yes_no_not_given',
        'matching_headings',
        'matching_information',
        'matching_features',
        'fill_in_the_blank',
        'drag_and_drop'
    ) NOT NULL,
    image_url VARCHAR(255) NULL, -- Hình sơ đồ nếu là dạng Diagram completion
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (section_id) REFERENCES test_sections(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE questions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    group_id BIGINT UNSIGNED NOT NULL,
    question_number INT NOT NULL, -- Số thứ tự câu (1 đến 40)
    content TEXT NOT NULL, -- Nội dung câu hỏi
    correct_answer TEXT NOT NULL, -- Đáp án chuẩn (hoặc chuỗi JSON các đáp án chấp nhận)
    options JSON NULL, -- Danh sách phương án ["A. ...", "B. ...", "C. ...", "D. ..."]
    evidence_paragraph VARCHAR(50) NULL, -- Tọa độ manh mối (VD: Paragraph B, Lines 4-6)
    linearthinking_structure TEXT NULL, -- Phân tích cấu trúc ngữ pháp (S-V-O)
    linearthinking_logic TEXT NULL, -- Phân tích đường dây liên kết ý tưởng logic
    paraphrase_table JSON NULL, -- Bảng từ đồng nghĩa [{"question_word": "...", "passage_word": "..."}]
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (group_id) REFERENCES question_groups(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================
-- 5. BẢNG KẾT QUẢ THI CỦA HỌC VIÊN (SUBMISSIONS & ANSWERS)
-- ==========================================================
CREATE TABLE test_submissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    test_id BIGINT UNSIGNED NOT NULL,
    mode ENUM('practice', 'full_test') DEFAULT 'full_test',
    score_raw INT DEFAULT 0, -- Số câu đúng (VD: 34/40)
    band_score DECIMAL(2,1) DEFAULT 0.0, -- Quy đổi Band (VD: 7.5)
    time_spent_seconds INT DEFAULT 0,
    status ENUM('in_progress', 'completed') DEFAULT 'completed',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (test_id) REFERENCES tests(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE user_answers (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    submission_id BIGINT UNSIGNED NOT NULL,
    question_id BIGINT UNSIGNED NOT NULL,
    user_answer TEXT NULL,
    is_correct BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (submission_id) REFERENCES test_submissions(id) ON DELETE CASCADE,
    FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================
-- 6. BẢNG NGHE CHÉP CHÍNH TẢ (DICTATION TOPICS & SENTENCES)
-- ==========================================================
CREATE TABLE dictation_topics (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    level ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'intermediate',
    category VARCHAR(100) DEFAULT 'IELTS Listening', -- TED Talks, Daily Life, BBC News
    audio_url VARCHAR(255) NOT NULL,
    duration_seconds INT NOT NULL,
    thumbnail VARCHAR(255) NULL,
    total_sentences INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE dictation_sentences (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    topic_id BIGINT UNSIGNED NOT NULL,
    sentence_order INT NOT NULL, -- Thứ tự câu: 1, 2, 3...
    audio_start_time DECIMAL(6,2) NOT NULL, -- Bắt đầu câu (giây, VD: 12.45)
    audio_end_time DECIMAL(6,2) NOT NULL, -- Kết thúc câu (giây, VD: 18.20)
    original_text TEXT NOT NULL, -- Câu tiếng Anh chuẩn xác
    translation_vi TEXT NULL, -- Bản dịch tiếng Việt
    phonetic_notes TEXT NULL, -- Ghi chú nối âm, trọng âm, nuốt âm
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (topic_id) REFERENCES dictation_topics(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE user_dictation_progress (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    topic_id BIGINT UNSIGNED NOT NULL,
    completed_sentences INT DEFAULT 0,
    accuracy_percentage DECIMAL(5,2) DEFAULT 0.0,
    is_finished BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (topic_id) REFERENCES dictation_topics(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================
-- 7. BẢNG TỪ ĐIỂN & FLASHCARDS SUPERMEMO SM-2
-- ==========================================================
CREATE TABLE vocabulary (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    word VARCHAR(100) UNIQUE NOT NULL,
    phonetic_us VARCHAR(100) NULL,
    phonetic_uk VARCHAR(100) NULL,
    audio_us VARCHAR(255) NULL,
    audio_uk VARCHAR(255) NULL,
    part_of_speech VARCHAR(50) NULL, -- noun, verb, adj, adverb, idiom
    definition_vi TEXT NOT NULL,
    definition_en TEXT NULL,
    example_sentence TEXT NULL,
    word_family JSON NULL, -- {"noun": "creation", "verb": "create", "adj": "creative"}
    collocations JSON NULL, -- ["make a decision", "heavy rain"]
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE user_flashcards (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    vocab_id BIGINT UNSIGNED NOT NULL,
    custom_note TEXT NULL,
    context_sentence TEXT NULL, -- Câu ngữ cảnh gốc khi học viên bấm lưu từ bài thi
    repetitions INT UNSIGNED DEFAULT 0, -- Số lần đã ôn
    ease_factor DECIMAL(4,2) DEFAULT 2.50, -- Hệ số ghi nhớ SM-2 (mặc định 2.5)
    interval_days INT UNSIGNED DEFAULT 0, -- Số ngày dãn cách đến lần ôn tiếp
    next_review_at DATE NOT NULL, -- Ngày ôn tiếp theo
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (vocab_id) REFERENCES vocabulary(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================
-- 8. BẢNG BÀI MẪU WRITING & SPEAKING (SAMPLE BANK)
-- ==========================================================
CREATE TABLE writing_samples (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    task_type ENUM('task1_academic', 'task1_general', 'task2') NOT NULL,
    chart_or_essay_type VARCHAR(100) NOT NULL, -- line_graph, bar_chart, opinion, discussion...
    prompt TEXT NOT NULL,
    image_url VARCHAR(255) NULL,
    outline_linearthinking LONGTEXT NOT NULL,
    sample_essay LONGTEXT NOT NULL,
    band_score DECIMAL(2,1) DEFAULT 8.0,
    translation_vi LONGTEXT NULL,
    key_vocab_list JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE speaking_samples (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    part ENUM('part1', 'part2', 'part3') NOT NULL,
    topic VARCHAR(255) NOT NULL,
    cue_card_prompt TEXT NULL,
    audio_url VARCHAR(255) NULL,
    sample_transcript LONGTEXT NOT NULL,
    linearthinking_notes LONGTEXT NULL,
    useful_phrases JSON NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================================
-- 9. BẢNG CHẤM BÀI AI WRITING & LỊCH SỬ HỌC TẬP
-- ==========================================================
CREATE TABLE ai_writing_evaluations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    task_type ENUM('task1', 'task2') NOT NULL,
    prompt TEXT NOT NULL,
    user_essay LONGTEXT NOT NULL,
    overall_band DECIMAL(2,1) NOT NULL,
    band_task_response DECIMAL(2,1) NOT NULL,
    band_coherence DECIMAL(2,1) NOT NULL,
    band_lexical DECIMAL(2,1) NOT NULL,
    band_grammar DECIMAL(2,1) NOT NULL,
    detailed_feedback LONGTEXT NOT NULL,
    revised_essay LONGTEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE user_study_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    activity_type ENUM('test', 'dictation', 'flashcard', 'writing_ai') NOT NULL,
    reference_id BIGINT UNSIGNED NULL,
    duration_minutes INT DEFAULT 0,
    study_date DATE NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX (user_id, study_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 5. THUẬT TOÁN & LOGIC NGHIỆP VỤ CỐT LÕI (LARAVEL SERVICE CLASSES)

### 5.1. Bảng Quy Đổi Band Score IELTS Reading & Listening

Tạo file: `app/Services/IeltsScoringService.php`

```php
<?php

namespace App\Services;

class IeltsScoringService
{
    /**
     * Quy đổi số câu đúng sang Band Score IELTS Reading (Academic)
     */
    public static function calculateReadingBand(int $rawScore): float
    {
        return match(true) {
            $rawScore >= 39 => 9.0,
            $rawScore >= 37 => 8.5,
            $rawScore >= 35 => 8.0,
            $rawScore >= 33 => 7.5,
            $rawScore >= 30 => 7.0,
            $rawScore >= 27 => 6.5,
            $rawScore >= 23 => 6.0,
            $rawScore >= 19 => 5.5,
            $rawScore >= 15 => 5.0,
            $rawScore >= 13 => 4.5,
            $rawScore >= 10 => 4.0,
            $rawScore >= 8  => 3.5,
            $rawScore >= 6  => 3.0,
            $rawScore >= 4  => 2.5,
            default         => 2.0,
        };
    }

    /**
     * Quy đổi số câu đúng sang Band Score IELTS Listening
     */
    public static function calculateListeningBand(int $rawScore): float
    {
        return match(true) {
            $rawScore >= 39 => 9.0,
            $rawScore >= 37 => 8.5,
            $rawScore >= 35 => 8.0,
            $rawScore >= 32 => 7.5,
            $rawScore >= 30 => 7.0,
            $rawScore >= 26 => 6.5,
            $rawScore >= 23 => 6.0,
            $rawScore >= 18 => 5.5,
            $rawScore >= 16 => 5.0,
            $rawScore >= 13 => 4.5,
            $rawScore >= 10 => 4.0,
            $rawScore >= 8  => 3.5,
            $rawScore >= 6  => 3.0,
            $rawScore >= 4  => 2.5,
            default         => 2.0,
        };
    }
}
```

---

### 5.2. Thuật Toán Lặp Lại Ngắt Quãng SuperMemo SM-2

Tạo file: `app/Services/SpacedRepetitionService.php`

```php
<?php

namespace App\Services;

use App\Models\UserFlashcard;
use Carbon\Carbon;

class SpacedRepetitionService
{
    /**
     * Cập nhật thẻ ghi nhớ theo thuật toán SuperMemo SM-2
     * 
     * @param UserFlashcard $card
     * @param int $grade 0: Quên hoàn toàn, 1: Khó, 2: Nhớ tốt, 3: Rất dễ
     * @return UserFlashcard
     */
    public function calculateNextReview(UserFlashcard $card, int $grade): UserFlashcard
    {
        // 1. Tính toán lại Hệ số dễ (Ease Factor)
        // Công thức chuẩn SM-2: EF' = EF + (0.1 - (3 - grade) * (0.08 + (3 - grade) * 0.02))
        $newEase = $card->ease_factor + (0.1 - (3 - $grade) * (0.08 + (3 - $grade) * 0.02));
        $card->ease_factor = max(1.30, round($newEase, 2));

        // 2. Tính số ngày dãn cách (Interval Days)
        if ($grade < 2) {
            // Đánh giá là quên -> Reset lại chuỗi lặp
            $card->repetitions = 0;
            $card->interval_days = 1;
        } else {
            if ($card->repetitions === 0) {
                $card->interval_days = 1;
            } elseif ($card->repetitions === 1) {
                $card->interval_days = 6;
            } else {
                $card->interval_days = (int) round($card->interval_days * $card->ease_factor);
            }
            $card->repetitions += 1;
        }

        // 3. Cập nhật ngày ôn tiếp theo
        $card->next_review_at = Carbon::now()->addDays($card->interval_days);
        $card->save();

        return $card;
    }
}
```

---

### 5.3. Thuật Toán So Khớp Chép Chính Tả Realtime & Levenshtein Diff

Tạo file: `app/Services/DictationVerificationService.php`

```php
<?php

namespace App\Services;

class DictationVerificationService
{
    /**
     * So sánh câu gõ của học viên với câu gốc, trả về % chính xác và chi tiết từng từ
     */
    public function verifySentence(string $userInput, string $originalText): array
    {
        $cleanUser = $this->cleanPunctuation($userInput);
        $cleanOriginal = $this->cleanPunctuation($originalText);

        $userWords = array_values(array_filter(explode(' ', $cleanUser)));
        $originalWords = array_values(array_filter(explode(' ', $cleanOriginal)));

        $totalWords = count($originalWords);
        $correctCount = 0;
        $diffList = [];

        foreach ($originalWords as $idx => $targetWord) {
            $userWord = $userWords[$idx] ?? '';
            $isExactMatch = (mb_strtolower($userWord) === mb_strtolower($targetWord));
            
            // Tính độ tương đồng bằng Levenshtein distance
            $similarity = 0.0;
            if (!$isExactMatch && !empty($userWord)) {
                $lev = levenshtein(mb_strtolower($userWord), mb_strtolower($targetWord));
                $maxLen = max(mb_strlen($userWord), mb_strlen($targetWord));
                $similarity = $maxLen > 0 ? (1 - ($lev / $maxLen)) : 0;
            }

            if ($isExactMatch) {
                $correctCount++;
            }

            $diffList[] = [
                'target_word' => $targetWord,
                'user_word' => $userWord,
                'is_correct' => $isExactMatch,
                'is_close' => ($similarity >= 0.75), // Gần đúng (sai 1-2 ký tự)
            ];
        }

        $accuracy = $totalWords > 0 ? round(($correctCount / $totalWords) * 100, 1) : 0.0;

        return [
            'accuracy_percentage' => $accuracy,
            'is_passed' => ($accuracy >= 85.0),
            'total_words' => $totalWords,
            'correct_words' => $correctCount,
            'diff' => $diffList,
        ];
    }

    private function cleanPunctuation(string $text): string
    {
        // Loại bỏ dấu câu chấm, phẩy, chấm hỏi, ngoặc kép
        $cleaned = preg_replace('/[.,\/#!$%\^&\*;:{}=\-_`~()?"\']/u', '', $text);
        return trim(preg_replace('/\s+/', ' ', $cleaned));
    }
}
```

---

### 5.4. Service Phân Tích Lời Giải Linearthinking & Paraphrase

Tạo file: `app/Services/LinearthinkingExplanationService.php`

```php
<?php

namespace App\Services;

use App\Models\Question;

class LinearthinkingExplanationService
{
    /**
     * Định dạng dữ liệu giải thích câu hỏi chuẩn Linearthinking
     */
    public function formatExplanation(Question $question): array
    {
        return [
            'question_number' => $question->question_number,
            'correct_answer' => $question->correct_answer,
            'evidence_location' => $question->evidence_paragraph,
            'linearthinking' => [
                'sentence_simplification' => $question->linearthinking_structure,
                'connection_logic' => $question->linearthinking_logic,
            ],
            'paraphrase_table' => is_array($question->paraphrase_table) 
                ? $question->paraphrase_table 
                : json_decode($question->paraphrase_table ?? '[]', true),
        ];
    }
}
```

---

## 6. HỆ THỐNG ROUTING & RESTFUL API ENDPOINTS

### 6.1. Web Routes (`routes/web.php`)

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\DictationController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\WritingSampleController;
use App\Http\Controllers\SpeakingSampleController;
use App\Http\Controllers\AiWritingController;
use App\Http\Controllers\DashboardController;

// Trang chủ & Giới thiệu phương pháp
Route::get('/', [HomeController::class, 'index'])->name('home');

// Module 1: Luyện thi IELTS / TOEIC Online
Route::prefix('luyen-thi-ielts')->name('ielts.')->group(function () {
    Route::get('/free-ielts-online-test', [TestController::class, 'index'])->name('index');
    Route::get('/bo-de/{slug}', [TestController::class, 'showSet'])->name('set.show');
    Route::get('/take/{slug}', [TestController::class, 'takeExam'])->name('take');
    Route::post('/submit/{id}', [TestController::class, 'submit'])->name('submit');
    Route::get('/result/{submission_id}', [TestController::class, 'result'])->name('result');
});

// Module 2: Luyện Nghe Chép Chính Tả
Route::prefix('nghe-chep-chinh-ta')->name('dictation.')->group(function () {
    Route::get('/', [DictationController::class, 'index'])->name('index');
    Route::get('/{slug}', [DictationController::class, 'practice'])->name('practice');
});

// Module 3: Sổ Từ Vựng & Flashcard SRS
Route::middleware('auth')->prefix('so-tu-vung')->name('flashcards.')->group(function () {
    Route::get('/', [FlashcardController::class, 'index'])->name('index');
    Route::get('/study', [FlashcardController::class, 'studySession'])->name('study');
});

// Module 4: Bài Mẫu Writing & Speaking
Route::get('/bai-mau-ielts-writing', [WritingSampleController::class, 'index'])->name('writing.index');
Route::get('/bai-mau-ielts-writing/{slug}', [WritingSampleController::class, 'show'])->name('writing.show');
Route::get('/bai-mau-ielts-speaking', [SpeakingSampleController::class, 'index'])->name('speaking.index');
Route::get('/bai-mau-ielts-speaking/{slug}', [SpeakingSampleController::class, 'show'])->name('speaking.show');

// Module 5: AI Chấm Bài Writing
Route::middleware('auth')->prefix('ai-cham-bai')->name('ai.writing.')->group(function () {
    Route::get('/', [AiWritingController::class, 'index'])->name('index');
    Route::post('/grade', [AiWritingController::class, 'gradeEssay'])->name('grade');
    Route::get('/history/{id}', [AiWritingController::class, 'viewResult'])->name('result');
});

// Module 6: Dashboard Cá Nhân & Báo Cáo Tiến Độ
Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
```

### 6.2. RESTful API Endpoints (`routes/api.php`)

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DictionaryApiController;
use App\Http\Controllers\Api\FlashcardApiController;
use App\Http\Controllers\Api\DictationApiController;

// Tra từ điển 1-Click khi bôi đen trong bài đọc
Route::post('/dictionary/lookup', [DictionaryApiController::class, 'lookup']);

// Sổ từ vựng & Flashcard (Yêu cầu Token Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/flashcards/save-word', [FlashcardApiController::class, 'saveWordFromContext']);
    Route::post('/flashcards/submit-review', [FlashcardApiController::class, 'submitReview']);
    Route::get('/flashcards/due-today', [FlashcardApiController::class, 'getDueCards']);
    
    // So khớp câu chép chính tả
    Route::post('/dictation/verify-sentence', [DictationApiController::class, 'verifySentence']);
    Route::post('/dictation/save-progress', [DictationApiController::class, 'saveProgress']);
});
```

---

## 7. KIẾN TRÚC & THIẾT KẾ MODULE QUẢN TRỊ (ADMIN CMS - FILAMENT V3)

Hệ thống quản trị được tích hợp trực tiếp bằng **Filament PHP v3** (Admin Panel Builder số 1 cho Laravel 11):

1. **Quản lý Kho Đề Thi (Test Sets & Passages Resource):**
   * Rich-text Editor có hỗ trợ chèn thẻ paragraph markers `[A]`, `[B]`, `[C]`.
   * Giao diện tạo bộ câu hỏi dạng Repeater cho phép thêm nhanh 40 câu hỏi.
   * Input chuyên dụng để nhập cấu trúc câu S-V-O, logic liên kết và bảng Paraphrase JSON.
2. **Quản lý Nghe Chép Chính Tả (Dictation Audio Studio Resource):**
   * Upload file audio MP3.
   * Trình gắn Audio Timestamp Visualizer để phân tách từng câu kèm file âm thanh bắt đầu/kết thúc (VD: `00:15.20` -> `00:21.50`).
   * Soạn bản dịch tiếng Việt và ghi chú nối âm.
3. **Quản lý Bài Mẫu Writing / Speaking:**
   * Phân loại theo Task 1/2 và Speaking Parts.
   * Gắn tags từ vựng ăn điểm kèm gợi ý giải nghĩa.
4. **Quản trị Người Dùng & Báo Cáo Doanh Thu / Học Tập:**
   * Xem lịch sử nộp bài của từng học viên.
   * Biểu đồ trực quan lượng đề làm hàng ngày và xu hướng điểm số.

---

## 8. CẤU TRÚC THƯ MỤC CHUẨN CỦA DỰ ÁN LARAVEL 11

```
learn-english/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── DictionaryApiController.php
│   │   │   │   ├── FlashcardApiController.php
│   │   │   │   └── DictationApiController.php
│   │   │   ├── HomeController.php
│   │   │   ├── TestController.php
│   │   │   ├── DictationController.php
│   │   │   ├── FlashcardController.php
│   │   │   ├── WritingSampleController.php
│   │   │   ├── SpeakingSampleController.php
│   │   │   ├── AiWritingController.php
│   │   │   └── DashboardController.php
│   │   ├── Requests/
│   │   │   ├── SubmitTestRequest.php
│   │   │   └── SaveFlashcardRequest.php
│   │   └── Resources/
│   │       └── QuestionResource.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── TestCategory.php
│   │   ├── TestSet.php
│   │   ├── Test.php
│   │   ├── TestSection.php
│   │   ├── QuestionGroup.php
│   │   ├── Question.php
│   │   ├── TestSubmission.php
│   │   ├── UserAnswer.php
│   │   ├── DictationTopic.php
│   │   ├── DictationSentence.php
│   │   ├── UserDictationProgress.php
│   │   ├── Vocabulary.php
│   │   ├── UserFlashcard.php
│   │   ├── WritingSample.php
│   │   ├── SpeakingSample.php
│   │   ├── AiWritingEvaluation.php
│   │   └── UserStudyLog.php
│   ├── Services/
│   │   ├── IeltsScoringService.php
│   │   ├── SpacedRepetitionService.php
│   │   ├── DictationVerificationService.php
│   │   ├── LinearthinkingExplanationService.php
│   │   └── OpenAiGraderService.php
│   └── Filament/
│       └── Resources/
│           ├── TestResource.php
│           ├── DictationTopicResource.php
│           ├── VocabularyResource.php
│           └── WritingSampleResource.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── CambridgeIeltsSeeder.php
│       ├── DictationTopicSeeder.php
│       └── VocabularySeeder.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── app.js
│   │   ├── components/
│   │   │   ├── split-screen-tester.js
│   │   │   ├── dictation-player.js
│   │   │   ├── flashcard-deck.js
│   │   │   └── dictionary-popup.js
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php
│       │   ├── exam.blade.php
│       │   └── navbar.blade.php
│       ├── ielts/
│       │   ├── index.blade.php
│       │   ├── take.blade.php
│       │   └── result.blade.php
│       ├── dictation/
│       │   ├── index.blade.php
│       │   └── practice.blade.php
│       ├── flashcards/
│       │   ├── index.blade.php
│       │   └── study.blade.php
│       └── dashboard/
│           └── index.blade.php
├── routes/
│   ├── web.php
│   └── api.php
└── tailwind.config.js
```

---

## 9. HƯỚNG DẪN CÀI ĐẶT CHI TIẾT TỪNG BƯỚC (STEP-BY-STEP SETUP GUIDE)

### Bước 1: Yêu Cầu Môi Trường
* **PHP:** >= 8.2 (Bật các extension: `pdo_mysql`, `mbstring`, `openssl`, `curl`, `fileinfo`, `gd`).
* **Composer:** >= 2.6.
* **Node.js:** >= 18.x hoặc 20.x & **NPM** >= 9.x.
* **Cơ sở dữ liệu:** MySQL 8.0+ hoặc MariaDB 10.5+.

---

### Bước 2: Khởi Tạo Dự Án Laravel 11

Mở PowerShell tại thư mục làm việc `e:\Project_ItWebDev\PHP\learn-english` và thực thi:

```bash
# 1. Khởi tạo project Laravel 11
composer create-project laravel/laravel:^11.0 .

# 2. Cài đặt các gói PHP mở rộng cần thiết
composer require laravel/sanctum
composer require livewire/livewire
composer require filament/filament:"^3.2" --with-all-dependencies
```

---

### Bước 3: Cài Đặt Frontend & Thư Viện UI

```bash
# 1. Cài đặt Tailwind CSS và các plugins
npm install -D tailwindcss postcss autoprefixer @tailwindcss/forms @tailwindcss/typography

# 2. Khởi tạo file cấu hình Tailwind
npx tailwindcss init -p

# 3. Cài đặt thư viện Icons, Audio Player và UI Enhancements
npm install lucide alpinejs howler canvas-confetti apexcharts
```

---

### Bước 4: Cấu Hình File `tailwind.config.js`

Mở file `tailwind.config.js` và thay thế nội dung:

```javascript
/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./app/Filament/**/*.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#FFF1F2',
          100: '#FFE4E6',
          200: '#FECDD3',
          300: '#FDA4AF',
          400: '#FB7185',
          500: '#E11D48',
          600: '#BE123C',
          700: '#9F1239',
          800: '#881337',
          900: '#4C0519',
        },
        brand: {
          dark: '#0F172A',
          card: '#1E293B',
          accent: '#6366F1',
          success: '#10B981',
          warning: '#F59E0B',
        }
      },
      fontFamily: {
        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
        serif: ['Merriweather', 'Noto Serif', 'serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
```

---

### Bước 5: Cấu Hình Biến Môi Trường `.env`

Tạo hoặc chỉnh sửa file `.env`:

```env
APP_NAME="EduLearn English"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE="Asia/Ho_Chi_Minh"
APP_URL=http://127.0.0.1:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=learn_english_db
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Cấu hình OpenAI API (Dành cho Module AI Chấm Bài)
OPENAI_API_KEY=your_openai_api_key_here
```

---

### Bước 6: Chạy Migration & Seed Dữ Liệu

```bash
# 1. Tạo key ứng dụng
php artisan key:generate

# 2. Tạo link storage công khai cho audio và hình ảnh
php artisan storage:link

# 3. Chạy toàn bộ migrations
php artisan migrate

# 4. Cài đặt Admin Panel Filament
php artisan filament:install --panels

# 5. Tạo tài khoản Admin quản trị
php artisan make:filament-user

# 6. Chạy Seeder dữ liệu mẫu
php artisan db:seed
```

---

### Bước 7: Khởi Chạy Local Development

Mở 2 cửa sổ terminal:

```bash
# Terminal 1: Chạy máy chủ Laravel Backend
php artisan serve

# Terminal 2: Chạy trình biên dịch Vite Frontend
npm run dev
```

* **Trang người dùng học tập:** `http://127.0.0.1:8000`
* **Trang quản trị Admin CMS:** `http://127.0.0.1:8000/admin`

---

## 10. LỘ TRÌNH TRIỂN KHAI (ROADMAP)

| Giai Đoạn | Mục Tiêu Chính | Thời Gian |
| :--- | :--- | :--- |
| **Giai đoạn 1** | Khởi tạo khung Laravel 11, Migration 16 bảng CSDL, Thiết lập Layout và Design System | Tuần 1 |
| **Giai đoạn 2** | Xây dựng Phòng thi IELTS Split-Screen (Reading/Listening), Đồng hồ Timer, Lưu bài nộp | Tuần 2 |
| **Giai đoạn 3** | Tích hợp bộ chấm điểm Band tự động, Đánh dấu Highlight vị trí manh mối & Box tư duy Linearthinking | Tuần 3 |
| **Giai đoạn 4** | Xây dựng Trình Nghe Chép Chính Tả (Dictation Player), Waveform, Lặp A-B & So khớp từ realtime | Tuần 4 |
| **Giai đoạn 5** | Xây dựng Popup tra từ 1-Click & Sổ từ vựng Flashcard lật 3D thuật toán SuperMemo SM-2 | Tuần 5 |
| **Giai đoạn 6** | Xây dựng Kho bài mẫu Writing & Speaking, Dashboard phân tích biểu đồ Radar điểm yếu | Tuần 6 |
| **Giai đoạn 7** | Tích hợp AI Chấm bài Writing, Hoàn thiện Admin CMS Filament v3 & Tối ưu Responsive Mobile | Tuần 7 |

---
*Tài liệu được thiết kế chi tiết và sẵn sàng để lập trình viên bắt tay vào triển khai ngay lập tức.*
