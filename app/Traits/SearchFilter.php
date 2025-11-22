<?php

namespace App\Traits;

trait SearchFilter
{
    // Apply search filter to query
    public function scopeSearch($query, $search)
    {
        if (!$search) {
            return $query;
        }

        // Get searchable columns from model
        $searchable = $this->searchable ?? ['name', 'title'];

        return $query->where(function($q) use ($search, $searchable) {
            foreach ($searchable as $column) {
                $q->orWhere($column, 'LIKE', "%{$search}%");
            }
        });
    }

    // Apply filters to query
    public function scopeFilter($query, array $filters)
    {
        foreach ($filters as $key => $value) {
            if ($value !== null && $value !== '') {
                $query->where($key, $value);
            }
        }

        return $query;
    }

    // Apply date range filter
    public function scopeDateRange($query, $startDate, $endDate, $column = 'created_at')
    {
        if ($startDate) {
            $query->whereDate($column, '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate($column, '<=', $endDate);
        }

        return $query;
    }
}