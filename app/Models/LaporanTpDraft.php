<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class LaporanTpDraft extends Model
{
    use LogsActivity;
    
    protected $table = 'laporan_tp_draft';
    protected $guarded = ['id'];

    public function Cu()
    {
        return $this->belongsTo('App\Models\Cu','no_ba','no_ba')->select('id','no_ba','name')->withTrashed();
    }

    public function Tp()
    {
        return $this->belongsTo('App\Models\Cu','no_tp','no_tp')->select('id','no_tp','name')->withTrashed();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

}
