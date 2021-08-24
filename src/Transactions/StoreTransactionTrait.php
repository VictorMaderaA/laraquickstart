<?php

namespace VictorMaderaA\LaraQuickStart\Transactions;

trait StoreTransactionTrait
{

    protected static function boot()
    {
        parent::boot();
        static::observe(ModelTransactionObserver::class);
    }

}
