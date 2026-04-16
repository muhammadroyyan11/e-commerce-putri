<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_type')->nullable()->after('payment_method_id');
            $table->string('payment_token')->nullable()->after('payment_type');
            $table->string('payment_va_number')->nullable()->after('payment_token');
            $table->text('payment_qr_url')->nullable()->after('payment_va_number');
            $table->timestamp('payment_expired_at')->nullable()->after('payment_qr_url');
        });
    }
    public function down(): void {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_type','payment_token','payment_va_number','payment_qr_url','payment_expired_at']);
        });
    }
};
