<?php

namespace App\Models;

class Configuration
{
    protected $fillable = [
        'send_auto',
        'cron',
        'decimal',
        'token_cpe',
        'date_token_cpe',
        'autopayed_document',
        'autopayed_sale_note',
        'autopayed_quotation_to_document',
        'enable_online_host',
        'sync_host_type',
        'online_host',
        'sync_online_host_token'
    ];

    public static function first()
    {
        $configurations = [
            [
                'id' => 1,
                'send_auto' => 0,
                'cron' => 0,
                'decimal' => 2,
                'created_at' => null,
                'updated_at' => '2025-06-02 15:41:52',
                'token_cpe' => 'eyJraWQiOiJhcGkuc3VuYXQuZ29iLnBlLmtpZDEwMSIsInR5cCI6IkpXVCIsImFsZyI6IlJTMjU2In0.eyJzdWIiOiIxMDJiZTgzMi1kODA0LTQxMmYtYTQ3Ni04ZTU2MmM4N2Q0YzgiLCJhdWQiOiJbe1wiYXBpXCI6XCJodHRwczpcL1wvYXBpLnN1bmF0LmdvYi5wZVwiLFwicmVjdXJzb1wiOlt7XCJpZFwiOlwiXC92MVwvY29udHJpYnV5ZW50ZVwvY29udHJpYnV5ZW50ZXNcIixcImluZGljYWRvclwiOlwiMFwiLFwiZ3RcIjpcIjAxMDAwMFwifV19XSIsIm5iZiI6MTc0NTQ1MjY5NCwiY2xpZW50SWQiOiIxMDJiZTgzMi1kODA0LTQxMmYtYTQ3Ni04ZTU2MmM4N2Q0YzgiLCJpc3MiOiJodHRwczpcL1wvYXBpLXNlZ3VyaWRhZC5zdW5hdC5nb2IucGVcL3YxXC9jbGllbnRlc2V4dHJhbmV0XC8xMDJiZTgzMi1kODA0LTQxMmYtYTQ3Ni04ZTU2MmM4N2Q0YzhcL29hdXRoMlwvdG9rZW5cLyIsImV4cCI6MTc0NTQ1NjI5NCwiZ3JhbnRUeXBlIjoiY2xpZW50X2NyZWRlbnRpYWxzIiwiaWF0IjoxNzQ1NDUyNjk0fQ.KXTS-22iq0rRBV409Parbgmw_9MjnxuukRXms1Lx5YNnwO7EVlzACZ41VLZKxloA9ZzPmdn5LnS-2P-TiqTrFmnjyvGEFQcNW6x15pWMh6MEKUT1A6KDQRCjEK6WiFTfBPoDHc6z0SlXoAQYFA-qe6QjyR_485HZi_liwfiYDyJm80pG2SCFmFK-3Zz4xiWEV3Xzd3qYt41lfTCaM5mlF_vQVquR-HGe2tSM9x0HpO0CkMfBRDJX5SaEr4ts1BkhJ9m9xfTtOkyOfFA8ZR76zxyazFhMDTlHFU7V7xLpn-XeHPcSMaznn1dzL2voUmLBS7mmkd0g5hsuP-1t3NGs2Q',
                'date_token_cpe' => '2025-04-23 18:58:13',
                'autopayed_document' => 0,
                'autopayed_sale_note' => 0,
                'autopayed_quotation_to_document' => 0,
                'enable_online_host' => 0,
                'sync_host_type' => 'sender',
                'online_host' => 'http://domain.test/',
                'sync_online_host_token' => '8TPFNZfOi0baq9kF6LZM2pcHzsGB6Apz20TTvs3SYaWr89k4Yh',
                'default_included_igv' => 0,
                'default_sale_affectation_igv_type_id' => '20',
                'default_purchase_affectation_igv_type_id' => '10',
            ],
        ];

        return (object)($configurations[0]);
    }
}
