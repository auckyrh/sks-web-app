@php
    $isCreated = $activity->description === 'created';
    $old  = $isCreated ? [] : ($activity->attribute_changes?->get('old', []) ?? []);
    $new  = $activity->attribute_changes?->get('attributes', []) ?? [];
    $keys = $isCreated ? array_keys($new) : array_keys($old);
@endphp

<div style="font-size:0.875rem;">
    @if(empty($keys))
        <p style="color:#6b7280; text-align:center; padding:1rem 0;">Tidak ada detail perubahan.</p>
    @else
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="border-bottom:2px solid #e5e7eb;">
                    <th style="text-align:left; padding:0.5rem 0.75rem; color:#6b7280; font-weight:600; width:35%;">Field</th>
                    <th style="text-align:left; padding:0.5rem 0.75rem; color:#dc2626; font-weight:600; width:32.5%;">Sebelum</th>
                    <th style="text-align:left; padding:0.5rem 0.75rem; color:#16a34a; font-weight:600; width:32.5%;">Sesudah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keys as $field)
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:0.5rem 0.75rem; font-weight:600; color:#374151;">
                            {{ $field }}
                        </td>
                        <td style="padding:0.5rem 0.75rem; color:#dc2626; background:#fef2f2; font-family:monospace;">
                            {{ $old[$field] ?? '—' }}
                        </td>
                        <td style="padding:0.5rem 0.75rem; color:#16a34a; background:#f0fdf4; font-family:monospace;">
                            {{ $new[$field] ?? '—' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:1rem; font-size:0.75rem; color:#9ca3af; text-align:right;">
            {{ $activity->created_at->format('d M Y, H:i:s') }}
            @if($activity->causer)
                · oleh <strong>{{ $activity->causer->full_name }}</strong>
            @endif
        </div>
    @endif
</div>
