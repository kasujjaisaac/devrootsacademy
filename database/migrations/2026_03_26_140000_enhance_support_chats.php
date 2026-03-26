<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->string('reference')->nullable()->after('id');
            $table->string('category')->nullable()->after('subject');
            $table->string('priority')->default('normal')->after('category');
            $table->timestamp('last_message_at')->nullable()->after('status');
            $table->timestamp('resolved_at')->nullable()->after('last_message_at');
            $table->index('reference');
            $table->index('category');
        });

        DB::statement("ALTER TABLE chats MODIFY status VARCHAR(50) NOT NULL DEFAULT 'pending_admin'");

        Schema::table('messages', function (Blueprint $table) {
            $table->timestamp('read_at')->nullable()->after('message');
            $table->index('read_at');
        });

        DB::table('chats')->orderBy('id')->get()->each(function ($chat) {
            $lastMessage = DB::table('messages')
                ->where('chat_id', $chat->id)
                ->latest('created_at')
                ->first();

            $status = match ($chat->status) {
                'closed' => 'resolved',
                default => $lastMessage && $lastMessage->is_admin ? 'pending_student' : 'pending_admin',
            };

            DB::table('chats')
                ->where('id', $chat->id)
                ->update([
                    'reference' => $chat->reference ?: 'SUP-'.now()->format('Ymd').'-'.str_pad((string) $chat->id, 6, '0', STR_PAD_LEFT),
                    'category' => $chat->category ?: 'general',
                    'priority' => $chat->priority ?: 'normal',
                    'status' => $status,
                    'last_message_at' => $lastMessage->created_at ?? $chat->updated_at,
                    'resolved_at' => $chat->status === 'closed' ? ($chat->updated_at ?? now()) : null,
                ]);
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex(['read_at']);
            $table->dropColumn('read_at');
        });

        Schema::table('chats', function (Blueprint $table) {
            $table->dropIndex(['reference']);
            $table->dropIndex(['category']);
            $table->dropIndex(['status']);
            $table->dropColumn(['reference', 'category', 'priority', 'last_message_at', 'resolved_at']);
        });

        DB::statement("ALTER TABLE chats MODIFY status ENUM('open','closed') NOT NULL DEFAULT 'open'");
    }
};
