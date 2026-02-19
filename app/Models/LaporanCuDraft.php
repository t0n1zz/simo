<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class LaporanCuDraft extends Model
{
    use LogsActivity;

    protected $table = 'laporan_cu_draft';
    protected $guarded = ['id'];

    public static $rules = [
        'periode' => 'required',
    ];

    public function Cu()
    {
        return $this->belongsTo('App\Models\Cu','no_ba','no_ba')->select('id','no_ba','name')->withTrashed();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
