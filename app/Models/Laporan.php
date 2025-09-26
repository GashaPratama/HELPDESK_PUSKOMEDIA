<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'judul',
        'kategori_id',
        'url_situs',
        'kendala',
        'lampiran',         // file bukti (foto/dokumen)
        'status',
        'note',             // catatan dari admin/CS/teknisi
        'note_target_role', // role yang dituju untuk note
        'note_from_role',   // role yang membuat note
        'note_created_at',  // waktu note dibuat
        'assigned_to',      // teknisi yang ditugaskan
        'notes',            // catatan dari CS (legacy)
    ];

    /**
     * Alias agar bisa akses $laporan->deskripsi
     */
    public function getDeskripsiAttribute()
    {
        return $this->kendala;
    }

    /**
     * Alias agar bisa akses $laporan->url
     */
    public function getUrlAttribute()
    {
        return $this->url_situs;
    }

    /**
     * Alias agar bisa akses $laporan->foto (mengambil dari lampiran)
     */
    public function getFotoAttribute()
    {
        return $this->lampiran;
    }

    /**
     * Relasi ke user yang membuat laporan (customer)
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
    
    /**
     * Relasi ke teknisi yang ditugaskan
     */
    public function teknisi()
    {
        return $this->belongsTo(User::class, 'assigned_to', 'id_user');
    }

    /**
     * Relasi ke kategori laporan
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}
