<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
    <div class="container mt-4">
        <h1 class="mb-4">Todo List</h1>

        <!-- Form Tambah/Update Todo -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title" id="formTitle">{{ isset($todo) ? 'Edit Todo' : 'Tambah Todo' }}</h5>
                <form action="{{ isset($todo) ? route('todo.update', $todo->id) : route('todo.store') }}"
                    method="POST">
                    @csrf
                    @if (isset($todo))
                        @method('POST') <!-- Atur method untuk update jika sudah ada todo -->
                    @endif
                    <input type="hidden" name="id" id="todoId" value="{{ $todo->id ?? '' }}"> <!-- Untuk ID -->
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ $todo->name ?? old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prioritas</label>
                        <select name="prioritas" class="form-select" required>
                            <option value="1" {{ isset($todo) && $todo->prioritas == 1 ? 'selected' : '' }}>1
                                (Terendah)</option>
                            <option value="2" {{ isset($todo) && $todo->prioritas == 2 ? 'selected' : '' }}>2
                            </option>
                            <option value="3" {{ isset($todo) && $todo->prioritas == 3 ? 'selected' : '' }}>3
                            </option>
                            <option value="4" {{ isset($todo) && $todo->prioritas == 4 ? 'selected' : '' }}>4
                            </option>
                            <option value="5" {{ isset($todo) && $todo->prioritas == 5 ? 'selected' : '' }}>5
                                (Tertinggi)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">{{ isset($todo) ? 'Update' : 'Tambah' }}</button>
                    @isset($todo)
                        <a href="{{ route('todo.index') }}" class="btn btn-secondary">Batal</a>
                    @endisset
                </form>
            </div>
        </div>

        <!-- Daftar Todo -->
        <form action="{{ route('todo.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari Todo..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Prioritas</th>
                    <th>Status</th>
                    <th>Tanggal Dicentang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($todos as $index => $todo)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $todo->name }}</td>
                        <td>
                            @for ($i = 0; $i < $todo->prioritas; $i++)
                                <i class="bi bi-star-fill text-warning"></i>
                            @endfor
                        </td>
                        <td>
                            @if (!$todo->status)
                                <form action="{{ route('todo.updateStatus', $todo->id) }}" method="POST">
                                    @csrf
                                    <input type="checkbox" name="status" onChange="this.form.submit()">
                                </form>
                            @else
                                ✅ Selesai
                            @endif
                        </td>
                        <td>
                            {{ $todo->tgl_dicentang ? 'Dicentang pada: ' . $todo->tgl_dicentang : 'Belum selesai' }}
                        </td>
                        <td>
                            @if (!$todo->status)
                                <a href="{{ route('todo.edit', $todo->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('todo.destroy', $todo->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus Todo ini?')">Hapus</button>
                                </form>
                            @else
                                <span class="text-success">✅ Selesai</span>
                                <form action="{{ route('todo.destroy', $todo->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus Todo ini?')">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
