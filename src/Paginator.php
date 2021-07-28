<?php


namespace VictorMaderaA\LaraQuickStart;


use Illuminate\Pagination\LengthAwarePaginator;

class Paginator extends LengthAwarePaginator
{

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'links' => [
                'self' => $this->url($this->currentPage()),
                'first' => $this->url(1),
                'last' => $this->url($this->lastPage()),
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl(),
            ],
            'meta' => [
                'last_page' => $this->lastPage(),
                'current_page' => $this->currentPage(),
                'path' => $this->path(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
            ],
            'resources' => $this->items->toArray(),
        ];
    }


}
