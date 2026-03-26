<?php

namespace App\DTOs;

readonly class ActivityLogFilterDTO
{
    public function __construct(
        public ?string $logName = null,
        public ?string $event = null,
        public ?string $subjectType = null,
        public ?int $subjectId = null,
        public ?string $causerType = null,
        public ?int $causerId = null,
        public ?string $batchUuid = null,
        public ?string $startDate = null,
        public ?string $endDate = null,
        public ?string $search = null,
        public int $perPage = 15,
    ) {}

    /**
     * Create from array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            logName: $data['log_name'] ?? null,
            event: $data['event'] ?? null,
            subjectType: $data['subject_type'] ?? null,
            subjectId: isset($data['subject_id']) ? (int) $data['subject_id'] : null,
            causerType: $data['causer_type'] ?? null,
            causerId: isset($data['causer_id']) ? (int) $data['causer_id'] : null,
            batchUuid: $data['batch_uuid'] ?? null,
            startDate: $data['start_date'] ?? null,
            endDate: $data['end_date'] ?? null,
            search: $data['search'] ?? null,
            perPage: isset($data['per_page']) ? (int) $data['per_page'] : 15,
        );
    }

    /**
     * Convert to array for repository.
     */
    public function toArray(): array
    {
        return array_filter([
            'log_name' => $this->logName,
            'event' => $this->event,
            'subject_type' => $this->subjectType,
            'subject_id' => $this->subjectId,
            'causer_type' => $this->causerType,
            'causer_id' => $this->causerId,
            'batch_uuid' => $this->batchUuid,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'search' => $this->search,
        ], fn($value) => $value !== null);
    }
}
