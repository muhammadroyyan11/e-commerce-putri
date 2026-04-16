<?php

if (! function_exists('pval')) {
    /**
     * Translate a product attribute value based on current locale.
     * Falls back to the original value if no translation found.
     *
     * Usage in Blade: {{ pval($product['care_level']) }}
     */
    function pval(?string $value): string
    {
        if (! $value) return '';

        $map = trans('product_values');

        if (is_array($map) && isset($map[$value])) {
            return $map[$value];
        }

        return $value;
    }
}
