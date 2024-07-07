<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsAppMessageModel extends Model
{
    protected $table = 'whatsapp';
    protected $primaryKey = 'whatsapp_id';
    protected $fillable = ['whatsapp_nomor', 'whatsapp_pesan', 'whatsapp_file'];
    public $timestamps = true;
}
