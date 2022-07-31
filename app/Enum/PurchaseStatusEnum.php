<?php

namespace App\Enum;

class PurchaseStatusEnum
{
    /**
     * Purchase Enum
     */
    const PURCHASE_STATUS_ACTIVE = 1;
    const PURCHASE_STATUS_PASSIVE = 0;

    /**
     * Purchase Status For Human
     * @param $status
     * @return array|string
     */
    public static function purchaseStatusHuman($status = null): array|string
    {
        $data = [
            self::PURCHASE_STATUS_ACTIVE => 'Active',
            self::PURCHASE_STATUS_PASSIVE => 'Passive',
        ];
        return $status !== null ? $data[$status] : $data;
    }
}