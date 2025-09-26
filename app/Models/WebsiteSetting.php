<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $fillable = [
        'website_name',
        'website_description',
        'whatsapp_cs',
        'phone_1',
        'phone_2',
        'email_1',
        'email_2',
        'address',
        'background_image',
        'background_type',
        'background_color'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the first website setting record
     */
    public static function getSettings()
    {
        return self::first() ?? self::create([
            'website_name' => 'Helpdesk Puskomedia',
            'website_description' => 'Sistem bantuan teknis untuk Puskomedia',
            'whatsapp_cs' => null,
            'phone_1' => null,
            'phone_2' => null,
            'email_1' => null,
            'email_2' => null,
            'address' => null,
            'background_image' => null,
            'background_type' => 'gradient',
            'background_color' => null
        ]);
    }

    /**
     * Update website settings
     */
    public static function updateSettings($data)
    {
        $settings = self::getSettings();
        $settings->update($data);
        return $settings;
    }
}
