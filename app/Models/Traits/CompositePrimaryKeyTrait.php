<?php
namespace App\Models\Traits;

use \Illuminate\Database\Eloquent\Builder;

trait CompositePrimaryKeyTrait
{
    /**
     * 複合キーに対応させるために使用する。
     * Set the keys for a save update query.
     *
     * @param  Builder  $query
     * @return Builder
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        if (is_array($this->primaryKey)) {
            foreach ($this->primaryKey as $pk) {
                $query->where($pk, '=', $this->original[$pk]);
            }
            return $query;
        } else {
            return parent::setKeysForSaveQuery($query);
        }
    }
}
