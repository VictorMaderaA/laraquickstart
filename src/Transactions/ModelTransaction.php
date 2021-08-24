<?php

namespace VictorMaderaA\LaraQuickStart\Transactions;


use VictorMaderaA\LaraQuickStart\AbstractModel;

class ModelTransaction extends AbstractModel
{

    public const TYPE_CREATED = 'created';
    public const TYPE_UPDATED = 'updated';
    public const TYPE_DELETED = 'deleted';

}
