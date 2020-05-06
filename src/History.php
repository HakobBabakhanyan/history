<?php


namespace HakobBabakhanyan\History;


trait History
{

    /***
     * @param  array  $options
     *
     * @return bool
     */
    public  function save(array $options = []){

        @$this->history($options);

        return parent::save($options);
    }

    protected function history(array $options = []) {
        if(isset($this->history_columns) && count($this->history_columns)) {
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

    public function histories(){
        return $this->morphMany(\HakobBabakhanyan\History\Models\History::class,'history');
    }

}
