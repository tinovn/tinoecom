<x-tinoecom::alert
    icon="untitledui-exclamation-triangle"
    :title="__('tinoecom::words.attention_needed')"
    :message="__('tinoecom::words.feature_enabled', ['feature' => \Illuminate\Support\Str::title($getFeature())])"
/>
