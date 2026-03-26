<?php

use App\Models\Payment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (! Schema::hasColumn('payments', 'status')) {
                $table->string('status')->default('pending')->after('payment_method');
            }
            if (! Schema::hasColumn('payments', 'gateway')) {
                $table->string('gateway')->nullable()->after('status');
            }
            if (! Schema::hasColumn('payments', 'reference')) {
                $table->string('reference')->nullable()->after('gateway');
            }
            if (! Schema::hasColumn('payments', 'merchant_reference')) {
                $table->string('merchant_reference')->nullable()->after('reference');
            }
            if (! Schema::hasColumn('payments', 'gateway_tracking_id')) {
                $table->string('gateway_tracking_id')->nullable()->after('merchant_reference');
            }
            if (! Schema::hasColumn('payments', 'currency')) {
                $table->string('currency', 3)->default('UGX')->after('gateway_tracking_id');
            }
            if (! Schema::hasColumn('payments', 'description')) {
                $table->text('description')->nullable()->after('currency');
            }
            if (! Schema::hasColumn('payments', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('description');
            }
            if (! Schema::hasColumn('payments', 'raw_response')) {
                $table->json('raw_response')->nullable()->after('paid_at');
            }
            if (! Schema::hasColumn('payments', 'callback_payload')) {
                $table->json('callback_payload')->nullable()->after('raw_response');
            }
            if (! Schema::hasColumn('payments', 'ipn_payload')) {
                $table->json('ipn_payload')->nullable()->after('callback_payload');
            }
        });

        Payment::query()
            ->orderBy('id')
            ->get()
            ->each(function (Payment $payment) {
                $payment->update([
                    'status' => Payment::STATUS_COMPLETED,
                    'gateway' => $payment->gateway ?: 'manual',
                    'reference' => $payment->reference ?: 'LEGACY-'.$payment->id,
                    'currency' => $payment->currency ?: 'UGX',
                    'paid_at' => $payment->paid_at ?: $payment->created_at,
                ]);
            });

        DB::table('payments')
            ->whereNull('gateway')
            ->update(['gateway' => 'manual']);

        DB::table('payments')
            ->whereNull('currency')
            ->update(['currency' => 'UGX']);
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $columns = [
                'status',
                'gateway',
                'reference',
                'merchant_reference',
                'gateway_tracking_id',
                'currency',
                'description',
                'paid_at',
                'raw_response',
                'callback_payload',
                'ipn_payload',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('payments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
