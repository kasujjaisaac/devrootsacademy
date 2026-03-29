<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'full_name',
        'first_name',
        'last_name',
        'email',
        'subject',
        'message',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public static function createFromSubmission(array $attributes): self
    {
        $model = new static();
        $columns = static::availableColumns();

        $payload = [
            'email' => $attributes['email'] ?? null,
            'subject' => $attributes['subject'] ?? null,
            'message' => $attributes['message'] ?? null,
        ];

        $name = trim((string) ($attributes['name'] ?? ''));

        if (in_array('name', $columns, true)) {
            $payload['name'] = $name;
        } elseif (in_array('full_name', $columns, true)) {
            $payload['full_name'] = $name;
        } else {
            [$firstName, $lastName] = static::splitName($name);

            if (in_array('first_name', $columns, true)) {
                $payload['first_name'] = $firstName;
            }

            if (in_array('last_name', $columns, true)) {
                $payload['last_name'] = $lastName;
            }
        }

        $filteredPayload = array_filter(
            $payload,
            static fn ($value, $column) => $value !== null && in_array($column, $columns, true),
            ARRAY_FILTER_USE_BOTH
        );

        $model->fill($filteredPayload);
        $model->save();

        return $model;
    }

    public function getNameAttribute($value): string
    {
        if (filled($value)) {
            return $value;
        }

        if (filled($this->attributes['full_name'] ?? null)) {
            return $this->attributes['full_name'];
        }

        $firstName = trim((string) ($this->attributes['first_name'] ?? ''));
        $lastName = trim((string) ($this->attributes['last_name'] ?? ''));
        $composedName = trim($firstName.' '.$lastName);

        return $composedName !== '' ? $composedName : 'Website visitor';
    }

    protected static function availableColumns(): array
    {
        static $columns = null;

        if ($columns !== null) {
            return $columns;
        }

        return $columns = Schema::getColumnListing((new static())->getTable());
    }

    protected static function splitName(string $name): array
    {
        $parts = preg_split('/\s+/', trim($name), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        if ($parts === []) {
            return ['', ''];
        }

        $firstName = array_shift($parts);
        $lastName = implode(' ', $parts);

        return [$firstName, $lastName];
    }
}
