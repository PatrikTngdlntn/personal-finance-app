<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Wallet;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Budget;
use App\Models\Subscription;
use App\Models\Saving;
use App\Models\AdminLog;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // casts
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // Wallet
    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    // Category
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    // Transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Budget
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }

    // Subscription
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Saving
    public function savings()
    {
        return $this->hasMany(Saving::class);
    }

    // sebagai admin (yang melakukan aksi)
    public function adminLogs()
    {
        return $this->hasMany(AdminLog::class, 'admin_id');
    }

    // sebagai target user
    public function targetLogs()
    {
        return $this->hasMany(AdminLog::class, 'target_user_id');
    }
}
