<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4">
        <h2 class="text-xl font-bold mb-4">Activity Log</h2>
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th class="py-2">When</th><th>Who</th><th>Event</th><th>Subject</th><th>Changes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                    <tr class="border-b align-top">
                        <td class="py-2">{{ $activity->created_at->format('d M Y, H:i') }}</td>
                        <td>{{ $activity->causer->name ?? 'System' }}</td>
                        <td>{{ $activity->event }}</td>
                        <td>{{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}</td>
                        <td>
                            @foreach (($activity->properties['attributes'] ?? []) as $field => $new)
                                <div>{{ $field }}: {{ $activity->properties['old'][$field] ?? '—' }} → {{ $new }}</div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $activities->links() }}</div>
    </div>
</x-app-layout>