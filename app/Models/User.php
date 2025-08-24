<?php

namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class User extends Authenticatable implements FilamentUser
{
    use HasRoles;
    
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'is_active',
        'last_login_at',
        'last_login_ip',
        'login_attempts',
        'locked_until',
        'password_changed_at',
        'force_password_change',
        'security_notes',
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
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'locked_until' => 'datetime',
            'password_changed_at' => 'datetime',
            'force_password_change' => 'boolean',
        ];
    }

    /**
     * Check if user is superadmin
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Check if user is admin or superadmin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(['admin', 'super_admin']);
    }

    /**
     * Check if user can access panel (backward compatibility)
     */
    public function canAccessPanel(Panel $panel = null): bool
    {
        return $this->is_active && 
               $this->isAdmin() && 
               !$this->isLocked();
    }

    /**
     * Check if account is locked
     */
    public function isLocked(): bool
    {
        return $this->locked_until && $this->locked_until->isFuture();
    }

    /**
     * Lock account for specified minutes
     */
    public function lockAccount(int $minutes = 60): void
    {
        $this->update([
            'locked_until' => now()->addMinutes($minutes)
        ]);
        
        Log::warning('User account locked', [
            'user_id' => $this->id,
            'username' => $this->username,
            'locked_until' => $this->locked_until
        ]);
    }

    /**
     * Unlock account
     */
    public function unlockAccount(): void
    {
        $this->update(['locked_until' => null, 'login_attempts' => 0]);
        
        Log::info('User account unlocked', [
            'user_id' => $this->id,
            'username' => $this->username
        ]);
    }

    /**
     * Increment login attempts
     */
    public function incrementLoginAttempts(): void
    {
        $this->increment('login_attempts');
        
        if ($this->login_attempts >= 5) {
            $this->lockAccount(60); // Lock for 1 hour after 5 failed attempts
        }
    }

    /**
     * Reset login attempts on successful login
     */
    public function resetLoginAttempts(): void
    {
        $this->update(['login_attempts' => 0, 'locked_until' => null]);
    }

    /**
     * Record successful login
     */
    public function recordLogin(string $ip): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip,
            'login_attempts' => 0,
            'locked_until' => null
        ]);
        
        Log::info('User login recorded', [
            'user_id' => $this->id,
            'username' => $this->username,
            'ip' => $ip,
            'timestamp' => now()
        ]);
    }

    /**
     * Check password strength
     */
    public static function isStrongPassword(string $password): bool
    {
        $config = config('security.password_policy');
        
        return strlen($password) >= $config['min_length'] &&
               preg_match('/[A-Z]/', $password) &&
               preg_match('/[a-z]/', $password) &&
               preg_match('/[0-9]/', $password) &&
               preg_match('/[^A-Za-z0-9]/', $password) &&
               !self::containsCommonPasswords($password) &&
               !self::containsSequentialChars($password);
    }

    /**
     * Check if password contains common weak passwords
     */
    private static function containsCommonPasswords(string $password): bool
    {
        $commonPasswords = [
            'password', '123456', 'qwerty', 'admin', 'administrator',
            'welcome', 'login', 'root', 'user', 'guest', 'test',
            'demo', 'sample', 'default', 'changeme', 'secret'
        ];
        
        $lowerPassword = strtolower($password);
        
        foreach ($commonPasswords as $weak) {
            if (str_contains($lowerPassword, $weak)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if password contains sequential characters
     */
    private static function containsSequentialChars(string $password): bool
    {
        $sequences = ['123', 'abc', 'qwe', 'asd', 'zxc'];
        $lowerPassword = strtolower($password);
        
        foreach ($sequences as $seq) {
            if (str_contains($lowerPassword, $seq)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Force password change on next login
     */
    public function forcePasswordChange(): void
    {
        $this->update(['password_changed_at' => null]);
    }

    /**
     * Check if password needs to be changed (older than 90 days)
     */
    public function needsPasswordChange(): bool
    {
        return !$this->password_changed_at || 
               $this->password_changed_at->lt(now()->subDays(90));
    }
}
