<?php

    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class Admin extends Authenticatable
    {
        use Notifiable;
        protected $table = 'tbl_admins';

        protected $guard = 'admin';

        protected $fillable = [
            'name', 'email', 'password','organization' ,'gst_no' ,'pan_no' ,'contact_no' ,'address' ,'type' ,'category' ,'owner' , 'is_active'
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];
    }