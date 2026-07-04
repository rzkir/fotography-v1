<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Upload Limits
    |--------------------------------------------------------------------------
    |
    | Maximum image upload size in kilobytes for dashboard uploads.
    |
    */

    'image_max_kilobytes' => (int) env('UPLOAD_IMAGE_MAX_KB', 5120),

    /*
    |--------------------------------------------------------------------------
    | Account Storage Quota
    |--------------------------------------------------------------------------
    |
    | Total storage quota in megabytes for each dashboard account.
    |
    */

    'storage_quota_megabytes' => (int) env('UPLOAD_STORAGE_QUOTA_MB', 5120),

];
