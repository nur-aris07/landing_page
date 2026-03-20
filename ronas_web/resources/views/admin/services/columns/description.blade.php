<span style="color:var(--text-muted); font-size:.88rem; line-height:1.5;">
    {{ \Illuminate\Support\Str::limit(strip_tags((string) $service->description), 100) ?: '-' }}
</span>