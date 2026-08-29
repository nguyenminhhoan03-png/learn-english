<?php

declare(strict_types=1);

namespace Core\Contexts\Testing\Application\Queries;

use App\Models\TestSubmission;
use Core\Shared\Application\Bus\QueryHandlerInterface;
use Core\Shared\Domain\Exceptions\DomainException;

final class GetSubmissionResultQueryHandler implements QueryHandlerInterface
{
    public function handle(GetSubmissionResultQuery $query): TestSubmission
    {
        $submission = TestSubmission::with([
            'test.sections.questionGroups.questions',
            'answers.question',
            'user',
        ])->find($query->submissionId);

        if (!$submission) {
            throw new DomainException("Kết quả bài thi #{$query->submissionId} không tồn tại.");
        }

        if ($query->userId !== null && $submission->user_id !== $query->userId) {
            throw new DomainException("Bạn không có quyền xem kết quả bài thi này.");
        }

        return $submission;
    }
}
