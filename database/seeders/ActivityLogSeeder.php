<?php

namespace Database\Seeders;

use App\Models\Finance\Currency;
use App\Models\Finance\Fee;
use App\Models\Finance\Invoice;
use App\Models\Finance\PaymentVoucher;
use App\Models\Finance\Receipt;
use App\Models\Finance\StudentDiscount;
use Database\Factories\ActivityFactory;
use Illuminate\Database\Seeder;
use Spatie\Activitylog\Models\Activity;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding activity logs...');

        // Clear existing activity logs
        Activity::query()->delete();

        // Create various activity logs
        $this->createInvoiceActivities();
        $this->createCurrencyActivities();
        $this->createFeeActivities();
        $this->createPaymentVoucherActivities();
        $this->createReceiptActivities();
        $this->createStudentDiscountActivities();
        $this->createBatchActivities();

        $totalCount = Activity::count();
        $this->command->info("Created {$totalCount} activity log entries.");
    }

    /**
     * Create invoice-related activities.
     */
    protected function createInvoiceActivities(): void
    {
        // Created invoices
        ActivityFactory::new()
            ->count(15)
            ->created()
            ->forLogName('Finance - Invoices')
            ->forSubject(Invoice::class, fake()->numberBetween(1, 50))
            ->create();

        // Updated invoices
        ActivityFactory::new()
            ->count(10)
            ->updated()
            ->forLogName('Finance - Invoices')
            ->forSubject(Invoice::class, fake()->numberBetween(1, 50))
            ->create();

        // Deleted invoices
        ActivityFactory::new()
            ->count(5)
            ->deleted()
            ->forLogName('Finance - Invoices')
            ->forSubject(Invoice::class, fake()->numberBetween(1, 50))
            ->create();
    }

    /**
     * Create currency-related activities.
     */
    protected function createCurrencyActivities(): void
    {
        ActivityFactory::new()
            ->count(8)
            ->created()
            ->forLogName('Finance - Currencies')
            ->forSubject(Currency::class, fake()->numberBetween(1, 10))
            ->create();

        ActivityFactory::new()
            ->count(12)
            ->updated()
            ->forLogName('Finance - Currencies')
            ->forSubject(Currency::class, fake()->numberBetween(1, 10))
            ->create();
    }

    /**
     * Create fee-related activities.
     */
    protected function createFeeActivities(): void
    {
        ActivityFactory::new()
            ->count(10)
            ->created()
            ->forLogName('Finance - Fees')
            ->forSubject(Fee::class, fake()->numberBetween(1, 30))
            ->create();

        ActivityFactory::new()
            ->count(8)
            ->updated()
            ->forLogName('Finance - Fees')
            ->forSubject(Fee::class, fake()->numberBetween(1, 30))
            ->create();

        ActivityFactory::new()
            ->count(3)
            ->deleted()
            ->forLogName('Finance - Fees')
            ->forSubject(Fee::class, fake()->numberBetween(1, 30))
            ->create();
    }

    /**
     * Create payment voucher-related activities.
     */
    protected function createPaymentVoucherActivities(): void
    {
        ActivityFactory::new()
            ->count(12)
            ->created()
            ->forLogName('Finance - Payment Vouchers')
            ->forSubject(PaymentVoucher::class, fake()->numberBetween(1, 40))
            ->create();

        ActivityFactory::new()
            ->count(6)
            ->updated()
            ->forLogName('Finance - Payment Vouchers')
            ->forSubject(PaymentVoucher::class, fake()->numberBetween(1, 40))
            ->create();
    }

    /**
     * Create receipt-related activities.
     */
    protected function createReceiptActivities(): void
    {
        ActivityFactory::new()
            ->count(20)
            ->created()
            ->forLogName('Finance - Receipts')
            ->forSubject(Receipt::class, fake()->numberBetween(1, 60))
            ->create();

        ActivityFactory::new()
            ->count(5)
            ->updated()
            ->forLogName('Finance - Receipts')
            ->forSubject(Receipt::class, fake()->numberBetween(1, 60))
            ->create();
    }

    /**
     * Create student discount-related activities.
     */
    protected function createStudentDiscountActivities(): void
    {
        ActivityFactory::new()
            ->count(10)
            ->created()
            ->forLogName('Finance - Student Discounts')
            ->forSubject(StudentDiscount::class, fake()->numberBetween(1, 25))
            ->create();

        ActivityFactory::new()
            ->count(7)
            ->updated()
            ->forLogName('Finance - Student Discounts')
            ->forSubject(StudentDiscount::class, fake()->numberBetween(1, 25))
            ->create();

        ActivityFactory::new()
            ->count(4)
            ->deleted()
            ->forLogName('Finance - Student Discounts')
            ->forSubject(StudentDiscount::class, fake()->numberBetween(1, 25))
            ->create();
    }

    /**
     * Create batch activities (activities with same batch UUID).
     */
    protected function createBatchActivities(): void
    {
        $batchUuid = fake()->uuid();

        // Create multiple activities with the same batch UUID
        ActivityFactory::new()
            ->count(5)
            ->state([
                'batch_uuid' => $batchUuid,
                'log_name' => 'Finance - Invoices',
                'subject_type' => Invoice::class,
            ])
            ->create();

        $this->command->info("Created batch activities with UUID: {$batchUuid}");
    }
}
