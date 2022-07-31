<?php

namespace App\Enum;

class MessagesEnum
{
    /**
     * App Messages
     */
    const APP_SUCCESS_DELETE = 'App successful deleted';
    const APP_NOT_FOUND = ['App not Found', 404];
    const APP_SOMETHING_WENT_WRONG = ['Something went wrong in App Model', 400];
    /**
     * Device Messages
     */
    const DEVICE_SUCCESS_DELETE = 'Device successful deleted';
    const DEVICE_NOT_FOUND = ['Device not Found', 404];
    const DEVICE_CLIENT_NOT_FOUND = ['Device client-token not Found', 404];
    const DEVICE_NOT_CHANGED = ['Device not changed', 400];
    const DEVICE_DUPLICATE = ['Device already exist', 400];
    const DEVICE_SOMETHING_WENT_WRONG = ['Something went wrong in Device Model', 400];
    /**
     * Purchase Messages
     */
    const PURCHASE_SUCCESS_DELETE = 'Device successful deleted';
    const PURCHASE_RATE_LIMIT = 'Rate limit conditions';
    const PURCHASE_ADDED_JOB = '%s purchase job added.';
    const PURCHASE_SUB_STARTED = 'Subscription started';
    const PURCHASE_SUB_RENEWED = 'Subscription renewed';
    const PURCHASE_SUB_CANCELED = 'Subscription canceled';
    const PURCHASE_NOT_FOUND = ['Purchase not Found', 404];
    const PURCHASE_SOMETHING_WENT_WRONG = ['Something went wrong in Purchase Model', 400];
    const PURCHASE_NOT_VERIFY = ['Purchase could not be verified', 400];
    /**
     * Callback Messages
     */
    const CALLBACK_SUCCESS = 'Callback is successful';
    const CALLBACK_FAILED = 'Callback is failed';

}