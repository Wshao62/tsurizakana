<?php
namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;

trait Updater
{
    /**
     * 登録
     *
     * @param  mixed $attributes
     * @param  function $before_function
     * @param  function $after_function
     *
     * @return bool
     */
    public function updater(array $attributes, $before_function = null, $after_function = null, $success_function = null, $fail_function = null)
    {
        $rtn = $this;
        DB::beginTransaction();
        try {
            if (!empty($before_function)) {
                $attributes = $before_function($attributes);
            }

            foreach ($attributes as $column => $value) {
                if (!in_array($column, $this->fillable)) {
                    continue;
                }

                $this->{$column} = $value;
            }
            $this->save();
            $rtn = $this;

            if (!empty($after_function)) {
                $rtn = $after_function($rtn);
            }

            DB::commit();

            if (!empty($success_function)) {
                $rtn = $success_function($rtn);
            }

            return $rtn;
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error(get_class().':update(): '.$e->getMessage());

            if (!empty($fail_function)) {
                $fail_function($rtn);
            }

            return false;
        }
    }
}
