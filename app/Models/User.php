<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Wallet;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\Budget;
use App\Models\Subscription;
use App\Models\Saving;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    //  Wallet
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

    // Transfer
    public function transfers()
    {
        return $this->hasMany(Transfer::class);
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
}
