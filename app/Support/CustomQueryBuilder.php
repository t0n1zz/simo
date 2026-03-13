<?php

namespace App\Support;

use Illuminate\Support\Str;

class CustomQueryBuilder
{
    /** @var array<string> */
    protected array $allowedFilters = [];

    public function apply($query, $data, array $allowedFilters = [])
    {
        $this->allowedFilters = $allowedFilters;

        if (isset($data['f'])) {
            foreach ($data['f'] as $filter) {
                $filter['match'] = $data['filter_match'] ?? 'and';
                $this->makeFilter($query, $filter);
            }
        }

        return $query;
    }

    protected function makeFilter($query, $filter)
    {
        if ($filter['column'] === '*') {
            $this->globalSearch($filter, $query);

            return;
        }

        if (strpos($filter['column'], '.') !== false) {
            [$relation, $filter['column']] = explode('.', $filter['column']);
            $filter['match'] = 'and';

            if ($filter['column'] == 'count') {
                $this->{Str::camel($filter['operator'])}($filter, $query, $relation);
            } else {
                $query->whereHas($relation, function ($q) use ($filter) {
                    $this->{Str::camel($filter['operator'])}($filter, $q);
                });
            }
        } else {
            $this->{Str::camel($filter['operator'])}($filter, $query);
        }
    }

    /**
     * Searches across all allowed filter columns using OR conditions.
     * Only includes columns that exist on the model's table (skips virtual attributes like
     * has_artikel_count, utamakan when not a real column, etc.).
     * Supports nested relation columns (e.g. pekerjaan_aktif.cu.name) via nested whereHas.
     */
    protected function globalSearch(array $filter, $query): void
    {
        $searchTerm = trim((string) ($filter['query_1'] ?? request()->input('f.0.query_1') ?? ''));
        if ($searchTerm === '') {
            return;
        }

        $model = $query->getModel();
        $tableColumns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());

