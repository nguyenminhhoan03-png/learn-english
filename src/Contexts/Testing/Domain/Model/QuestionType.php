<?php

declare(strict_types=1);

namespace Core\Contexts\Testing\Domain\Model;

enum QuestionType: string
{
    case MULTIPLE_CHOICE_SINGLE = 'multiple_choice_single';
    case MULTIPLE_CHOICE_MULTIPLE = 'multiple_choice_multiple';
    case TRUE_FALSE_NOT_GIVEN = 'true_false_not_given';
    case YES_NO_NOT_GIVEN = 'yes_no_not_given';
    case MATCHING_HEADINGS = 'matching_headings';
    case MATCHING_INFORMATION = 'matching_information';
    case MATCHING_FEATURES = 'matching_features';
    case FILL_IN_THE_BLANK = 'fill_in_the_blank';
    case DRAG_AND_DROP = 'drag_and_drop';

    public function label(): string
    {
        return match ($this) {
            self::MULTIPLE_CHOICE_SINGLE => 'Trắc nghiệm 1 đáp án',
            self::MULTIPLE_CHOICE_MULTIPLE => 'Trắc nghiệm nhiều đáp án',
            self::TRUE_FALSE_NOT_GIVEN => 'True / False / Not Given',
            self::YES_NO_NOT_GIVEN => 'Yes / No / Not Given',
            self::MATCHING_HEADINGS => 'Nối tiêu đề (Matching Headings)',
            self::MATCHING_INFORMATION => 'Nối thông tin (Matching Information)',
            self::MATCHING_FEATURES => 'Nối đặc điểm / tên chuyên gia',
            self::FILL_IN_THE_BLANK => 'Điền vào chỗ trống',
            self::DRAG_AND_DROP => 'Kéo thả từ vựng',
        };
    }
}
