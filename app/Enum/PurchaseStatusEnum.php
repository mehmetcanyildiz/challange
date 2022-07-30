<?php

namespace App\Enum;

class PurchaseStatusEnum
{
    /**
     * Purchase Enum
     */
    const PURCHASE_STATUS_FAILED = 15;
    const PURCHASE_STATUS_COMPLETED = 10;
    const PURCHASE_STATUS_PROCESSING = 5;
    const PURCHASE_STATUS_PENDING = 0;

    /**
     * Purchase Status For Human
     * @param $status
     * @return array|string
     */
    public static function purchaseStatusHuman($status = null): array|string
    {
        $data = [
            self::PURCHASE_STATUS_FAILED => 'Failed',
            self::PURCHASE_STATUS_COMPLETED => 'Completed',
            self::PURCHASE_STATUS_PROCESSING => 'Processing',
            self::PURCHASE_STATUS_PENDING => 'Pending',
        ];
        return $status !== null ? $data[$status] : $data;
    }
}