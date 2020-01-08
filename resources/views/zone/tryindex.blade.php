<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>File Image</th>
        <th>File Miniature</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    @foreach ($zones as $zone)
        <tr>
            <td>{{ $zone->id }}</td>
            <td>{{ $zone->name }}</td>
            <td> <img src='{{ url('img/zones/images/'.$zone->file_image) }}' alt='file_image' height="100" width="150"> </td>
            <td> <img src='{{ url('img/zones/miniatures/'.$zone->file_miniature) }}' alt='file_miniature' height="100" width="150"> </td>
            <td> <input type="button" value="Edit" onclick="window.location.href='{{ route('zone.edit', $zone->id) }}'"> </td>
            <td> <input type="button" value="Delete" onclick="window.location.href='{{ route('zone.delete', $zone->id) }}'"> </td>
        </tr>
    @endforeach
</table>
<input type="button" value="New" onclick="window.location.href='{{ route('zone.create') }}'">