        $query->where(function ($q) use ($searchTerm, $tableColumns) {
            foreach ($this->allowedFilters as $column) {
                if (strpos($column, '.') !== false) {
                    $parts = explode('.', $column);
                    if (end($parts) === 'count') {
                        continue;
                    }
                    if (count($parts) === 2) {
                        [$relation, $relatedColumn] = $parts;
                        $q->orWhereHas($relation, function ($subQ) use ($searchTerm, $relatedColumn) {
                            $subQ->where($relatedColumn, 'like', '%'.$searchTerm.'%');
                        });
                    } else {
                        $column = array_pop($parts);
                        $this->globalSearchNestedRelation($q, $parts, $column, $searchTerm);
                    }
                } elseif (in_array($column, $tableColumns, true)) {
                    $q->orWhere($column, 'like', '%'.$searchTerm.'%');
                }
            }
        });
    }

    /**
     * Builds nested whereHas for relation paths like pekerjaan_aktif.cu.name.
     * The top-level call uses orWhereHas (OR with other search columns);
     * deeper levels use whereHas (AND within the relation chain).
     */
    protected function globalSearchNestedRelation($query, array $relationChain, string $column, string $searchTerm): void
    {
        $relation = array_shift($relationChain);

        $query->orWhereHas($relation, function ($subQ) use ($relationChain, $column, $searchTerm) {
            $this->applyDeepWhereHas($subQ, $relationChain, $column, $searchTerm);
        });
    }

    /**
     * Recursively applies whereHas (AND) for deeper levels of the relation chain.
     */
    private function applyDeepWhereHas($query, array $relationChain, string $column, string $searchTerm): void
    {
        if (empty($relationChain)) {
            $query->where($column, 'like', '%'.$searchTerm.'%');

            return;
        }

        $relation = array_shift($relationChain);
        $query->whereHas($relation, function ($subQ) use ($relationChain, $column, $searchTerm) {
            $this->applyDeepWhereHas($subQ, $relationChain, $column, $searchTerm);
        });
    }

    public function equalTo($filter, $query)
    {
        return $query->where($filter['column'], '=', $filter['query_1'], $filter['match']);
    }

    public function notEqualTo($filter, $query)
    {
        return $query->where($filter['column'], '<>', $filter['query_1'], $filter['match']);
    }

    public function lessThan($filter, $query)
    {
        return $query->where($filter['column'], '<', $filter['query_1'], $filter['match']);
    }

    public function greaterThan($filter, $query)
    {
        return $query->where($filter['column'], '>', $filter['query_1'], $filter['match']);
    }

    public function between($filter, $query)
    {
        return $query->whereBetween($filter['column'], [
            $filter['query_1'], $filter['query_2'],
        ], $filter['match']);
    }

    public function notBetween($filter, $query)
    {
        return $query->whereNotBetween($filter['column'], [
            $filter['query_1'], $filter['query_2'],
        ], $filter['match']);
    }

    public function contains($filter, $query)
    {
        return $query->where($filter['column'], 'like', '%'.$filter['query_1'].'%', $filter['match']);
    }

    public function startsWith($filter, $query)
    {
        return $query->where($filter['column'], 'like', $filter['query_1'].'%', $filter['match']);
    }

    public function endsWith($filter, $query)
    {
        return $query->where($filter['column'], 'like', '%'.$filter['query_1'], $filter['match']);
    }

    public function inThePast($filter, $query)
    {
        $end = now()->endOfDay();

        $begin = now();

        switch ($filter['query_2']) {
            case 'hours':
                $begin->subHours($filter['query_1']);
                break;
            case 'days':
                $begin->subDays($filter['query_1'])->startOfDay();
                break;

            case 'months':
                $begin->subMonths($filter['query_1'])->startOfDay();
                break;

            case 'years':
                $begin->subYears($filter['query_1'])->startOfDay();
                break;

            default:
                $begin->subDays($filter['query_1'])->startOfDay();
                break;
        }

        return $query->whereBetween($filter['column'], [$begin, $end], $filter['match']);
    }

    public function inTheNext($filter, $query)
    {
        $begin = now()->startOfDay();

        $end = now();

        switch ($filter['query_2']) {
            case 'hours':
                $end->addHours($filter['query_1']);
                break;
            case 'days':
                $end->addDays($filter['query_1'])->endOfDay();
                break;

            case 'months':
                $end->addMonths($filter['query_1'])->endOfDay();
                break;

            case 'years':
                $end->addYears($filter['query_1'])->endOfDay();
                break;

            default:
                $end->addDays($filter['query_1'])->endOfDay();
                break;
        }

        return $query->whereBetween($filter['column'], [$begin, $end], $filter['match']);
    }

    public function inThePeroid($filter, $query)
    {
        $begin = now();
        $end = now();

        switch ($filter['query_1']) {
            case 'today':
                $begin->startOfDay();
                $end->endOfDay();
                break;
            case 'yesterday':
                $begin->subDay(1)->startOfDay();
                $end->subDay(1)->endOfDay();
                break;
            case 'tomorrow':
                $begin->addDay(1)->startOfDay();
                $end->addDay(1)->endOfDay();
                break;

            case 'last_month':
                $begin->subMonth(1)->startOfMonth();
                $end->subMonth(1)->endOfMonth();
                break;
            case 'this_month':
                $begin->startOfMonth();
                $end->endOfMonth();
                break;
            case 'next_month':
                $begin->addMonth(1)->startOfMonth();
                $end->addMonth(1)->endOfMonth();
                break;

            case 'last_year':
                $begin->subYear(1)->startOfYear();
                $end->subYear(1)->endOfYear();
                break;
            case 'this_year':
                $begin->startOfYear();
                $end->endOfYear();
                break;
            case 'next_year':
                $begin->addYear(1)->startOfYear();
                $end->addYear(1)->endOfYear();
                break;
            default:
                break;
        }

        return $query->whereBetween($filter['column'], [$begin, $end], $filter['match']);
    }

    public function equalToCount($filter, $query, $relation)
    {
        return $query->has($relation, '=', $filter['query_1']);
    }

    public function notEqualToCount($filter, $query, $relation)
    {
        return $query->has($relation, '<>', $filter['query_1']);
    }

    public function lessThanCount($filter, $query, $relation)
    {
        return $query->has($relation, '<', $filter['query_1']);
    }

    public function greaterThanCount($filter, $query, $relation)
    {
        return $query->has($relation, '>', $filter['query_1']);
    }
}
