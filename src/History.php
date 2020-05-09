<?php


namespace HakobBabakhanyan\History;


use function foo\func;

trait History
{

    public static function boot()
    {
        parent::boot();

        // todo deleted
        self::updating(function($model){
            @$model->history_save();
        });
    }

    /**
     *
     */
    protected function history_save() :void {

        if($this->exists && isset($this->history_columns) && count($this->history_columns)) {
            $dirty = $this->getDirty();
            foreach ($this->history_columns as $column) {
                if (isset($dirty[$column])) {
                    $data = [
                      'history_type' => get_class($this),
                      'history_id' => $this->getAttribute('id'),
                      'column' => $column,
                      'old_value' =>  $this->getOriginal($column),
                      'new_value' =>  $this->getAttribute($column)
                    ];
                    \HakobBabakhanyan\History\Models\History::query()->create($data);
                }

            }
        }
    }

    /**
     * @return mixed
     */
    public function histories(){
        return $this->morphMany(\HakobBabakhanyan\History\Models\History::class,'history');
    }

    /**
     * @param string $column
     * @param $data
     *
     * @return mixed
     */
    public function get_history_value(string $column, $data) {

        $value  =  $this->histories()->where([['created_at','>', $data], ['column',$column]])->select('old_value')->limit(1)->first();

        return $value ? $value->old_value : $this->$column;
    }

}
