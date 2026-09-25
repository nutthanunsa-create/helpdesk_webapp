<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'helpdesk_case_id',
        'user_id',
        'message',
        'attachment_path',
    ];

    public function case()
    {
        return $this->belongsTo(HelpdeskCase::class, 'helpdesk_case_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
