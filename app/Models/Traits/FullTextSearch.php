<?php
namespace App\Models\Traits;

trait FullTextSearch
{
    /**
     * Replaces spaces with full text search wildcards
     *
     * @param string $term
     * @return string
     */
    protected function fullTextWildcards($term)
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);

        $words = explode(' ', $term);

        foreach ($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if (strlen($word) >= 3) {
                $words[$key] = '+' . $word;
            }
        }

        $searchTerm = implode(' ', $words);

        return $searchTerm;
    }

    /**
     * Scope a query that matches a full text search of term.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @param string $columns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $term, $columns = null)
    {

        if (empty($columns)) {
            $columns = implode(',', $this->searchable);
        }
        $keyword = $this->fullTextWildcards($term);
        $query->whereRaw("MATCH ({$columns}) AGAINST ('{$keyword}' IN BOOLEAN MODE)");

        return $query;
    }

    /**
     * Scope a query that matches a full text search of term.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @param string $columns
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrSearch($query, $term, $columns = null)
    {

        if (empty($columns)) {
            $columns = implode(',', $this->searchable);
        }
        $keyword = $this->fullTextWildcards($term);
        $query->orWhereRaw("MATCH ({$columns}) AGAINST ('{$keyword}' IN BOOLEAN MODE)");

        return $query;
    }
}
