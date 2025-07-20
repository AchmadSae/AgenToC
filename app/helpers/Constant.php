<?php

namespace App\Helpers;

class Constant
{
    public const ROLE_ADMIN = 'RADMIN';
    public const ROLE_CLIENT = 'RUSER';
    public const ROLE_WORKER = 'RWORKER';
    public const TASK_FULLTIME = 'fulltime';
    public const TASK_HOURS = 'hours';
    public const TASK_INQUIRY = 'inquiry';
    public const ID_TASK = 'TSK';
    public const ID_TASK_DETAIL = 'TSKDTL';
    public const TRANS_DEPOSIT = 'coins';
    public const TRANS_PRODUCT = 'product';
    public const TASK_PENDING = 'pending';
    public const TASK_APPROVED = 'approved';
    public const TASK_REJECTED = 'rejected';
    public const TASK_COMPLETED = 'completed';
    public const TASK_CANCELLED = 'cancelled';
    public const GAS_USER = 'GAS_FEE_USER';
    public const GAS_WORKER = 'GAS_FEE_WORKER';
    public const MAX_ATTEMPTS = 5;
    public const PAYMENT_BANK = 'transfer_bank';
}
