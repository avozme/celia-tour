<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>File Image</th>
        <th>File Miniature</th>
        <th>Edit</th>
    </tr>
    @foreach ($zones as $zone)
        <tr>
            <td>{{ $zone->id }}</td>
            <td>{{ $zone->name }}</td>
            <td>{{ $zone->file_image }}</td>
            <td>{{ $zone->file_miniature }}</td>
            <td> <input type="button" value="edit" onclick="window.location.href='{{ route('zone.edit', $zone->id) }}'"> </td>
        </tr>
    @endforeach
</table>