@push('styles')
<style>
.acc-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}
.acc-input {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    color: #111827;
    transition: border-color .15s;
    background: #fafafa;
    box-sizing: border-box;
}
.acc-input:focus {
    outline: none;
    border-color: #10b981;
    background: white;
}
.acc-input-err { border-color: #ef4444 !important; }
.acc-err { color: #dc2626; font-size: 12px; margin-top: 4px; }

.acc-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 22px;
    background: var(--gradient-primary);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    transition: opacity .15s;
    font-family: inherit;
}
.acc-btn-primary:hover { opacity: .88; }

.acc-nav-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    color: #4b5563;
    text-decoration: none;
    transition: background .15s, color .15s;
}
.acc-nav-item:hover { background: #f0fdf4; color: #059669; }
.acc-nav-item--active { background: #dcfce7; color: #166534; font-weight: 700; }
.acc-nav-item i { width: 16px; text-align: center; font-size: 14px; }

@media (max-width: 768px) {
    .container > div[style*="grid-template-columns:220px"] {
        grid-template-columns: 1fr !important;
    }
    aside[style*="sticky"] { position: static !important; }
}
</style>
@endpush
