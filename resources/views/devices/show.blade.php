@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-eye me-2 text-info"></i>{{ $device->name }}
                </h5>
                <span class="badge bg-{{ $device->status === 'ONLINE' ? 'success' : 'danger' }}">
                    {{ $device->status }}
                </span>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td>{{ $device->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>IP Address:</strong></td>
                        <td>{{ $device->ip_address }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <span class="status-{{ $device->status === 'ONLINE' ? 'online' : 'offline' }}">
                                <i class="fas fa-circle me-1"></i>{{ $device->status }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Last Updated:</strong></td>
                        <td>{{ $device->updated_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                </table>

                <div class="d-flex gap-2 mt-4">
                    <a href="{{ route('devices.edit', $device) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <a href="{{ route('devices.index') }}" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

