<?php

namespace HakobBabakhanyan\History\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table;

    protected $fillable = [
        'history_type',
        'history_id' ,
        'column',
        'old_value' ,
        'new_value'
    ];

    public function __construct(array $attributes = [])
    {
        $this->table = config('history.table_name');
        parent::__construct($attributes);
    }

    public function histories(){
        return $this->morphTo();
    }

}
