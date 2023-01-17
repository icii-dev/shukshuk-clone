<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Events\SettingUpdated;
use TCG\Voyager\Traits\Translatable;

class Component extends Model
{
    use Translatable;

    protected $table = 'components';

    protected $guarded = [];

    protected $translatable = ['display_name', 'details'];

//    protected $dispatchesEvents = [
//        'updating' => SettingUpdated::class,
//    ];
}
