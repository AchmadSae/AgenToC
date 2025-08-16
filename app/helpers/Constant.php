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
    public const TASK_STATUS_IN_PROGRESS = 'in_progress';
    public const TASK_STATUS_APPROVED = 'approved';
    public const TASK_STATUS_REJECTED = 'rejected';
    public const TASK_STATUS_COMPLETED = 'completed';
    public const TASK_STATUS_CANCEL = 'cancel';
    public const GAS_USER = 'GAS_FEE_USER';
    public const GAS_WORKER = 'GAS_FEE_WORKER';
    public const MAX_ATTEMPTS = 5;
    public const PAYMENT_BANK = 'transfer_bank';
    public const ADMIN_CEO_LEVEL = 'ceo';
    public const ADMIN_MANAGER_LEVEL = 'manager';
    public const ADMIN_REGULAR_LEVEL = 'regular';
    public const DB_ATTEMPT = 5;
      const GAS_USER_TICKET = 'GAS_USER_TICKET';
      const TASK_STATUS_OPEN = 'open';
      const TASK_STATUS_REVISION = 'revision';
      const SUBTASK_STATUS_TODO = 'todo';
      const SUBTASK_STATUS_DONE = 'done';
      const TRANS_ID = 'INV';
      const PRODUCT_GRAPHIC = 'design_graphic';
      const FILE_TYPE_CHECKOUT = 'checkout';
      const DEFAULT_PASS = 'DEFAULT_PASS';
      const TASK_TYPE_CATALOG_PRODUCT = 'catalog_product';
}
