<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Currency;
use App\Models\Fee;
use App\Models\Invoice;
use App\Models\PaymentVoucher;
use App\Models\Receipt;
use App\Models\StudentDiscount;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Activitylog\Models\Activity;

/**
 * @extends Factory<Activity>
 */
class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $event = fake()->randomElement(['created', 'updated', 'deleted']);
        $subjectType = fake()->randomElement([
            Invoice::class,
            Currency::class,
            Fee::class,
            PaymentVoucher::class,
            Receipt::class,
            StudentDiscount::class,
        ]);

        $logNames = [
            Invoice::class => 'Finance - Invoices',
            Currency::class => 'Finance - Currencies',
            Fee::class => 'Finance - Fees',
            PaymentVoucher::class => 'Finance - Payment Vouchers',
            Receipt::class => 'Finance - Receipts',
            StudentDiscount::class => 'Finance - Student Discounts',
        ];

        $properties = $this->generateProperties($event, $subjectType);

        return [
            'log_name' => $logNames[$subjectType],
            'description' => $event,
            'subject_type' => $subjectType,
            'subject_id' => fake()->numberBetween(1, 100),
            'event' => $event,
            'causer_type' => Admin::class,
            'causer_id' => 1, // Default admin
            'properties' => $properties,
            'batch_uuid' => fake()->optional(0.3)->uuid(),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Generate properties based on event and subject type.
     */
    protected function generateProperties(string $event, string $subjectType): array
    {
        $attributes = $this->generateAttributes($subjectType);

        if ($event === 'updated') {
            $oldAttributes = $this->generateAttributes($subjectType);

            return [
                'attributes' => $attributes,
                'old' => $oldAttributes,
            ];
        }

        return [
            'attributes' => $attributes,
        ];
    }

    /**
     * Generate attributes based on subject type.
     */
    protected function generateAttributes(string $subjectType): array
    {
        return match ($subjectType) {
            Invoice::class => [
                'amount' => fake()->randomFloat(2, 50, 1000),
                'description' => fake()->sentence(),
                'invoice_date' => fake()->date(),
            ],
            Currency::class => [
                'name' => fake()->currencyCode(),
                'code' => fake()->currencyCode(),
                'symbol' => fake()->randomElement(['$', '€', '£', '¥']),
                'is_active' => fake()->boolean(80),
            ],
            Fee::class => [
                'title' => fake()->words(3, true),
                'amount' => fake()->randomFloat(2, 100, 5000),
                'year_id' => fake()->numberBetween(1, 5),
            ],
            PaymentVoucher::class => [
                'amount' => fake()->randomFloat(2, 50, 500),
                'description' => fake()->sentence(),
                'payment_date' => fake()->date(),
            ],
            Receipt::class => [
                'amount' => fake()->randomFloat(2, 100, 2000),
                'description' => fake()->sentence(),
                'receipt_date' => fake()->date(),
            ],
            StudentDiscount::class => [
                'discount_type' => fake()->randomElement(['percentage', 'fixed']),
                'value' => fake()->randomFloat(2, 5, 50),
                'description' => fake()->sentence(),
            ],
            default => [
                'name' => fake()->word(),
                'value' => fake()->word(),
            ],
        };
    }

    /**
     * State for created event.
     */
    public function created(): static
    {
        return $this->state(fn(array $attributes) => [
            'event' => 'created',
            'description' => 'created',
            'properties' => $this->generateProperties('created', $attributes['subject_type']),
        ]);
    }

    /**
     * State for updated event.
     */
    public function updated(): static
    {
        return $this->state(fn(array $attributes) => [
            'event' => 'updated',
            'description' => 'updated',
            'properties' => $this->generateProperties('updated', $attributes['subject_type']),
        ]);
    }

    /**
     * State for deleted event.
     */
    public function deleted(): static
    {
        return $this->state(fn(array $attributes) => [
            'event' => 'deleted',
            'description' => 'deleted',
            'properties' => $this->generateProperties('deleted', $attributes['subject_type']),
        ]);
    }

    /**
     * State for specific log name.
     */
    public function forLogName(string $logName): static
    {
        return $this->state(fn(array $attributes) => [
            'log_name' => $logName,
        ]);
    }

    /**
     * State for specific subject.
     */
    public function forSubject(string $subjectType, int $subjectId): static
    {
        return $this->state(fn(array $attributes) => [
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'properties' => $this->generateProperties($attributes['event'], $subjectType),
        ]);
    }

    /**
     * State for specific causer.
     */
    public function byCauser(string $causerType, int $causerId): static
    {
        return $this->state(fn(array $attributes) => [
            'causer_type' => $causerType,
            'causer_id' => $causerId,
        ]);
    }
}
