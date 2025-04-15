@extends('layouts.main')
@section('title', 'Manajemen Mobil')
@section('content')
<div class="container mt-6">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h4>Manajemen Mobil</h4>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCarModal">Tambah Mobil</button>
        </div>
        <div class="card-body">
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: "{{ session('success') }}",
                    });
                </script>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Gambar</th>
                            <th>Merek</th>
                            <th>Model</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th>Harga Sewa</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cars as $car)
                        <tr>
                            <td>{{ $loop->iteration + ($cars->currentPage() - 1) * $cars->perPage() }}</td>
                            <td>
                                @if($car->image)
                                    <img src="{{ asset($car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" style="width: 80px; height: 60px; object-fit: cover;">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $car->brand }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->year }}</td>
                            <td>
                                <span class="badge bg-{{ $car->status == 'available' ? 'success' : 'warning' }}">
                                    {{ $car->status }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($car->rental_price, 0, ',', '.') }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editCarModal{{ $car->id }}">Edit</button>
                                <form action="{{ route('admin.cars.destroy', $car->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $car->id }}">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Edit Car Modal -->
                        <div class="modal fade" id="editCarModal{{ $car->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('admin.cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Mobil</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="brand" class="form-label">Merek</label>
                                                <input type="text" class="form-control" id="brand" name="brand" value="{{ $car->brand }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="model" class="form-label">Model</label>
                                                <input type="text" class="form-control" id="model" name="model" value="{{ $car->model }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="year" class="form-label">Tahun</label>
                                                <input type="number" class="form-control" id="year" name="year" value="{{ $car->year }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="available" {{ $car->status == 'available' ? 'selected' : '' }}>Tersedia</option>
                                                    <option value="rented" {{ $car->status == 'rented' ? 'selected' : '' }}>Disewa</option>
                                                    <option value="maintenance" {{ $car->status == 'maintenance' ? 'selected' : '' }}>Perawatan</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="rental_price" class="form-label">Harga Sewa</label>
                                                <input type="number" class="form-control" id="rental_price" name="rental_price" value="{{ $car->rental_price }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Deskripsi</label>
                                                <textarea class="form-control" id="description" name="description" required>{{ $car->description }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Gambar</label>
                                                <input type="file" class="form-control" id="image" name="image">
                                                @if($car->image)
                                                    <div class="mt-2">
                                                        <img src="{{ asset($car->image) }}" alt="Current Image" style="max-width: 200px; max-height: 150px;">
                                                        <p class="text-muted mt-1">Gambar saat ini</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-warning me-2">Perbarui</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-5">
                {{ $cars->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Car Modal -->
<div class="modal fade" id="addCarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Mobil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="brand" class="form-label">Merek</label>
                        <input type="text" class="form-control" id="brand" name="brand" required>
                    </div>
                    <div class="mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" name="model" required>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="year" name="year" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="available">Tersedia</option>
                            <option value="rented">Disewa</option>
                            <option value="maintenance">Perawatan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="rental_price" class="form-label">Harga Sewa</label>
                        <input type="number" class="form-control" id="rental_price" name="rental_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        $('.btn-delete').click(function() {
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data mobil akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection

@endsection