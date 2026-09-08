<?php

return [
    // Where enquiry / application notifications are sent. Falls back to the mail "from" address.
    'contact_admin_email' => env('CONTACT_ADMIN_EMAIL', env('MAIL_FROM_ADDRESS')),
    'careers_admin_email' => env('CAREERS_ADMIN_EMAIL', env('MAIL_FROM_ADDRESS')),
    'admin_name'          => env('FORMS_ADMIN_NAME', 'Glass Wall Systems'),
];
