@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white card-stats">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $onlineCount }}</h4>
                        <p class="mb-0">Online</p>
                    </div>
                    <i class="fas fa-server fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white card-stats">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $offlineCount }}</h4>
                        <p class="mb-0">Offline</p>
                    </div>
                    <i class="fas fa-server-slash fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Search by name or IP...">
            <button class="btn btn-outline-secondary" type="button">Search</button>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col">
        <div class="btn-group" role="group">
            <button class="btn btn-outline-primary active" data-filter="all">All</button>
            <button class="btn btn-outline-success" data-filter="online">Online</button>
            <button class="btn btn-outline-danger" data-filter="offline">Offline</button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">Devices ({{ $devices->count() }})</h5>
        <a href="{{ route('devices.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add Device
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>IP Address</th>
                        <th>Status</th>
                        <th>Last Check</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($devices as $device)
                    <tr>
                        <td>{{ $device->name }}</td>
                        <td>{{ $device->ip_address }}</td>
                        <td>
                            <span class="status-{{ $device->status === 'ONLINE' ? 'online' : 'offline' }}">
                                <i class="fas fa-circle me-1"></i>{{ $device->status }}
                            </span>
                        </td>
                        <td>{{ $device->updated_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('devices.show', $device) }}" class="btn btn-info btn-sm me-1"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('devices.edit', $device) }}" class="btn btn-warning btn-sm me-1"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('devices.destroy', $device) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this device?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">No devices found. <a href="{{ route('devices.create') }}">Add one</a>.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Auto refresh every 5 seconds
    setInterval(function() {
        window.location.reload();
    }, 5000);

    // Client-side search
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let rows = document.querySelectorAll('table tbody tr');
        rows.forEach(row => {
            let name = row.cells[0].textContent.toLowerCase();
            let ip = row.cells[1].textContent.toLowerCase();
            row.style.display = (name.includes(value) || ip.includes(value)) ? '' : 'none';
        });
    });

    // Filter buttons
    document.querySelectorAll('[data-filter]').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('[data-filter]').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            let filter = this.dataset.filter;
            let rows = document.querySelectorAll('table tbody tr');
            rows.forEach(row => {
                let status = row.cells[2].textContent.trim().toLowerCase();
                if (filter === 'all' || status.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection

