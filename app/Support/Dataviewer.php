<?php

namespace App\Support;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\ValidationException;

trait Dataviewer
{
    public function scopeAdvancedFilter($query, $columns = [])
    {
        $result = $this->process($query, request()->all());

        $orderColumn = request('order_column', 'created_at');
        $orderDirection = request('order_direction', 'desc');

        $this->applyOrdering($result, $orderColumn, $orderDirection);

        return $result->paginate(request('limit', 10));
    }

    /**
     * Applies ordering, resolving relation columns (e.g. "kategori.name")
     * into a subquery so the database can sort properly.
     */
    protected function applyOrdering($query, string $column, string $direction): void
    {
        if (strpos($column, '.') === false) {
            $query->orderBy($column, $direction);

            return;
        }

        [$relationName, $relatedColumn] = explode('.', $column, 2);

        if (! method_exists($this, $relationName)) {
            $query->orderBy($column, $direction);

            return;
        }

        $relation = $this->{$relationName}();

        if ($relation instanceof BelongsTo) {
            $relatedTable = $relation->getRelated()->getTable();
            $foreignKey = $relation->getForeignKeyName();
            $ownerKey = $relation->getOwnerKeyName();

            $subQuery = $relation->getRelated()->newQuery()
                ->select($relatedColumn)
                ->whereColumn("{$relatedTable}.{$ownerKey}", "{$this->getTable()}.{$foreignKey}")
                ->limit(1);

            $query->orderBy($subQuery, $direction);
        } elseif ($relation instanceof HasOne) {
            $relatedTable = $relation->getRelated()->getTable();
            $foreignKey = $relation->getForeignKeyName();
            $localKey = $relation->getLocalKeyName();

            $subQuery = $relation->getRelated()->newQuery()
                ->select($relatedColumn)
                ->whereColumn("{$relatedTable}.{$foreignKey}", "{$this->getTable()}.{$localKey}")
                ->limit(1);

            $query->orderBy($subQuery, $direction);
        } else {
            $query->orderBy($column, $direction);
        }
    }

    public function process($query, $data)
    {
        $v = validator()->make($data, [
            'order_column' => 'sometimes|required|in:'.$this->orderableColumns(),
            'order_direction' => 'sometimes|required|in:asc,desc',

            'limit' => 'sometimes|required|integer|min:1',

            // advanced filter
            'filter_match' => 'sometimes|required|in:and,or',
            'f' => 'sometimes|required|array',
            'f.*.column' => 'required|in:'.$this->whiteListColumns(),
            'f.*.operator' => 'required_with:f.*.column|in:'.$this->allowedOperators(),
            'f.*.query_1' => 'required',
            'f.*.query_2' => 'required_if:f.*.operator,between,not_between',
        ]);

        if ($v->fails()) {
            throw ValidationException::withMessages($v->errors()->toArray());
        }

        return (new CustomQueryBuilder)->apply($query, $data, $this->allowedFilters);
    }

    protected function whiteListColumns(): string
    {
        return implode(',', array_merge(['*'], $this->allowedFilters));
    }

    protected function orderableColumns(): string
    {
        return implode(',', $this->orderable);
    }

    protected function allowedOperators(): string
    {
        return implode(',', [
            'equal_to',
            'not_equal_to',
            'less_than',
            'greater_than',
            'between',
            'not_between',
            'contains',
            'starts_with',
            'ends_with',
            'in_the_past',
            'in_the_next',
            'in_the_peroid',
            'less_than_count',
            'greater_than_count',
            'equal_to_count',
            'not_equal_to_count',
        ]);
    }
}
