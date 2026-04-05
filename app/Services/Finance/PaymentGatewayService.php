<?php

namespace App\Services\Finance;

use App\Models\PaymentGateway;
use App\Services\Payments\PaymentGatewayManager;
use Illuminate\Support\Collection;

class PaymentGatewayService
{
    public function __construct(
        private readonly PaymentGatewayManager $manager,
    ) {}

    /**
     * Get all registered processors merged with their DB records.
     * Returns a collection of arrays with processor info + gateway model (if exists).
     */
    public function getGatewaysForManagement(): Collection
    {
        $registeredProcessors = $this->manager->getRegisteredProcessors();
        $existingGateways = PaymentGateway::all()->keyBy('code');

        return collect($registeredProcessors)->map(function ($processorData, $code) use ($existingGateways) {
            $processor = $this->manager->resolve($code);
            $gateway = $existingGateways->get($code);
            
            $icon = is_array($processorData) ? ($processorData['icon'] ?? 'las la-credit-card') : 'las la-credit-card';
            $colors = is_array($processorData) ? ($processorData['colors'] ?? []) : [];

            return [
                'code'       => $code,
                'icon'       => $icon,
                'colors'     => $colors,
                'processor'  => $processor,
                'is_online'  => $processor->isOnline(),
                'has_settings' => !empty($processor->settingsSchema()),
                'gateway'    => $gateway,
                'is_activated' => $gateway !== null,
                'name'       => $gateway ? $gateway->name : $this->generateDefaultName($code),
                'status'     => $gateway ? $gateway->status : false,
                'surcharge'  => $gateway ? $gateway->surcharge_percentage : 0,
                'settings'   => $gateway ? ($gateway->settings ?? []) : [],
            ];
        })->values();
    }

    /**
     * Activate a gateway from a registered processor code.
     */
    public function activateGateway(string $code, array $data): PaymentGateway
    {
        if (!$this->manager->hasProcessor($code)) {
            throw new \InvalidArgumentException("No processor registered for code: [{$code}]");
        }

        return PaymentGateway::create([
            'code'                 => $code,
            'name'                 => $data['name'] ?? $this->generateDefaultName($code),
            'settings'             => $data['settings'] ?? null,
            'surcharge_percentage' => $data['surcharge_percentage'] ?? 0,
            'status'               => $data['status'] ?? true,
        ]);
    }

    /**
     * Toggle the status of a gateway (enable/disable).
     */
    public function toggleStatus(PaymentGateway $paymentGateway): PaymentGateway
    {
        if ($paymentGateway->status && $paymentGateway->receipts()->exists()) {
            throw new \Exception(trans('admin.Finance.messages.failed.payment_gateway_in_use'));
        }

        $paymentGateway->update(['status' => !$paymentGateway->status]);

        return $paymentGateway->fresh();
    }

    public function update(PaymentGateway $paymentGateway, array $data): PaymentGateway
    {
        $paymentGateway->update($data);
        return $paymentGateway;
    }

    /**
     * Generate a human-readable default name from a gateway code.
     */
    private function generateDefaultName(string $code): string
    {
        $name = str_replace('_', ' ', $code);
        return ucwords($name);
    }
}
