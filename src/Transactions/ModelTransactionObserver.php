<?php

namespace VictorMaderaA\LaraQuickStart\Transactions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ModelTransactionObserver
{
    /**
     * Handle the Model "created" event.
     *
     * @return void
     */
    public function created(Model $model)
    {
        $this->createTransaction($model, ModelTransaction::TYPE_CREATED);
    }

    /**
     * Handle the Model "updated" event.
     *
     * @return void
     */
    public function updated(Model $model)
    {
        $this->createTransaction($model, ModelTransaction::TYPE_UPDATED);
    }

    /**
     * Handle the Model "deleted" event.
     *
     * @return void
     */
    public function deleted(Model $model)
    {
        $this->createTransaction($model, ModelTransaction::TYPE_UPDATED);
    }

    /**
     * Handle the Model "forceDeleted" event.
     *
     * @return void
     */
    public function forceDeleted(Model $model)
    {
        $this->createTransaction($model, ModelTransaction::TYPE_DELETED);
    }

    private function createTransaction(Model $model, string $type)
    {
        if ($updatedBy_id = Auth::id()) {
            $updatedBy_model = get_class(Auth::user());
        }

        $updatedAttributes = $model->getDirty();
        $snapshot = $model->getAttributes();

        $transaction = new ModelTransaction();
        $transaction->setAttribute('updated_by', $updatedBy_id ?? null);
        $transaction->setAttribute('updated_byModel', $updatedBy_model ?? null);
        $transaction->setAttribute('updated_id', $model->getKey());
        $transaction->setAttribute('updated_model', get_class($model));
        $transaction->setAttribute('type', $type);
        $transaction->setAttribute('updated_data', json_encode($updatedAttributes, 1));
        $transaction->setAttribute('snapshot', json_encode($snapshot, 1));
        $transaction->save();
    }
}
