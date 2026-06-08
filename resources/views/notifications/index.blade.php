@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white rounded-top-4 d-flex justify-content-between align-items-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="mb-0">
                        <i class="fas fa-bell me-2"></i> Notifications
                    </h5>
                    <div>
                        <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-light btn-sm me-1">
                                <i class="fas fa-check-double me-1"></i> Mark All as Read
                            </button>
                        </form>
                        <form action="{{ route('notifications.destroy-all') }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete all notifications?')">
                                <i class="fas fa-trash-alt me-1"></i> Delete All
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($notifications->count() > 0)
                        <div class="list-group">
                            @foreach($notifications as $notification)
                                <div class="list-group-item list-group-item-action {{ !$notification->is_read ? 'bg-light border-start border-3 border-primary' : '' }}">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-2">
                                                @if(!$notification->is_read)
                                                    <span class="badge bg-primary me-2">New</span>
                                                @endif
                                                <h6 class="mb-0">{{ $notification->title }}</h6>
                                            </div>
                                            <p class="mb-1">{{ $notification->message }}</p>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i> {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div class="ms-3">
                                            @if(!$notification->is_read)
                                                <form action="{{ route('notifications.mark-read', $notification->notification_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Mark as Read">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('notifications.destroy', $notification->notification_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Delete this notification?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-bell-slash fa-3x mb-3"></i>
                            <h5>No Notifications</h5>
                            <p>You don't have any notifications at this time.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .list-group-item {
        transition: all 0.3s ease;
        border-radius: 8px;
        margin-bottom: 8px;
    }
    .list-group-item:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
</style>
@endsection
